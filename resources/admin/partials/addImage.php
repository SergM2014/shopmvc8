<div class="product__add-image-btn-container">
    <button type="button" class="product__add-image-btn" id="product__add-image-btn" ><?= $addImage ?></button>
</div>


<form id="product__image-area" class="product__image-area--hidden" enctype="multipart/form-data" method="post"  hidden="true" >


    <div class="product__image-area-left">

        <img src="/img/nophoto.jpg" class="product__image-thumb" id="image_preview">

        <div  id="progress-container" hidden="true" >
            <progress id="progress" max="100" value="0" ></progress>
        </div>

    </div>

    <div class="product__image-area-right">

        <input type="file" id="file" >
        <span class="product__image-area-output" id="output"></span>
        <button type="button" class="product__image-area-btn" id="image-submit-btn"  hidden ><?= $load ?></button>
        <button type="button" class="product__image-area-btn" id="image-reset-btn"  hidden ><?= $delete ?></button>

    </div>

</form>

