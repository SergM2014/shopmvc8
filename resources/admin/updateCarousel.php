<section class="admin__block">


    <h2><?= $updateCarouselHeader ?></h2>

    <form enctype="multipart/form-data" action="/adminCarousels/update" method="post" >

        <input type="hidden" type="hidden" name="action" value="updateCarousel" >
        <input type="hidden" id="_token" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">
        <input type="hidden" name="id" value="<?= $theCarousel->id ?>" >



        <br>
        <label for="carousel_url" class="create__block-title"><?= $updateCarouselUrl ?></label>
        <p>
            <input type="text" name="carousel_url" id="carousel_url" value="<?= !@$error['carousel_url']? $theCarousel->url : strip_tags(@$_POST['carousel_url'])  ?>" >
        </p>
        <p><small class="admin__block-field-error"><?= @$error['carousel_url'] ?></small></p>

        <br>




        <label for="file" class="admin__block-title" ><?= $updateImage ?></label>
        <br>

        <div id="admin__image-area" class=" admin__image-area clearfix">
            <div class="admin__image-area-left">

                <img src="<?= @$_SESSION['updateCarousel']?'/public/uploads/carousel/'.$_SESSION['updateCarousel'] : '/public/uploads/carousel/'.$theCarousel->image ?>" class="product__image-thumb" id="image_preview">

                <div  id="progress-container" hidden >
                    <progress id="progress" max="100" value="0"></progress>
                </div>

            </div>

            <div class="admin__image-area-right">

                <input type="file" id="file" <?php if(!@$_SESSION['updateCarousel']) echo "hidden = 'true'"?> >
                <div class="admin__image-area-output" id="output"></div>
                <button type="button" class="product__image-area-btn" id="image-submit-btn"  hidden ><?= $load ?></button>
                <button type="button" class="product__image-area-btn" id="image-reset-btn"  <?php if(@$_SESSION['updateCarousel']) echo "hidden = 'true'"?> ><?= $delete ?></button>

            </div>

        </div>
        <p><small class="admin__block-field-error"><?= @$error['noCarousel'] ?></small></p>
        <br>
        <button type="submit"><?= $updateCarousel ?></button>

    </form>

    <script>
        window.onload = function(){
            let upload = new CarouselImageUpload();
            upload.init();
        }
    </script>


</section>