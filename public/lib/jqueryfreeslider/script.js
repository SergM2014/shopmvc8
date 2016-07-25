//get amount of slider
var slider_number = document.getElementById('slider').querySelectorAll('.slider_image');




function toggleImage(id)//спочатку получаемо цифру 1
{
    var currentElem = document.getElementById(id);
    var currentElemHeight = getElemHeight(id);//получаем высоту элемента
    var elems = currentElem.getElementsByTagName('*');//елкмкнты що маються в теге содержащиго картинку
    var flag;
//elem are [div.bottom,a ]


    if(currentElem.classList.contains('notdisplayed'))
    {
//hide bottom title
              for(var i=0; i<elems.length; i++){elems[i].classList.add('unvisible');}
            //для visibility

            currentElem.style.height="1px";
            currentElem.classList.toggle('notdisplayed');

            //image will be larging(sliding down)
            for(var i=0;i<=100;i+=5)
            {
                (function()
                {
                    var pos=i;
                    setTimeout(function(){currentElem.style.height = (pos/100)*currentElemHeight+1+"px";},pos*5);
                }
                )();
            }

//botom titel elems are shown

        setTimeout(function(){for(var i=0; i<elems.length; i++){elems[i].classList.remove('unvisible'); }},500);





    }
    else
    { //reduce slider image(sliding up)

            var theHeight= currentElemHeight-1+"px";


        for(var i=0; i<elems.length; i++){elems[i].classList.add('unvisible');}

            for (var i=100;i>=0;i-=5)
            {
                (function()
                {
                    var pos=i;
                    setTimeout(function()
                    {
                        currentElem.style.height = (pos/100)*currentElemHeight+"px";
                        if (pos<=0)
                        {
                            currentElem.classList.toggle('notdisplayed');
                            currentElem.style.height=theHeight;

                        }
                    },1000-(pos*5));
                }
                )();
            }


    }

}



function getElemHeight(id)
{
    var currentElem = document.getElementById(id);

    if(currentElem.classList.contains('notdisplayed'))
    {
        currentElem.classList.add('unvisible');

        currentElem.classList.remove('notdisplayed');

        elemHeight = currentElem.clientHeight||currentElem.offsetHeight+5; // Высота

        currentElem.classList.add('notdisplayed');

        currentElem.classList.remove('unvisible');
    }
    else
    {
        elemHeight = currentElem.clientHeight||currentElem.offsetHeight+5; // Высота
    }
    return elemHeight;
}

function startSliding(now, last)
{
    var newnow;

        if(now == slider_number.length ){

            newnow=1;
        } else {
            newnow = (Number(now)+1);
        }
    if(slider_number.length == 1) newnow=1;


    if(last!=0)  {toggleImage(last);}

    setTimeout(function(){toggleImage(now);},1000);//запустыть функцию через промежуток

    setTimeout(function(){startSliding(newnow, now);}, 6000);
}


window.onload = startSliding('1', '0');
