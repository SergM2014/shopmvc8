<section class="content__slider">


    <!-- realization of slider-->
    <link rel="stylesheet" href="/lib/jqueryfreeslider/style.css">

    <?php $num=1; if(!empty($slider)): ?>
        <div id="slider">
            <?php foreach($slider as $image): ?>
                <div class="slider_image notdisplayed" style="/*display:none;*/ background:  url(<?php echo '/uploads/slider/'.$image->image; ?>)  50% 50%" id="<?php echo $num;?>">

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


    <script src="/lib/jqueryfreeslider/script.js"></script>
</section>
   <!-- <div class="clearfix"></div>-->


<section class="content__carousel">
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