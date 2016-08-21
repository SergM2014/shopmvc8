<section class="breadcrumbs">

    <span class="breadcrumb__item--current"><?=  $main_page ?></span>

</section>



<section class="left-menu">

    <?= $categoriesVertMenu ?>

</section>




<section class="content-zone">

<?= $aboutUs ?>

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