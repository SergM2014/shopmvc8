let defaultLang = document.getElementsByName('defaultLang')[0].value,
    arrayLangsList = document.getElementsByName('languages')[0].value.split(',');

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


class PopupMenu{
    constructor(e){
        this.x = e.pageX;
        this.y = e.pageY;

        this.screenWidth = document.body.clientWidth;
        this.screenHeight = document.body.clientHeight;
        this.target = e.target;
    }


    drawMenu(x = 100, y = 60){
       PopupMenu.deleteMenu();

        this.popUp = document.createElement('div');
        this.popUp.className = "popup-menu";
        this.popUp.id = "popup-menu";

        document.body.insertBefore(this.popUp, document.body.firstChild);

        if(this.x+x >this.screenWidth+pageXOffset) this.x= (this.screenWidth+pageXOffset-x);
        if(this.y+y >this.screenHeight+pageYOffset) this.y= (this.screenHeight+pageYOffset-y);

        this.popUp.style.left = this.x+"px";
        this.popUp.style.top = this.y+"px";
    }

    static deleteMenu()
    {
        if(document.getElementById('popup-menu')){document.getElementById('popup-menu').remove();}
    }

    fillUpMenuContent()
    {
        let id =  this.target.closest('.admin-products-list__row').dataset.id;
        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminProducts/createProductsPopUpMenu";
        let formData = new FormData;
        formData.append('id', id);

        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }

}

class ImagePopUpMenu extends PopupMenu {
    fillUpMenuContent()
    {
//console.log(this.target.src);
        let arr = this.target.src.split('/');
//console.log(arr[arr.length-1]);
        let image = arr[arr.length-1];
        let product_id =  document.getElementById('id');
        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminProducts/createImagePopUpMenu";
        let formData = new FormData;
        formData.append('id', product_id);
        formData.append('image', image);

        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }
}


document.body.addEventListener('click', function(e) {
    if (!e.target.closest("#admin-products-list")) {
        PopupMenu.deleteMenu();
    }



    //click the pagination
    if (e.target.className == "pagination-item") {

        let the_class = e.target.closest('.pagination-item');

        if (the_class) {

            let p = the_class.dataset.p;
            let order = document.getElementById('order-drop-down-menu').value;
            let category = document.getElementById('categories-drop-down-menu').value;
            let manufacturer = document.getElementById('manufacturers-drop-down-menu').value;

            let founded_lang = new LangForAjax().getLanguage();
            let url = founded_lang + "/adminProducts/refresh";

            let formData = new FormData;
            formData.append('order', order);
            if (category) formData.append('category', category);
            if (manufacturer) formData.append('manufacturer', manufacturer);
            formData.append('ajax', true);
            formData.append('p', p);

            fetch(url,
                {
                    method: "POST",
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(responce => responce.text())
                .then(html => document.getElementById('insert-products').innerHTML = html);
        }

    }

//click upon the products list to get POPup menu
    if (e.target.closest("#admin-products-list") && !e.target.closest("#admin-products-list__header")) {

        let popUp = new PopupMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();

    }



    if(e.target.id == 'products__drop-down-container-btn'){

        let p = document.getElementById('pagination-item-current').dataset.p;
        let order = document.getElementById('order-drop-down-menu').value;
        let category = document.getElementById('categories-drop-down-menu').value;
        let manufacturer = document.getElementById('manufacturers-drop-down-menu').value;
//console.log(p);
        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/adminProducts/refresh";

        let formData = new FormData;
        formData.append('order', order);
        if(category) formData.append('category', category);
        if(manufacturer) formData.append('manufacturer', manufacturer);
        formData.append('ajax', true);
        //formData.append('p', p);

        fetch( url,
            {
                method: "POST",
                body: formData,
                credentials:'same-origin'
            })
            .then(responce => responce.text())
            .then(html => document.getElementById('insert-products').innerHTML = html);

    }


    if(e.target.id == "product__add-image-btn"){
        document.getElementById('product__image-area').className = "product__image-area";
        e.target.className = "update-form__add-image-btn--hidden";
    }

// add popupmenu to the update product images
    if (e.target.closest(".product-image-preview") ) {
        let popUp = new ImagePopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();
    }

    if(e.target.id == "popUp-menu-item-delete"){
//console.log(e.target.dataset.image)
        let image = e.target.dataset.image;
        let formData = new FormData;
        formData.append('image', image);
        formData.append('ajax', true);

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/adminProducts/addImageToDeleteList";

        fetch( url,
            {
                method: "POST",
                body: formData,
                credentials:'same-origin'
            })
            .then(document.querySelector(`[data-image = "${image}"]`).remove())

    }




})//end of the body



