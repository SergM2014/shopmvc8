let progressContainer = document.getElementById('progress-container'),
    progress = document.getElementById('progress'),
    output = document.getElementById('output'),
    submitBtn = document.getElementById('image-submit-btn'),
    resetBtn = document.getElementById('image-reset-btn');



class ImageUpload {

    static progressHandler(event) {

        let percent = Math.round((event.loaded / event.total) * 100);

        progress.value = percent;
        progress.innerHTML = percent + "%";
    }

    static completeHandler(event) { }

    static errorHandler(event) { output.innerHTML = 'Upload failed'; }

    static abortHandler(event) { output.innerHTML = 'Upload aborted'; }

    static  previewImage() {
//console.log('you are in upload now')
        let input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('image_preview').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                document.getElementById('file').setAttribute('hidden', true);

                resetBtn.removeAttribute('hidden');

                submitBtn.removeAttribute('hidden');
                output.setAttribute('hidden', true);

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');
    }

    uploadImage(currentClass) {

        progressContainer.removeAttribute('hidden');

        let file = document.getElementById("file").files[0];

        let formdata = new FormData();
        let _token = document.getElementById('_token').value;
        let action = document.getElementsByName('action')[0].value;

        formdata.append("file", file);
        formdata.append("_token", _token);
        formdata.append("ajax", true);
        formdata.append('action', action );

        let founded_lang = new LangForAjax().getLanguage();
        let url = founded_lang + `/${this.urlDirection}/upload`;

        let send_image = new XMLHttpRequest();
        send_image.upload.addEventListener("progress",  ImageUpload.progressHandler, false);
        send_image.addEventListener("load", (e) => currentClass.completeHandler(e) , false);
        send_image.addEventListener("error", () => ImageUpload.errorHandler, false);
        send_image.addEventListener("abort", () => ImageUpload.abortHandler, false);
        send_image.open("POST", url);
        send_image.send(formdata);

        resetBtn.setAttribute('hidden', true);
    }

    deleteImage() {
       // e.preventDefault();

        document.getElementById('image_preview').setAttribute('src', '/img/nophoto.jpg');

        document.getElementById('file').removeAttribute('hidden');

        let founded_lang = new LangForAjax().getLanguage();
        let url = founded_lang + `/${this.urlDirection}/delete`;
        let _token = document.getElementById('_token').value;

        let formData = new FormData;
        formData.append('_token', _token);

        fetch(url,
            {
                method: "POST",
                credentials: "same-origin",
                body: formData

            })
            .then(responce => responce.json())
            .then(j => output.innerHTML = j.message);


        submitBtn.setAttribute('hidden', true);
        resetBtn.setAttribute('hidden', true);
    }

}

class ProductImageUpload extends ImageUpload {

    constructor()
    {
        super();

        this.urlDirection = 'productImage';

    }

     static completeHandler(event) {//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

        let response = JSON.parse(event.target.responseText);

        output.innerHTML = response.message;
        output.removeAttribute('hidden');

        //if there is no coinceidance of token;
        if (typeof response.error != 'undefined') return;


        progress.value = 0;
        progress.innerHTML = "0%";


        document.getElementById('file').removeAttribute('hidden');
        submitBtn.setAttribute('hidden', true);
        progressContainer.setAttribute('hidden', true);
        resetBtn.setAttribute('hidden', true);
        document.getElementById('image_preview').setAttribute('src', '/img/nophoto.jpg');
        document.getElementById('product__image-area').className = 'product__image-area--hidden';
        document.getElementById('product__add-image-btn').className = 'product__add-image-btn';


//create separate div and insert added by ajax image
        let img = document.createElement('img');
        img.className = "product-image-preview";
        img.setAttribute('src', `${response.path}${response.image}`);
        img.setAttribute('data-image', `${response.image}`);
        document.getElementById('product-images-list').appendChild(img);


//refresh the images order
        let imgcontainer = document.querySelectorAll('.product-image-preview');
        // console.log(imgcontainer)
        let arr = [];
        for (let i = 0; i < imgcontainer.length; i++) {
            arr.push(imgcontainer[i].dataset.image)

        }

        document.getElementById('imagesSort').value = arr;
        document.getElementById('product__add-image-btn').removeAttribute('hidden');

    }

    init (){

        if(document.getElementById('file')) document.getElementById('file').addEventListener('change',  ImageUpload.previewImage )

        if(submitBtn) submitBtn.addEventListener('click',  () => { this.uploadImage(ProductImageUpload) });

        if(resetBtn) resetBtn.addEventListener('click', () => this.deleteImage());
    }

}


// let upload = new ProductImageUpload();
//
// upload.init();

class SliderImageUpload extends ImageUpload {

    constructor()
    {
        super();

        this.urlDirection = 'sliderImage';

    }

    static completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    let response = JSON.parse(event.target.responseText);

    output.innerHTML= response.message;
    output.removeAttribute('hidden');

    //if there is no coinceidance of token;
    if(typeof response.error != 'undefined') return;

    progress.value = 0;
    progress.innerHTML= "0%";

    submitBtn.setAttribute('hidden', true );
    progressContainer.setAttribute('hidden', true);

    resetBtn.removeAttribute('hidden');


}

    init (){

        if(document.getElementById('file')) document.getElementById('file').addEventListener('change',  ImageUpload.previewImage )

        if(submitBtn) submitBtn.addEventListener('click',  () => { this.uploadImage(SliderImageUpload) });

        if(resetBtn) resetBtn.addEventListener('click', () => this.deleteImage());
    }

}


class CarouselImageUpload extends ImageUpload {

    constructor()
    {
        super();

        this.urlDirection = 'carouselImage';

    }

    static completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

        let response = JSON.parse(event.target.responseText);

        output.innerHTML= response.message;
        output.removeAttribute('hidden');

        //if there is no coinceidance of token;
        if(typeof response.error != 'undefined') return;


        progress.value = 0;
        progress.innerHTML= "0%";


        //document.getElementById('file').removeAttribute('hidden');
        submitBtn.setAttribute('hidden', true );
        progressContainer.setAttribute('hidden', true);
        //resetBtn.setAttribute('hidden', true);
        //document.getElementById('image_preview').setAttribute('src', '/img/nophoto.jpg');
        //document.getElementById('admin__image-area').className = 'product__image-area--hidden';
        resetBtn.removeAttribute('hidden');


    }

    init (){

        if(document.getElementById('file')) document.getElementById('file').addEventListener('change',  ImageUpload.previewImage )

        if(submitBtn) submitBtn.addEventListener('click',  () => { this.uploadImage(CarouselImageUpload) });

        if(resetBtn) resetBtn.addEventListener('click', () => this.deleteImage());
    }

}

