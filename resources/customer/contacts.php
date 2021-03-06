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

    <?php if(@ $success) : ?>

        <h2 class="success"><?= $succesedMessage ?></h2>

    <?php else: ?>
        <div class="content-zone__write-us">
            <?php include_once (PATH_SITE.'/resources/customer/partials/writeUsForm.php') ?>
        </div>
    <?php endif; ?>

</section>


<div class="clearfix"></div>

<?php include_once(PATH_SITE.'/resources/customer/carousel.php'); ?>