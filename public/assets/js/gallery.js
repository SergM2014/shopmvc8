let imagePath = '/uploads/productsImages/';


class ModalWindow {

    static createBackground(){
        let background = document.createElement('div');
        background.className = "modal-background";
        background.id = "modal-background";
        return background;

    }

    static createImageContainer(ind)
    {
        let container = document.createElement('div');
        container.className = "background__image-container";
        container.dataset.ind = ind;

        return container;
    }

    static createArrow(direction, ind){

        let arrow = document.createElement('img');
        arrow.className = "modal-background__arrow";
        arrow.id = "modal-background__"+direction+"-arrow";
        arrow.innerHTML = "alt='' title=''  ";
        arrow.setAttribute('src', '/img/'+direction+'.png');
        arrow.setAttribute('data-transition', ind);
        return arrow;

    }

    static showArrows(ind) {
        let leftArrow = this.createArrow('left', ind-1);
        let rightArrow = this.createArrow('right', 1+Number(ind));
        let arrowContainer = document.getElementById('modal-background').querySelector('[data-arrowind="'+ind+'"');
        arrowContainer.insertBefore(leftArrow, arrowContainer.firstElementChild);
        arrowContainer.appendChild(rightArrow)
    }



    static closeSign()
    {
        let closeSign = document.createElement('span');
        closeSign.className = "close-image";
        closeSign.innerHTML = "CLOSE";
        return closeSign;
    }

    static createArrowContainer(ind)
    {
        let arrowContainer = document.createElement('div');
        arrowContainer.className = "arrow-container";
        arrowContainer.dataset.arrowind = ind;
        return arrowContainer;
    }



    static deleteBackground()
    {
        document.getElementById('modal-background').remove();
    }

    static showFullImage(image, ind, previous=null, modalBackground = null)
    {

        let background;
        if(!modalBackground){
            background = this.createBackground();
        } else {
            background = document.getElementById('modal-background');
        }
        let imageContainer = this.createImageContainer(ind);
        let imageView = document.createElement('img');
        imageView.setAttribute('alt', '');
        imageView.classList = "gallery__image-view";

        imageContainer.appendChild(imageView);

        imageContainer.appendChild(this.closeSign());

        let arrowContainer = this.createArrowContainer(ind)

        imageContainer.appendChild(arrowContainer)

        if(!modalBackground) document.body.insertBefore(background, document.body.firstElementChild);
        if(previous){
            background.insertBefore(imageContainer, background.firstElementChild)
        } else {
            background.appendChild(imageContainer)
        }

        imageView.setAttribute('src', imagePath+image);


        let numberOfImages = document.getElementById('gallery-box').querySelectorAll('.preview-image').length;

        if(ind >1 && ind<numberOfImages){ ModalWindow.showArrows(ind); }

        if (ind == 1){

            let noArrow = document.createElement('div');
            noArrow.className = "modal-background__no-arrow";
            let arrowContainer = document.getElementById('modal-background').querySelector('[data-arrowind="'+ind+'"');
            arrowContainer.insertBefore(noArrow, arrowContainer.firstElementChild);

            let arrow = ModalWindow.createArrow('right', 2);
            document.getElementById('modal-background').querySelector('[data-arrowind="'+ind+'"').appendChild(arrow);
        }


        if(ind == numberOfImages) {
            let arrow = ModalWindow.createArrow('left', numberOfImages-1);
            let arrowContainer = document.getElementById('modal-background').querySelector('[data-arrowind="'+ind+'"');
            arrowContainer.insertBefore(arrow, arrowContainer.firstElementChild);

            let noArrow = document.createElement('div');
            noArrow.className = "modal-background__no-arrow";
            document.getElementById('modal-background').querySelector('[data-arrowind="'+ind+'"').appendChild(noArrow);
        }


    }


    static initializeImages()
    {
        let galleryBox = document.getElementById('gallery-box').querySelectorAll('img');
        for( let i=0; i < galleryBox.length; i++){

            let imgString = galleryBox[i].getAttribute('src');
            let imgArr = imgString.split('/');
            galleryBox[i].dataset.image = imgArr[imgArr.length-1];


            galleryBox[i].dataset.order = i+1;
        }

    }

}

ModalWindow.initializeImages();


document.body.addEventListener('click', function(e){

    //click to show full image
    if(e.target.closest('.preview-image' )){
        let ind = e.target.dataset.order;
        ModalWindow.showFullImage(e.target.dataset.image, ind);
    }
//click background to hide background and full image
    if(/*e.target.id == "modal-background" || e.target.className =="background__image-container" ||*/ e.target.className == "close-image"){ ModalWindow.deleteBackground(); }

    if(e.target.closest('.modal-background__arrow')){
        let transition = e.target.dataset.transition;

        let transitionImage = document.getElementById('gallery-box').querySelector('[data-order="'+transition+'"]').dataset.image;

        let currentImgContainer = e.target.closest('.background__image-container');

        currentImgContainer.classList.add('hidden');

        let nextImage = document.getElementById('modal-background').querySelector('[data-ind="'+transition+'"]')
        if(nextImage){
            nextImage.classList.remove('hidden'); return;
        }

        ModalWindow.showFullImage(transitionImage, transition, null, true);
    }

});