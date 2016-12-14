<section class="create__block">


    <h2><?= $createSliderHeader ?></h2>

    <form enctype="multipart/form-data" action="/adminSliders/store" method="post" >

        <input type="hidden" type="hidden" name="action" value="createSlider" >
        <input type="hidden" id="_token" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

        <label for="slider_title" class="create__block-title"><?= $createSliderTitle ?></label>
        <p>
            <input type="text" name="slider_title" id="slider_title" value="<?= @$error['slider_title']? "" : strip_tags(@$_POST['slider_title'])  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['slider_title'] ?></small></p>

        <br>
        <label for="slider_url" class="create__block-title"><?= $createSliderUrl ?></label>
        <p>
            <input type="text" name="slider_url" id="slider_url" value="<?= @$error['slider_url']? "" : strip_tags(@$_POST['slider_url'])  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['slider_url'] ?></small></p>

        <br>




        <label for="file" class="create__block-title" ><?= $addImage ?></label>
        <br>

        <div id="admin__image-area" class=" admin__image-area clearfix">
            <div class="admin__image-area-left">

                <img src="<?= @$_SESSION['createSlider']?'/uploads/slider/'.$_SESSION['createSlider'] : '/img/nophoto.jpg' ?>" class="product__image-thumb" id="image_preview">

                <div  id="progress-container" hidden >
                    <progress id="progress" max="100" value="0"></progress>
                </div>

            </div>

            <div class="admin__image-area-right">

                <input type="file" id="file" <?php if(@$_SESSION['createSlider']) echo "hidden = 'true'"?> >
                <span class="product__image-area-output" id="output"></span>
                <button type="button" class="product__image-area-btn" id="image-submit-btn"  hidden ><?= $load ?></button>
                <button type="button" class="product__image-area-btn" id="image-reset-btn"  <?php if(@!$_SESSION['createSlider']) echo "hidden = 'true'"?> ><?= $delete ?></button>

            </div>

        </div>
        <p><small class="create__block-field-error"><?= @$error['noSlider'] ?></small></p>
        <br>
        <button type="submit"><?= $createSlider ?></button>

    </form>

    <script src="/assets/js/adminUploadSlider.js"></script>


</section>