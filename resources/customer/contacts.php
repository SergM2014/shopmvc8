<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?= $main_page ?></a>  => <span class="breadcrumb__item--current"><?=  $contacts ?></span>

</section>



<section class="left-menu">

    <?= $categoriesVertMenu ?>

</section>




<section class="content-zone">

    <div class="clearfix">

        <?= $contactsInfo ?>

    </div>

    <div class="content-zone__write-us">
        <h2 class="content-zone__write-us-header"><?= $writeUs ?></h2>


        <script src="/lib/ckeditor/ckeditor.js"></script>

        <form class="content-zone__form" method="POST" action="/contacts/addMessage">
            <p class="content-zone__form-element">
                <label for="writeUsName" class="content-zone__form-element-titel"><?= $enterYourName ?></label>
                <input type="text" name="writeUsName" id="writeUsName" class="content-zone__form-element-field" required>
                <small id="writeUsNameError" class="content-zone__form-error--hidden"><?= $writeUsNameError ?></small>
            </p>

            <p class="content-zone__form-element">
                <label for="writeUsPhone" class="content-zone__form-element-titel"><?= $enterYourPhone ?></label>
                <br>
                <small><?= $phoneFormatExample ?></small>
                <input type="tel" name="writeUsPhone" id="writeUsPhone" class="content-zone__form-element-field" required>
                <small id="writeUsPhoneError" class="content-zone__form-error--hidden"><?= $writeUsPhoneError ?></small>
            </p>

            <p class="content-zone__form-element">
                <label for="writeUsEmail" class="content-zone__form-element-titel"><?= $enterYourEmail ?></label>
                <input type="email" name="writeUsEmail" id="writeUsEmail" class="content-zone__form-element-field" required>
                <small id="writeUsEmailError" class="content-zone__form-error--hidden"><?= $writeUsEmailError ?></small>
            </p>


                <label class="content-zone__form-element-titel"><?= $enterYourMessage ?></label>
                <p><small><?= $tagsMessageRemark ?></small></p>
                <textarea name="message" id="writeUsMessage" class="content-zone__form-element-message" required></textarea>
                <small id="writeUsMessageError" class="content-zone__form-error--hidden"><?= $writeUsMessageError ?></small>


            <p class="content-zone__form-element-submit-container">
                <button class="content-zone__form-element-submit" id="sendMessage"> <?= $send ?></button>
            </p>
        </form>

    </div>
<script>CKEDITOR.replace('writeUsMessage');</script>


</section>


<div class="clearfix"></div>

<section class="content__carousel ">
    <link rel="stylesheet" href="/lib/jqueryfreecarousel/style.css">

    <div id="scroller_container" >
        <div>
            <?php
            foreach($carousel as $image){
                ?> <a href="<?php echo $image->url; ?>"><img src="<?php echo URL.'uploads/carousel/'.$image->image; ?>"></a>
            <?php    } ?>

        </div>
    </div>

    <script src="/lib/jqueryfreecarousel/script.js"></script>
</section>