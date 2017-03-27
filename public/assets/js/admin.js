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

        let arr = this.target.src.split('/');

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

class CommentPopUpMenu extends PopupMenu {
    fillUpMenuContent()
    {

        let commentId = this.target.closest('.admin-comments-list__row').id;

        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminComments/createCommentsPopUpMenu";
        let formData = new FormData;
        formData.append('id', commentId);


        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }
}

class CategoryPopUpMenu extends PopupMenu {
    fillUpMenuContent()
    {

        let categoryId = this.target.closest('.categories-menu__item').dataset.id;

        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminCategories/createCategoriesPopUpMenu";
        let formData = new FormData;
        formData.append('id', categoryId);


        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }
}


class ManufacturerPopUpMenu extends PopupMenu {
    fillUpMenuContent()
    {

        let categoryId = this.target.closest('.manufacturers-menu__item').dataset.id;

        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminManufacturers/createManufacturersPopUpMenu";
        let formData = new FormData;
        formData.append('id', categoryId);


        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }
}


class SliderPopUpMenu extends PopupMenu {
    fillUpMenuContent()
    {

        let categoryId = this.target.closest('.sliders-menu__item-container').dataset.id;

        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminSliders/createSlidersPopUpMenu";
        let formData = new FormData;
        formData.append('id', categoryId);


        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }
}
class CarouselPopUpMenu extends PopupMenu {
    fillUpMenuContent()
    {

        let categoryId = this.target.closest('.carousels-menu__item-container').dataset.id;

        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminCarousels/createCarouselsPopUpMenu";
        let formData = new FormData;
        formData.append('id', categoryId);


        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }
}

class UserPopUpMenu extends PopupMenu {
    fillUpMenuContent()
    {

        let categoryId = this.target.closest('.user-menu__item-container').dataset.id;

        let lang =  new LangForAjax().getLanguage();

        let url = lang + "/adminUsers/createUsersPopUpMenu";
        let formData = new FormData;
        formData.append('id', categoryId);


        fetch(url, {
            method:'POST',
            credentials:'same-origin',
            body: formData
        })
            .then(response => response.text())
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
    }
}


class ImageOrder {
    static reorder(){
        //refresh the images order
        let imgcontainer = document.querySelectorAll('.product-image-preview');
        // console.log(imgcontainer)
        if(!imgcontainer) return;
        let arr = [];
        for(let i=0; i<imgcontainer.length; i++){
            arr.push(imgcontainer[i].dataset.image);

        }

        if(document.getElementById('imagesSort')) document.getElementById('imagesSort').value = arr;
    }
}




class UnifiedModalWindow {

    static createBackground(){
        let background = document.createElement('div');
        background.className = "modal-background";
        background.id = "modal-background";
        return background;
    }

    static createDeletePopUp(id, controller){
        let popup =document.createElement('div');
        popup.className = "popup-window";


        let founded_lang = new LangForAjax().getLanguage();
        let url = founded_lang + "/admin"+controller+"/createConfirmDeleteWindow";
        let formData = new FormData;
        formData.append('id', id);

        fetch(url,
            {
                method: "POST",
                body: formData,
                credentials: 'same-origin'
            })
            .then(responce => responce.text())
            .then(html => { popup.innerHTML = html; return true; })
            .then(()=> {let modal = UnifiedModalWindow.createBackground(); modal.appendChild(popup); document.body.insertBefore(modal, document.body.firstChild )})

    }

    static deleteBackground()
    {
        document.getElementById('modal-background').remove();
    }
}







class CategoryList {
    static refresh(){
        let ids= [];
        let categoriesList = document.getElementById('admin-product__existing-categories').querySelectorAll('li');
//console.log(categoriesList);
        for (let i=0; i<categoriesList.length; i++){
            ids.push(categoriesList[i].dataset.categoryId);
        }
//console.log(ids);
        let idsValue = ids.join(',');
//console.log(idsValue)
        document.getElementById('category_ids').value= idsValue;
    }
}




//ImageOrder.reorder();



document.body.addEventListener('click', function(e) {


    if (!e.target.closest("#admin-products-list")) {
        PopupMenu.deleteMenu();
    }
//close alert message

    if(e.target.id == "admin-notice__close")  document.getElementById('admin-notice').remove();

    //click the pagination f the product
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
                .then(html => document.getElementById('insert-products').innerHTML =   html);
        }

    }

//click upon the products list to get POPup menu
    if (e.target.closest("#admin-products-list") && !e.target.closest("#admin-products-list__header")) {

        let popUp = new PopupMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();

    }



    if(e.target.id == 'products__drop-down-container-btn'){

        let p = (document.getElementById('pagination-item-current'))? document.getElementById('pagination-item-current').dataset.p : null;
        let order = document.getElementById('order-drop-down-menu').value;
        let category = document.getElementById('categories-drop-down-menu').value;
        let manufacturer = document.getElementById('manufacturers-drop-down-menu').value;

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/adminProducts/refresh";

        let formData = new FormData;

        if(p) formData.append('p', p);
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
        e.target.setAttribute('hidden', true);
        document.getElementById('output').innerText='';
    }

