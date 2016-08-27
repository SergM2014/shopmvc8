let windowWidth = document.documentElement.clientWidth,
    touchButton= document.getElementsByClassName('main-header__touch-button')[0],
    headerMenu =  document.getElementsByClassName('main-header__menu')[0],
    languagesBox = document.getElementsByClassName('main-header__language-select')[0],
    writeUsNameError = document.getElementById('writeUsNameError'),
    writeUsEmailError = document.getElementById('writeUsEmailError'),
    writeUsMessageError = document.getElementById('writeUsMessageError');

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

touchButton.addEventListener('click', function(){
  headerMenu.classList.add('showMenu');

});



if(windowWidth < 751){
    document.addEventListener('click', function(e){
        if ( !e.target.closest('.main-header__touch-button') && !e.target.closest('.main-header__menu')){

            headerMenu.classList.remove('showMenu');
        }
    })
}

//toggle languages
languagesBox.addEventListener('click', function(){
    document.getElementsByClassName('main-header__language-select-dropdown')[0].classList.toggle('hidden')
});

//vertical menu slideUp/Down
document.getElementsByClassName('left-menu')[0].addEventListener('click', function(e){
    if (!e.target.classList.contains('left-menu__contains-subcatetegories-sign')) return;

    let currentMenuItemId = e.target.closest('li').dataset.categoryId;
    let currentMenuItemParentId = e.target.closest('li').dataset.parentId;
    let parentUl = e.target.closest('ul');
    let childrenLi = parentUl.querySelectorAll('[data-parent-id="'+currentMenuItemParentId+'"]');

    if(! childrenLi) return;
    for (let i=0; i<childrenLi.length; i++){
            let ul = childrenLi[i].querySelector('ul');
            if(childrenLi[i].dataset.categoryId != currentMenuItemId){
              if (ul){
                  ul.classList.add('hidden');
                  let sign = ul.closest('li').querySelector('.left-menu__contains-subcatetegories-sign');
                  sign.classList.remove('hidden');
              }
            } else {
               if(ul) {
                   ul.classList.remove('hidden');
                   let sign = ul.closest('li').querySelector('.left-menu__contains-subcatetegories-sign');
                   sign.classList.add('hidden');
                 }
               }
        }

});




document.getElementById('sendMessage').addEventListener('click', function(e){
    e.preventDefault();
    let inputError = false;

    let ckeditorData = CKEDITOR.instances.writeUsMessage.getData();

    if(ckeditorData.length == 0){
        writeUsMessageError.className = "content-zone__form-error";
        inputError = true;
    }  else {
        writeUsMessageError.className = "content-zone__form-error--hidden";
    }


    if( document.getElementById('writeUsName').value.length <4 ) {
        writeUsNameError.className="content-zone__form-error";
        inputError = true;
    }else {
        writeUsNameError.className="content-zone__form-error--hidden";
    }


    //let email = validateEmail(document.getElementById('writeUsEmail').value);
    if(!validateEmail(document.getElementById('writeUsEmail').value)) {
        writeUsEmailError.className = "content-zone__form-error";
        inputError = true;
    } else {
        writeUsEmailError.className="content-zone__form-error--hidden";
    }

    if(inputError) console.log('exit');


    let name = document.getElementById('writeUsName').value;
    let email = document.getElementById('writeUsEmail').value;



});