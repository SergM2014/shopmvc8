let progress=document.getElementById('progress-bar'),
    output= document.getElementById('output'),
    submit_btn= document.getElementById('avatar-submit-btn'),
    reset_btn= document.getElementById('avatar-reset-btn');



class LangForImageProzess{
    constructor ()
    {
        //get the Array of languages
        let langsArray = [];
        for(let i=0; i<arrayLangsList.length; i++){
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

// this background is for imageupload

function progressHandler(event){

    let percent=Math.round((event.loaded/event.total)*100);
    progress.style.width= percent+"%";
    progress.innerHTML= percent+"%";
}

function completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    let response = JSON.parse(event.target.responseText);
    output.innerHTML= response.message;

    progress.style.width= "0%";
    progress.innerHTML= "0%";


    output.classList.remove('invisible');
    submit_btn.classList.add('invisible');
    progress.classList.add('invisible');
    reset_btn.removeAttribute('disabled');
}


function errorHandler(event){

    output.innerHTML= 'Upload failed';
}


function abortHandler(event){

    output.innerHTML= 'Upload aborted';
}




if(document.getElementById('FileInput')) {
    document.getElementById('FileInput').onchange = function () {

        let input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('image_preview').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                document.getElementById('FileInput').classList.add('invisible');

                output.classList.add('invisible');

                reset_btn.classList.remove('invisible');

                submit_btn.classList.remove('invisible');

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function
}



if(submit_btn){
    submit_btn.onclick = function(e){

        e.preventDefault();
        progress.classList.remove('invisible');


        let file=document.getElementById("FileInput").files[0];

        let formdata= new FormData();
        let _token = document.getElementById('prozessAvatar').value;

        formdata.append("FileInput", file);
        formdata.append("_token", _token);

        let founded_lang =  new LangForImageProzess().getLanguage();
        let url =  founded_lang+"/image/upload";

        let send_image=new XMLHttpRequest();
        send_image.upload.addEventListener("progress", progressHandler, false);
        send_image.addEventListener("load", completeHandler, false);
        send_image.addEventListener("error", errorHandler, false);
        send_image.addEventListener("abort", abortHandler, false);
        send_image.open("POST", url);
        send_image.send(formdata);

        reset_btn.setAttribute('disabled', 'disabled');

    };// end of function
}



if(reset_btn) {
    reset_btn.onclick = function (e) {
        e.preventDefault();

        let _token = document.getElementById('prozessAvatar').value;

        document.getElementById('image_preview').setAttribute('src', '/img/noavatar.jpg');
        document.getElementById('FileInput').classList.remove('invisible');

        let founded_lang =  new LangForImageProzess().getLanguage();
        let url =  founded_lang+"/image/delete";

        let formData = new FormData;
        formData.append('_token', _token);

        fetch( url,
            {
                method : "POST",
                credentials: "same-origin",
                body:formData

            })
            .then(responce => responce.json())
            .then(j => output.innerHTML = j.message)



        submit_btn.classList.add('invisible');
       reset_btn.classList.add('invisible');

    };
}
//end of image upload