// add popupmenu to the update product images
    if (e.target.closest(".product-image-preview") ) {
        let popUp = new ImagePopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();
    }

    if(e.target.id == "popUp-menu-item-delete"){

        let image = e.target.dataset.image;
        let _token = document.getElementById('_token').value;
        let formData = new FormData;
        formData.append('image', image);
        formData.append('_token', _token);
        formData.append('ajax', true);

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/adminProducts/addImageToDeleteList";

      p1=  fetch( url,
            {
                method: "POST",
                body: formData,
                credentials:'same-origin'
            })
        p2 = p1.then(response => response.json() )

        p3 = p2.then((json) => {
            return new Promise((resolve, reject) => {
                if(typeof json.error != 'undefined'){ reject('That is an CSRF error'); }
                resolve('success');
            })
        })

            p3.then((response) => { console.log(response); document.querySelector(`[data-image = "${image}"]`).remove(); document.querySelector('#output').setAttribute('hidden', true); ImageOrder.reorder(); });
            p3.catch((error) => {alert(error)});


        //ImageOrder.reorder();
    }


    if(e.target.id == "popUp-admin-product-delete") {
       let id = e.target.dataset.productId;

       // ModalWindow.createDeletePopUp(id);
        UnifiedModalWindow.createDeletePopUp(id, "Products")
    }




    if(e.target.id == "modal-confirm-btn--reset") UnifiedModalWindow.deleteBackground();



    if(e.target.id == "comments__drop-down-container-btn"){

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/adminComments/refresh";

        let formData = new FormData(document.getElementById('comments_drop-down-container'));

        formData.append('ajax', true);
        //formData.append('p', p);

        fetch( url,
            {
                method: "POST",
                body: formData,
                credentials:'same-origin'
            })
            .then(responce => responce.text())
            .then(html => document.getElementById('admin-comments-list-container').innerHTML = html);


    }


    if (e.target.className == "pagination-item-comment") {

        let the_class = e.target.closest('.pagination-item-comment');

        if (the_class) {

            let p = the_class.dataset.p;


            let founded_lang = new LangForAjax().getLanguage();
            let url = founded_lang + "/adminComments/refresh";

            let formData = new FormData(document.getElementById('comments_drop-down-container'));

            formData.append('ajax', true);

            formData.append('p', p);

            fetch(url,
                {
                    method: "POST",
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(responce => responce.text())
                .then(html => document.getElementById('admin-comments-list-container').innerHTML = html);
        }

    }



    if (e.target.closest(".admin-comments-list__row") && !e.target.closest(".admin-comments-list__header")) {

        let popUp = new CommentPopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();

    }

    if(e.target.id == "popUp-admin-comment-publish"){

       let form = e.target.closest('#publish-comment-item');
        document.body.appendChild(form);

        form.submit();
        document.body.remove(form);
    }

    if(e.target.id == "popUp-admin-comment-unpublish"){

        let form = e.target.closest('#unpublish-comment-item');
        document.body.appendChild(form);
        form.submit();
        document.body.remove(form);
    }


    if(e.target.closest('.categories-menu__item') && e.target.closest('#admin-categories__block')){

        let popUp = new CategoryPopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();
    }

    if(e.target.id == "popUp-admin-category-delete") {
        let id = e.target.dataset.categoryId;

        UnifiedModalWindow.createDeletePopUp(id, "Categories")
    }

    if(e.target.closest('.manufacturers-menu__item')){

        let popUp = new ManufacturerPopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();
    }

    if(e.target.id == "popUp-admin-manufacturer-delete") {
        let id = e.target.dataset.manufacturerId;

        UnifiedModalWindow.createDeletePopUp(id, "Manufacturers")

    }

    if(e.target.closest('.sliders-menu__item-container')){

        let popUp = new SliderPopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();
    }


    if(e.target.id == "popUp-admin-slider-delete") {

        let id = e.target.dataset.sliderId;

        UnifiedModalWindow.createDeletePopUp(id, "Sliders")

    }

    if(e.target.closest('.carousels-menu__item-container')){

        let popUp = new CarouselPopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();
    }

    if(e.target.closest('.user-menu__item-container')){

        let popUp = new UserPopUpMenu(e);
        popUp.drawMenu();
        popUp.fillUpMenuContent();
    }

    if(e.target.id == "popUp-admin-carousel-delete") {

        let id = e.target.dataset.carouselId;

        UnifiedModalWindow.createDeletePopUp(id, "Carousels")
    }

    if(e.target.id == "popUp-admin-user-delete") {

        let id = e.target.dataset.userId;

        UnifiedModalWindow.createDeletePopUp(id, "Users")
    }




    if(e.target.id == "admin-product__add-category-btn"){

        document.getElementById('admin-product__add-category').className ='';
        e.target.className = "admin-product__add-category-btn--hidden";
    }

    if(e.target.closest('.categories-menu__item') && e.target.closest('#admin-product__add-category')){

        let existingCategoriesList = document .getElementById('admin-product__existing-categories').querySelectorAll('li');

        let categoryId = e.target.dataset.id;
        let categoryTitle = e.target.innerText;

        let categoryCoincidence = false;

        for (let i=0; i<existingCategoriesList.length; i++){
            if(existingCategoriesList[i].dataset.categoryId == categoryId) categoryCoincidence = true;
        }

        if(!categoryCoincidence) {

            let formData = new FormData;
            formData.append('categoryId', categoryId);
            formData.append('categoryTitle', categoryTitle);

            fetch('/adminProducts/addCategory',
                {
                    method: "POST",
                    body: formData,
                    credentials: 'same-origin'
                })
                .then(responce => responce.text())
                .then(html => document.getElementById('admin-product__existing-categories').insertAdjacentHTML('beforeEnd', html) )
                .then(()=>{
                    CategoryList.refresh()
                })




        }
    }



    if(e.target.className == "categories-menu__item-close-sign") {

        e.target.closest('.categories-menu__item').remove();

        CategoryList.refresh()
    }




})//end of the body






