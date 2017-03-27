<section class="create__block">


    <h2><?= $createCarouselHeader ?></h2>

    <form enctype="multipart/form-data" action="/<?= \Lib\HelperService::currentLang() ?>adminCarousels/store" method="post" >

        <input type="hidden" type="hidden" name="action" value="createCarousel" >
        <input type="hidden" id="_token" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">



        <br>
        <label for="carousel_url" class="create__block-title"><?= $createCarouselUrl ?></label>
        <p>
            <input type="text" name="carousel_url" id="carousel_url" value="<?= @$error['carousel_url']? "" : strip_tags(@$_POST['carousel_url'])  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['carousel_url'] ?></small></p>

        <br>




        <label for="file" class="create__block-title" ><?= $addImage ?></label>
        <br>

        <div id="admin__image-area" class=" admin__image-area clearfix">
            <div class="admin__image-area-left">

                <img src="<?= @$_SESSION['createCarousel']?'/public/uploads/carousel/'.$_SESSION['createCarousel'] : '/public/img/nophoto.jpg' ?>" class="product__image-thumb" id="image_preview">

                <div  id="progress-container" hidden >
                    <progress id="progress" max="100" value="0"></progress>
                </div>

            </div>

            <div class="admin__image-area-right">

                <input type="file" id="file" <?php if(@$_SESSION['createCarousel']) echo "hidden = 'true'"?> >
                <div class="admin__image-area-output" id="output"></div>
                <button type="button" class="product__image-area-btn" id="image-submit-btn"  hidden ><?= $load ?></button>
                <button type="button" class="product__image-area-btn" id="image-reset-btn"  <?php if(@!$_SESSION['createCarousel']) echo "hidden = 'true'"?> ><?= $delete ?></button>

            </div>

        </div>
        <p><small class="create__block-field-error"><?= @$error['noCarousel'] ?></small></p>
        <br>
        <button type="submit"><?= $createCarousel ?></button>

    </form>

    <script>
        window.onload = function(){
            let upload = new CarouselImageUpload();
            upload.init();
        }
    </script>


</section>