
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

    static deleteBackground()
    {
        document.getElementById('modal-background').remove();
    }

    static showImage(image, ind, previous=null, modalBackground = null)
    {

        let background;
        if(!modalBackground){
            background = this.createBackground();
        } else {
            background = document.getElementById('modal-background');
        }
        let imageContainer = this.createImageContainer(ind);
        let imageView = document.createElement('img');
        imageView.innerHTML = " alt='' ";
        imageView.classList = "gallery__image-view";
        imageContainer.appendChild(imageView);
        if(!modalBackground) document.body.insertBefore(background, document.body.firstElementChild)
        if(previous){
            background.insertBefore(imageContainer, background.firstElementChild)
        } else {
            background.appendChild(imageContainer)
        }
        imageView.setAttribute('src', '/uploads/productsImages/'+image);



        let numberOfImages = document.getElementById('gallery-box').querySelectorAll('.preview-image').length;

        if(ind >1 && ind<numberOfImages){ ModalWindow.showArrows(ind); }

        if (ind == 1){
            let arrow = ModalWindow.createArrow('right', 2);
            document.getElementById('modal-background').querySelector('[data-ind="'+ind+'"').appendChild(arrow);


            let noArrow = document.createElement('div');
            noArrow.className = "modal-background__arrow"
            let imageContainer = document.getElementById('modal-background').querySelector('[data-ind="'+ind+'"');
            imageContainer.insertBefore(noArrow, imageContainer.firstElementChild);
        }

        if(ind == numberOfImages) {

            let arrow = ModalWindow.createArrow('left', numberOfImages-1);
            let imageContainer = document.getElementById('modal-background').querySelector('[data-ind="'+ind+'"');
            imageContainer.insertBefore(arrow, imageContainer.firstElementChild);


            let noArrow = document.createElement('div');
            noArrow.className = "modal-background__arrow"
            document.getElementById('modal-background').querySelector('[data-ind="'+ind+'"').appendChild(noArrow);
        }


    }

    static showArrows(ind) {

        let leftArrow = this.createArrow('left', ind-1);
        let rightArrow = this.createArrow('right', 1+Number(ind));

        let imageContainer = document.getElementById('modal-background').querySelector('[data-ind="'+ind+'"');
        imageContainer.insertBefore(leftArrow, imageContainer.firstElementChild);
        imageContainer.appendChild(rightArrow)
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

}


let galleryBox = document.getElementById('gallery-box').querySelectorAll('img');
for( i=0; i < galleryBox.length; i++){

    let imgString = galleryBox[i].getAttribute('src');
//console.log(img);
    let imgArr = imgString.split('/');

    galleryBox[i].dataset.image = imgArr[imgArr.length-1];


   galleryBox[i].dataset.order = i+1;
}

//console.log(galleryBox)
document.body.addEventListener('click', function(e){

    //click to show full image
    if(e.target.closest('.preview-image' )){

        let ind = e.target.dataset.order;
        ModalWindow.showImage(e.target.dataset.image, ind);

    }
//click background to hide background and full image
    if(e.target.id == "modal-background" || e.target.className =="background__image-container"){ ModalWindow.deleteBackground(); }

    if(e.target.closest('.modal-background__arrow')){
        let transition = e.target.dataset.transition;
//console.log(transition);
        let transitionImage = document.getElementById('gallery-box').querySelector('[data-order="'+transition+'"]').dataset.image;
//console.log(transitionImage)

        let currentImgContainer = e.target.closest('.background__image-container');
        let currentImgContainerInd = currentImgContainer.dataset.ind;

        currentImgContainer.classList.add('hidden');

        let nextImage = document.getElementById('modal-background').querySelector('[data-ind="'+transition+'"]')
        if(nextImage){
            nextImage.classList.remove('hidden'); return;
        }

        ModalWindow.showImage(transitionImage, transition, null, true);
    }

});