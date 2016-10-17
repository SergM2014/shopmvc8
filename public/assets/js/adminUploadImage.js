let progressContainer = document.getElementById('progress-container'),
    progress = document.getElementById('progress'),
    output = document.getElementById('output'),
    submitBtn = document.getElementById('image-submit-btn'),
    resetBtn = document.getElementById('image-reset-btn');



// this background is for imageupload

function progressHandler(event){

    let percent=Math.round((event.loaded/event.total)*100);
   // progress.style.width= percent+"%";
    progress.value = percent;
    progress.innerHTML= percent+"%";
}

function completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    let response = JSON.parse(event.target.responseText);
    output.innerHTML= response.message;


    progress.value = 0;
    progress.innerHTML= "0%";


    //output.classList.remove('invisible');
    submitBtn.setAttribute('hidden', true );
    progressContainer.setAttribute('hidden', true);
    resetBtn.removeAttribute('disabled');
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
        //progress.classList.remove('invisible');
        progressContainer.removeAttribute('hidden');


        let file=document.getElementById("file").files[0];

        let formdata= new FormData();
//let _token = document.getElementById('prozessAvatar').value;

        formdata.append("file", file);
        //formdata.append("_token", _token);

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/productImage/upload";

        let send_image=new XMLHttpRequest();
        send_image.upload.addEventListener("progress", progressHandler, false);
        send_image.addEventListener("load", completeHandler, false);
        send_image.addEventListener("error", errorHandler, false);
        send_image.addEventListener("abort", abortHandler, false);
        send_image.open("POST", url);
        send_image.send(formdata);

        resetBtn.setAttribute('disabled', 'disabled');

    };// end of function
}



if(resetBtn) {
    resetBtn.onclick = function (e) {
        e.preventDefault();

       // let _token = document.getElementById('prozessAvatar').value;

        document.getElementById('image_preview').setAttribute('src', '/img/nophoto.jpg');
       // document.getElementById('FileInput').classList.remove('invisible');
        document.getElementById('file').removeAttribute('hidden');

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/productImage/delete";

        let formData = new FormData;
       // formData.append('_token', _token);

        fetch( url,
            {
                method : "POST",
                credentials: "same-origin",
                body:formData

            })
            .then(responce => responce.json())
            .then(j => output.innerHTML = j.message)



        //submitBtn.classList.add('invisible');
        submitBtn.setAttribute('hidden', true );
       //resetBtn.classList.add('invisible');
        resetBtn.setAttribute('hidden', true );

    };
}
//end of image upload