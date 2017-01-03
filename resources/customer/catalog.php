<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?= $main_page ?></a>  => <span class="breadcrumb__item--current"><?=  $catalog ?></span>

</section>



<section class="left-menu">
<h4 class="left-menu__header"><?= $categoriesTitles ?></h4>
    <?= $leftCatalogMenu ?>

    <div class="left-menu__manufacturers-block">
        <h4 class="left-menu__header-manufacturers"><?= $manufacturersTitles ?></h4>

        <ul class="left-catalog-menu">
            <?php foreach($manufacturersList as $manuf): ?>

                <li><a href="/catalog?manufacturer=<?= $manuf->eng_translit_title ?>" class="left-catalog-menu__link"><?= $manuf->title ?></a></li>

            <?php endforeach; ?>
        </ul>
    </div>

</section>




<section class="content-zone ">

    <h2 class="content-zone__header"><?= $catalog ?></h2>

    <div>

        <form action="/catalog/index" id="reset_all" class="content-zone__reset-filters">
            <button><?= $resetAllFilters ?></button>
        </form>

        <?php if(!empty($catalog)) : ?>



        <form  method="GET" action="/catalog/index" class="sort-container">

            <?php if (isset($_GET['category'])) { ?> <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>" > <?php }
            if(isset($_GET['manufacturer'])) { ?> <input type="hidden" name="manufacturer" value="<?php echo $_GET['manufacturer']; ?>" > <?php } ?>

            <label for="select"><?= $sortDueTo ?>: </label>
            <select size="1" name="order" id="select">
                <option value="default"></option>
                <option value="abc"><?= $aZ ?></option>
                <option value="cba"><?= $zA ?></option>
                <option value="cheap_first"><?= $cheapFirst ?></option>
                <option value="expensive_first"><?= $expensiveFirst ?></option>
            </select>

            <input type="submit" value="OK">
        </form>


        <?php endif; ?>

    </div>

    <?php foreach ($catalogResults as $item) : ?>

        <article class="content-zone__item clearfix">
            <div class="content-zone__starting-line-number"><?= $item->startingLineNumber ?></div>

            <div class="content-zone__item-output">

                <?php if(! is_null($item->images)): ?>
                        <?php foreach($item->images as $image) :?>
                            <img src="/uploads/productsImages/thumbs/<?= $image ?>" alt="" class="content-zone__item-output-image" data-image="<?= $image ?>">
                        <?php endforeach; ?>
                <?php endif; ?>

                <h3><span class="content-zone__item-output-title--shifted"><?= $productTitle ?> : </span> <?=$item->product_title ?></h3>
                <h4><span class="content-zone__item-output-title--shifted"><?= $author ?> : </span><?= $item->author ?></h4>
                <p><span class="content-zone__item-output-title"><?= $description ?> : </span><?= $item->description ?></p>
                <p><span class="content-zone__item-output-title"><?= $body ?> : </span><?= $item->body ?></p>
                <p><span class="content-zone__item-output-title"><?= $price ?> : </span><?= $item->price .' '.$ukrCurrency?></p>
                <p><span class="content-zone__item-output-title"><?= $category ?> : </span><?= $item->category_title ?></p>
                <p><span class="content-zone__item-output-title"><?= $manufacturer ?> : <?= $item->manufacturer_title ?></span></p>
                <p><a href="/product/show?id=<?= $item->product_id ?>" class="content-zone__display-btn"><?= $displayItem ?></a></p>

            </div>

        </article>
    <?php endforeach; ?>





        <nav class="pagination">

            <?php
            $current = (isset($_GET['p']))? $_GET['p']: 1;

            for($i =0; $i<$pages; $i++): ?>

                <?php if($i==0 && $current>1){ ?>  <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p=1' ?>"> << </a> <?php } ?>
                <?php if($i == 0 && $pages>1 && $current>1) {  ?> <a href="<?= URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($current-1) ?>"> < </a>  ... <?php } ?>
                <?php

                if($i> ($current-6) && $i<($current+4)): ?>

                    <?php if($i+1 == $current): ?>
                        <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($i+1); ?>" class="pagination__current-item-link" ><span class="pagination__current-item"><?php echo $i+1 ?></span>
                         <?php else:  ?>
                        <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($i+1); ?>" ><?php echo ($i+1); ?></a>
                        <?php  endif;

            endif; ?>
                <?php if($current<$pages): ?>
                    <?php if($i == $pages-1 && $pages>1 && $current<$pages) {  ?>...  <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.($current+1) ?>"> > </a> <?php } ?>
                    <?php if($i==$pages-1){ ?>  <a href="<?php echo URL.\Lib\HelperService::getRidOfRepeatedItemsInUrl('p').'p='.$pages ?>"> >> </a> <?php } ?>
                <?php endif; ?>


            <?php endfor; ?>

        </nav>



</section>


