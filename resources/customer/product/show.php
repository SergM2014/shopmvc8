<section class="breadcrumbs">

    <a href="/" class="breadcrumb__item"><?= $main_page ?></a>  => <a href="<?php echo URL; ?>catalog "
      class="breadcrumb__item"><?=  $catalog ?></a> => <span class="breadcrumb__item--current"><?=  $product ?></span>

</section>

<section class="content__product-info">

    <?php if($productInfo->images) : ?>
        <section class="content__product-image-container">

            <?php

            $counter=1;
            foreach($productInfo->images as $image ) : ?>

                <div class="content__product-image-wrapper">
                    <img src="/uploads/product_images/thumbs/<?php echo $image; ?>" rel="<?= $counter; ?>" class="content__product-image-preview">
                </div>

                <?php
                $counter++;
            endforeach; ?>

        </section>
    <?php endif; ?>




    <article class="content__product-details">
        <h2 class="content__product-title"><?php echo $productInfo->title; ?></h2>
        <p><b><?= $author ?>:</b>  <?php echo $productInfo->author; ?></p><br>
        <p><b><?= $description ?>:</b> <?php echo $productInfo->description; ?></p><br>
        <p><b><?= $body ?>:</b> <?php echo $productInfo->body; ?></p><br>
        <?php if (isset($productInfo->category_title)) echo '<p> <b>'.  $category .' :</b> '.$productInfo->category_eng_title.'</p><br>'; ?>
        <?php if (isset($productInfo->manufacturer_title)) echo '<p> <b>'.$manufacturer.' :</b> '.$productInfo->manufacturer_title.'</p><br>'; ?>
        <p class="red"><b><?= $price ?>:</b> <span id="the_price"><?php echo $productInfo->price; ?></span> грн</p>
        <button  id="add_item" data-item="<?php echo $_GET['id']; ?>" class="content__product--add" data-token="">  <?= $buy ?>  </button>
    </article>

    <section class="content__product-commentsarea">
        <div class="content_product-published-comments ">

            <?php if(empty($productComments)): ?>
                <h2><?= $noComments ?></h2>

            <?php else: ?>

            <h2><?= $comments ?></h2>

            <form id="comments_order" data-id="<?php echo $_GET['id']; ?>">
                <p><b><?= $sortDueTo ?>: </b></p>
                <label><input name="comments_order" type="radio" value="new_first" checked> <?= $newFirst ?> </label>
                <label><input name="comments_order" type="radio" value="old_first"> <?= $oldFirst ?> </label>

            </form>
            <div id="ordered_comments"
            <?php include PATH_SITE.'/resources/customer/partials/orderedComments.php'; ?>
        </div>
        <?php endif; ?>

</section>

<?php  include PATH_SITE.'/resources/customer/partials/commentBlock.php'  ?>


</section>