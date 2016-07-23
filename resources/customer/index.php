<section class="slider-content">


    <!-- realization of slider-->
    <link rel="stylesheet" href="/lib/jqueryfreeslider/style.css">

    <?php $num=1; if(!empty($slider)): ?>
        <div id="slider">
            <?php foreach($slider as $image): ?>
                <div class="thumb" style="display:none; background: url(<?php echo '/uploads/slider/'.$image->image; ?>)  100%;" id="<?php echo $num;?>">

                    <div class="bottom">
                        <a href="/<?php echo $image->url; ?>">
                            <?php echo $image->title; ?>
                        </a>
                    </div>

                </div><!-- thumb -->
                <?php $num++; endforeach; ?>
        </div>
    <?php endif; ?>
    <!-- end of realization of slider-->


    <script src="/lib/jqueryfreeslider/script.js"></script>