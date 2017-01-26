<section class="breadcrumbs">

    <span class="breadcrumb__item--current"><?=  $main_page ?></span>

</section>



<section class="left-menu">

        <?= $categoriesVertMenu ?>

</section>




<section class="content__slider">


    <!-- realization of slider-->
    <link rel="stylesheet" href="/public/lib/jqueryfreeslider/style.css">

    <?php $num=1; if(!empty($slider)): ?>
        <div id="slider">
            <?php foreach($slider as $image): ?>
                <div class="slider_image notdisplayed" style="/*display:none;*/ background-image:  url(<?php echo '/public/uploads/slider/'.$image->image; ?>) ;" id="<?php echo $num;?>">

                    <div class="bottom bottom_title">
                        <a href="/<?php echo $image->url; ?>">
                            <?php echo $image->title; ?>
                        </a>
                    </div>

                </div><!-- slider_thumb -->
                <?php $num++; endforeach; ?>
        </div>
    <?php endif; ?>
    <!-- end of realization of slider-->


    <script src="/public/lib/jqueryfreeslider/script.js"></script>
</section>


<div class="clearfix"></div>

<?php include_once(PATH_SITE.'/resources/customer/carousel.php'); ?>