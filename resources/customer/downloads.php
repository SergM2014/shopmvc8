<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?= $main_page ?></a>  => <span class="breadcrumb__item--current"><?=  $download ?></span>

</section>



<section class="left-menu">

    <?= $categoriesVertMenu ?>

</section>




<section class="content-zone">

    <?= $downloads ?>

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