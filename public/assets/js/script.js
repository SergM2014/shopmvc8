let windowWidth = document.documentElement.clientWidth,
    touchButton= document.getElementsByClassName('main-header__touch-button')[0],
    headerMenu =  document.getElementsByClassName('main-header__menu')[0],
    languagesBox = document.getElementsByClassName('main-header__language-select')[0],
    searchField = document.getElementById('search'),
    searchResultsBox = document.getElementById('search-results'),
    defaultLang = document.getElementsByName('defaultLang')[0].value,
    arrayLangsList = document.getElementsByName('languages')[0].value.split(',');




function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone(phone){
   let regexp = /\d{3}-\d{3}-\d{2}-\d{2}/;
    //if (regexp.test(phone))  return true;
    return (regexp.test(phone));

   // return false;
}

class LangForAjax{
    constructor ()
    {
        //get the Array of languages
        let langsArray = [];
        for(let i=0; i < arrayLangsList.length; i++){
            let langItem = arrayLangsList[i].split('=>');
            langsArray.push(langItem[0].trim());
        }


        this.url_lang ='';
       // this.needed_lang;
        this.langs_array = langsArray;

        this.default_lang = defaultLang;

        this.url = document.location.href;
        this.url_array = this.url.split('/');
    }

    getLanguage(){
        for(let i=0; i< this.langs_array.length; i++){
            let match = this.url_array.indexOf(this.langs_array[i]);
            if (match>=0) { this.needed_lang = this.langs_array[i];  break; }
        }

        if(typeof this.needed_lang != "undefined" &&
            (typeof this.needed_lang != "undefined" && this.needed_lang != this.default_lang))  { this.url_lang = '/'+this.needed_lang; }

        return this.url_lang;
    }
}

touchButton.addEventListener('click', function(){
  headerMenu.classList.add('showMenu');

});




if(windowWidth < 751){
    document.addEventListener('click', function(e){
        if ( !e.target.closest('.main-header__touch-button') && !e.target.closest('.main-header__menu')){

            headerMenu.classList.remove('showMenu');
        }
    })
}

//toggle languages
languagesBox.addEventListener('click', function(){
    document.getElementsByClassName('main-header__language-select-dropdown')[0].classList.toggle('hidden')
});

