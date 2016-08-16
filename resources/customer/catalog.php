<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?= $main_page ?></a>  => <span class="breadcrumb__item--current"><?=  $catalog ?></span>

</section>



<section class="left-menu">
<h4 class="left-menu__header"><?= $categoriesTitles ?></h4>
    <?= $leftCatalogMenu ?>

    <h4 class="left-menu__header-manufacturers"><?= $manufacturersTitles ?></h4>

        <ul class="left-catalog-menu">
            <?php foreach($manufacturersList as $manuf): ?>

                <li><a href="/catalog?manufacturer=<?= $manuf->translitedInEngTitle ?>" class="left-catalog-menu__link"><?= $manuf->originTitle ?></a></li>

            <?php endforeach; ?>
        </ul>
</section>




<section class="content-zone ">

    <h2 class="content-zone__header"><?= $catalog ?></h2>

    <p>

        <form action="/catalog/index" id="reset_all" class="content-zone__reset-filters">
            <button>Сбросить все фильтры</button>
        </form>

        <?php if(!empty($catalog)) : ?>



        <form  method="GET" action="/catalog/index">

            <?php if (isset($_GET['category'])) { ?> <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>" > <?php }
            if(isset($_GET['manufacturer'])) { ?> <input type="hidden" name="manufacturer" value="<?php echo $_GET['manufacturer']; ?>" > <?php } ?>

            <label for="select">Сортировать по: </label>
            <select size="1" name="order" id="select">
                <option value="default"></option>
                <option value="abc">а-я</option>
                <option value="cba">я-а</option>
                <option value="cheap_first">сначала дешевые</option>
                <option value="expensive_first">сначала дорогие</option>
            </select>

            <input type="submit" value="OK">
        </form>


        <?php endif; ?>

    </p>

    <?php foreach ($catalogResults as $item) : ?>

        <article class="content-zone__item clearfix">
            <div class="content-zone__starting-line-number"><?= $item->startingLineNumber ?></div>

            <div class="content-zone__item-output">

                <img src="/uploads/" alt="" onerror="this.style.display='none'">
                <h3><span class="content-zone__item-output-title"><?= $product_title ?> : </span> <?=$item->product_title ?></h3>
                <h4><span class="content-zone__item-output-title"><?= $author ?> : </span><?= $item->author ?></h4>
                <p><span class="content-zone__item-output-title"><?= $description ?> : </span><?= $item->description ?></p>
                <p><span class="content-zone__item-output-title"><?= $body ?> : </span><?= $item->body ?></p>
                <p><span class="content-zone__item-output-title"><?= $price ?> : </span><?= $item->price .' '.$ukr_currency?></p>
                <p><span class="content-zone__item-output-title"><?= $category ?> : </span><?= $item->category_title ?></p>
                <p><span class="content-zone__item-output-title"><?= $manufacturer ?> : <?= $item->manufacturer_title ?></span></p>
                <p><button class="content-zone__display-btn"><?= $display_item ?></button></p>

            </div>

        </article>
    <?php endforeach; ?>





        <nav class="content-zone__pagination">

            <?php
            $current = (isset($_GET['p']))? $_GET['p']: 1;

            for($i =0; $i<$pages; $i++): ?>

                <?php if($i==0 && $current>1){ ?>  <a href="<?php echo URL.'p=1' ?>"> << </a> <?php } ?>
                <?php if($i == 0 && $pages>1 && $current>1) {  ?> <a href="<?php echo URL.'p='.($current-1) ?>"> < </a>  ... <?php } ?>
                <?php

                if($i> ($current-6) && $i<($current+4)): ?>

                    <a href="<?php echo URL.'p='.($i+1); ?>"><?php if($i+1==$current){echo '<b>'.($i+1).'</b>'; } else { echo ($i+1);} ?></a>

                <?php endif; ?>
                <?php if($current<$pages): ?>
                    <?php if($i == $pages-1 && $pages>1 && $current<$pages) {  ?>...  <a href="<?php echo URL.'p='.($current+1) ?>"> > </a> <?php } ?>
                    <?php if($i==$pages-1){ ?>  <a href="<?php echo URL.'p='.$pages ?>"> >> </a> <?php } ?>
                <?php endif; ?>


            <?php endfor; ?>

        </nav>



</section>


