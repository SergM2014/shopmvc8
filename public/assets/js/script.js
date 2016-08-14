let windowWidth = document.documentElement.clientWidth,
    touchButton= document.getElementsByClassName('main-header__touch-button')[0],
    headerMenu =  document.getElementsByClassName('main-header__menu')[0],
    languagesBox = document.getElementsByClassName('main-header__language-select')[0];

touchButton.addEventListener('click', function(){
  headerMenu.classList.add('showMenu');

});



if(windowWidth < 751){
    document.addEventListener('click', function(e){
        if ( !e.target.closest('.main-header__touch-button') && !e.target.closest('.main-header__menu')){
//console.log('close is necessary');
            headerMenu.classList.remove('showMenu');
        }
    })
}

languagesBox.addEventListener('click', function(){
    document.getElementsByClassName('main-header__language-select-dropdown')[0].classList.toggle('hidden')
});


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
    //}
});