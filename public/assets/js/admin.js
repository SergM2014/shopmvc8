let windowWidth = document.documentElement.clientWidth,
    defaultLang = document.getElementsByName('defaultLang')[0].value,
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

        this.id =  e.target.closest('.admin-products-list__row').dataset.id;
//console.log(`this is x =>${this.x} , thus is y=>${this.y}`)
//console.log('qwerty')
        console.log(this.id)
    }


    drawMenu(){
       PopupMenu.deleteMenu();

        this.popUp = document.createElement('div');
        this.popUp.className = "popup-menu";
        this.popUp.id = "popup-menu";

        //document.body.insertBefore(this.popUp, document.getElementsByClassName('container')[0]);
        document.body.insertBefore(this.popUp, document.body.firstChild);

        if(this.x+100 >this.screenWidth+pageXOffset) this.x= (this.screenWidth+pageXOffset-100);
        if(this.y+60 >this.screenHeight+pageYOffset) this.y= (this.screenHeight+pageYOffset-60);


        this.popUp.style.left = this.x+"px";
        this.popUp.style.top = this.y+"px";
    }

    static deleteMenu()
    {
        if(document.getElementById('popup-menu')){document.getElementById('popup-menu').remove();}
    }

    fillUpProdactsContent()
    {
        let lang =  new LangForAjax().getLanguage();

        let url = lang+"/adminProducts/createProductsPopUpMenu";
        let formData = new FormData;
        formData.append('id', this.id);

        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);


    }


}


document.body.addEventListener('click', function(e){
    if(!e.target.closest("#admin-products-list") ) {
        PopupMenu.deleteMenu();
    }
});


document.getElementById('insert-products').addEventListener('click', function(e){

    //click the pagination
    if(e.target.className  == "pagination-item"){

        let the_class = e.target.closest('.pagination-item');

        if(the_class) {

            let p = the_class.dataset.p;
            let order = document.getElementById('order-drop-down-menu').value;
            let category = document.getElementById('categories-drop-down-menu').value;
            let manufacturer = document.getElementById('manufacturers-drop-down-menu').value;

            let founded_lang =  new LangForAjax().getLanguage();
            let url =  founded_lang+"/adminProducts/refresh";

            let formData = new FormData;
            formData.append('order', order);
            if(category) formData.append('category', category);
            if(manufacturer) formData.append('manufacturer', manufacturer);
            formData.append('ajax', true);
            formData.append('p', p);

            fetch( url,
                {
                    method: "POST",
                    body: formData,
                    credentials:'same-origin'
                })
                .then(responce => responce.text())
                .then(html => document.getElementById('insert-products').innerHTML = html);
        }

    }

//click upon the products list to get POPup menu
    if(e.target.closest("#admin-products-list") && !e.target.closest("#admin-products-list__header")){

        let popUp = new PopupMenu(e);
        popUp.drawMenu();
        popUp.fillUpProdactsContent();

    }


});










document.getElementById('products__drop-down-container-btn').addEventListener('click', function(){

//console.log(1111)
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

});
