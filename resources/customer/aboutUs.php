<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?= $main_page ?></a>  => <span class="breadcrumb__item--current"><?=  $about_us ?></span>

</section>



<section class="left-menu">

    <?= $categoriesVertMenu ?>

</section>




<section class="content-zone">

<?= $aboutUs ?>

</section>


<div class="clearfix"></div>

<?php include_once(PATH_SITE.'/resources/customer/carousel.php'); ?>