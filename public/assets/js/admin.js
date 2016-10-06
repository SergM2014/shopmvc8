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
