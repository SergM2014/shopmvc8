let progressContainer = document.getElementById('progress-container'),
    progress = document.getElementById('progress'),
    output = document.getElementById('output'),
    submitBtn = document.getElementById('image-submit-btn'),
    resetBtn = document.getElementById('image-reset-btn');



// this background is for imageupload

function progressHandler(event){

    let percent = Math.round((event.loaded/event.total)*100);

    progress.value = percent;
    progress.innerHTML= percent+"%";
}

function completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

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


function errorHandler(event){

    output.innerHTML= 'Upload failed';
}


function abortHandler(event){

    output.innerHTML= 'Upload aborted';
}




if(document.getElementById('file')) {
    document.getElementById('file').onchange = function () {

        let input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('image_preview').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                document.getElementById('file').setAttribute('hidden', true);

                //output.classList.add('invisible');

                resetBtn.removeAttribute('hidden');

                submitBtn.removeAttribute('hidden');
                output.setAttribute('hidden',true);

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function
}



if(submitBtn){
    submitBtn.onclick = function(e){

        e.preventDefault();

        progressContainer.removeAttribute('hidden');


        let file=document.getElementById("file").files[0];

        let formdata= new FormData();
        let _token = document.getElementById('_token').value;
        let action = document.getElementsByName('action')[0].value;

        formdata.append("file", file);
        formdata.append("_token", _token);
        formdata.append("ajax", true);
        formdata.append("action", action);

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/carouselImage/upload";

        let send_image=new XMLHttpRequest();
        send_image.upload.addEventListener("progress", progressHandler, false);
        send_image.addEventListener("load", completeHandler, false);
        send_image.addEventListener("error", errorHandler, false);
        send_image.addEventListener("abort", abortHandler, false);
        send_image.open("POST", url);
        send_image.send(formdata);

        resetBtn.setAttribute('hidden', true);

    };// end of function
}



if(resetBtn) {
    resetBtn.onclick = function (e) {
        e.preventDefault();



        document.getElementById('image_preview').setAttribute('src', '/img/nophoto.jpg');

        document.getElementById('file').removeAttribute('hidden');

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/carouselImage/delete";
        let _token = document.getElementById('_token').value;
        let action = document.getElementsByName('action')[0].value;

        let formdata = new FormData;
        formdata.append('_token', _token);
        formdata.append("action", action);

        fetch( url,
            {
                method : "POST",
                credentials: "same-origin",
                body:formdata

            })
            .then(responce => responce.json())
            .then(j => output.innerHTML = j.message)




        submitBtn.setAttribute('hidden', true );
      
        resetBtn.setAttribute('hidden', true );

    };
}
//end of image upload