document.body.addEventListener('click', function(e){

//catch the refresh captcha event
    if(e.target.id == "captcha_img") {
        fetch(
            '/index/refreshCaptcha', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#captcha-img-container').innerHTML = html;
            })
    }


//remove search-result is clicke outside the search-container
    if(!e.target.closest('.main-header__search-container')){
        searchResultsBox.className = "main-header__search-result-box--hidden";
        searchResultsBox.innerHTML ='';
    }
//show product preview
    if(e.target.closest('.search-results__item')){
        let elem = e.target.closest('.search-results__item');
        let id = elem.dataset.id;

        let darkLayer = document.createElement('div'); // слой затемнения
        darkLayer.className = 'background-shadow'; // class чтобы подхватить стиль
        darkLayer.id = 'background-shadow';
        document.body.appendChild(darkLayer); // включаем затемнение

        let modalwindow = document.createElement('section');
        modalwindow.className = 'product-window';
        modalwindow.id= 'product-window';
        document.body.appendChild(modalwindow);

        let formData = new FormData;
        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/product/index";

        formData.append('id', id);
        fetch(url, {
            method: 'POST',
            body:formData
        })
            .then( responce => responce.text())
            .then(html => modalwindow.innerHTML = html)


    }

    if(e.target.id == "close-preview-product"){
        document.getElementById('product-window').remove();
        document.getElementById('background-shadow').remove();
    }




    //vertical menu slideUp/Down
    if(e.target.closest('.left-menu')){
        {
            if (!e.target.classList.contains('left-menu__contains-subcatetegories-sign')) return;

            let currentMenuItemId = e.target.closest('li').dataset.categoryId;
            let currentMenuItemParentId = e.target.closest('li').dataset.parentId;
            let parentUl = e.target.closest('ul');
            let childrenLi = parentUl.querySelectorAll('[data-parent-id="'+currentMenuItemParentId+'"]');

            if(! childrenLi) return;
            for (let i=0; i<childrenLi.length; i++){
                let ul = childrenLi[i].querySelector('ul');
                if(childrenLi[i].dataset.categoryId != currentMenuItemId){
                    if (ul){
                        ul.classList.add('hidden');
                        let sign = ul.closest('li').querySelector('.left-menu__contains-subcatetegories-sign');
                        sign.classList.remove('hidden');
                    }
                } else {
                    if(ul) {
                        ul.classList.remove('hidden');
                        let sign = ul.closest('li').querySelector('.left-menu__contains-subcatetegories-sign');
                        sign.classList.add('hidden');
                    }
                }
            }

        }
    }

    //add item to the small busket
    if(e.target.id == "add-item"){

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/busket/add";

        let id= e.target.dataset.item;

        let price = document.getElementById('the_price').innerText;


        let formData = new FormData;
        formData.append('id', id);
        formData.append('price', price);
        formData.append('ajax', true);

        fetch( url,
            {
                method: "POST",
                body: formData,
                credentials:'same-origin'
            })
            .then(responce => responce.text())
            .then(html => document.getElementById('busket-info').innerHTML = html)

    }
    //close busket
    if(e.target.id == "busket-close" || e.target.id == "busket-close-btn"){
        document.getElementsByClassName('background-shadow')[0].remove();
        document.getElementById('busket-window').remove();
    }

    //click update big busket
    if(e.target.id == "busket-update-btn"){
        e.preventDefault();

        let busketOrder = document.getElementById('busketOrder');

        let formData = new FormData(busketOrder);
        formData.append('ajax', true);

        let founded_lang = new LangForAjax().getLanguage();
        let url = founded_lang + "/busket/recount";

        fetch(url,
            {
                method: "POST",
                body: formData,
                credentials: 'same-origin'
            })
            .then(responce => responce.text())
            .then(html => document.getElementsByClassName('busket-window')[0].innerHTML = html)


            .then(()=> fetch( '/busket/refreshSmallBusket', {
                method:"POST",
                credentials:"same-origin"
                }

            ) )
            .then(responce => responce.text())
            .then(html => document.getElementById('busket-info').innerHTML = html)

    }


    if(e.target.id == "busket-make-order"){
        e.preventDefault();
        document.getElementById('busket-window').className = "busket-window--hidden";


        document.getElementById('busket-window').addEventListener('transitionend', function(){

            let orderForm = document.createElement('section');
            orderForm.className = 'order-form--hidden';
            orderForm.id = 'order-form';
            document.body.appendChild(orderForm);

            let founded_lang = new LangForAjax().getLanguage();
            let url = founded_lang + "/order/showForm";

            fetch(url,
                {
                    method: "POST",
//body: formData,
                    credentials: 'same-origin'
                })
                .then(responce => responce.text())
                .then(html => document.getElementById('order-form').innerHTML = html)
                .then(()=> document.getElementById('order-form').className = "order-form")

        })


    }




});//ends of events hanged on the body





//toggle search-results field if keyboard events take place in search area
searchField.addEventListener('keyup', function(){
    if(this.value.length === 0) {
        searchResultsBox.className = "main-header__search-result-box--hidden";
        searchResultsBox.innerHTML ='';
        return;
    }
    searchResultsBox.className = "main-header__search-result-box";

    let search = searchField.value;
    let formData = new FormData;
    formData.append('search', search);

    let founded_lang =  new LangForAjax().getLanguage();
    let url =  founded_lang+"/search/index";

    fetch(url,
        {
            method:'POST',
            body:formData
        }
    )
        .then(responce => responce.text())
        .then(html => searchResultsBox.innerHTML = html)

});


//change the comments order
let commentsOrder = document.getElementById('comments_order');
if(commentsOrder) {


    this.addEventListener('change', function (e) {
        let order = e.target.value;

        let id = document.getElementById('productId').value;

        let formData = new FormData;
        formData.append('order', order);
        formData.append('id', id);

        let founded_lang = new LangForAjax().getLanguage();
        let url = founded_lang + "/comments/reorder";


        fetch(url,
            {
                method: "POST",
                body: formData
            })
            .then(responce => responce.text())
            .then(html => document.getElementById('ordered_comments').innerHTML = html)

    });
}




//show the busket
document.getElementById('busket-container').addEventListener('click', function () {

    let darkLayer = document.createElement('div'); // слой затемнения
    darkLayer.className = 'background-shadow'; // class чтобы подхватить стиль
    document.body.appendChild(darkLayer); // включаем затемнение

    let busketWindow = document.createElement('section');
    busketWindow.className = 'busket-window';
    busketWindow.id = "busket-window";

    let founded_lang =  new LangForAjax().getLanguage();
    let url =  founded_lang+"/busket/index";

    fetch(url, {
        method: "POST",
        credentials:'same-origin'

    })
        .then(responce => responce.text())
        .then(html => busketWindow.innerHTML = html);

    document.body.appendChild(busketWindow);



});







