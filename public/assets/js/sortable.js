let el = document.getElementById('product-images-list');


let sortable = new Sortable(el, {


    // Element dragging ended
    onEnd: function () {

        let imgcontainer = document.querySelectorAll('.product-image-preview');
        // console.log(imgcontainer)
        let arr = [];
        for(let i=0; i<imgcontainer.length; i++){
            arr.push(imgcontainer[i].dataset.image)
            // console.log(imgcontainer[i].dataset.image)
        }
        console.log(arr);

        document.getElementById('imagesSort').value = arr;

    },

});