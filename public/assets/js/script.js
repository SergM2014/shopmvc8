let windowWidth = document.documentElement.clientWidth,
    touchButton= document.getElementsByClassName('main-header__touch-button')[0],
    headerMenu =  document.getElementsByClassName('main-header__menu')[0],
    languagesBox = document.getElementsByClassName('main-header__language-select')[0],
    searchResultsBox = document.getElementById('search-results');

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone(phone){
   let regexp = /\d{3}-\d{3}-\d{2}-\d{2}/;
    if (regexp.test(phone))  return true;

    return false;
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

document.body.addEventListener('click', function(e){

//catch the refresh captcha event
    if(e.target.id == "captcha_img") {
        fetch(
            '/index/refreshCaptcha', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#captcha-img-container').innerHTML = html;
            })
    }


//remove search-result is clicke outside the search-container
    if(!e.target.closest('.main-header__search-container')){
        searchResultsBox.className = "main-header__search-result-box--hidden";
        searchResultsBox.innerHTML ='';
    }


});

//toggle search-results field if keyboard events take place in search area
document.getElementById('search').addEventListener('keyup', function(){
    if(this.value.length === 0) {
        searchResultsBox.className = "main-header__search-result-box--hidden";
        searchResultsBox.innerHTML ='';
        return;
    }
    searchResultsBox.className = "main-header__search-result-box";

    fetch('/search/index',
        {
            method:'POST',
        }
    )
        .then(responce => responce.text())
        .then(html => searchResultsBox.innerHTML = html)
});







