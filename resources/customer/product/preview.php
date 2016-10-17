<p><img src="/img/small-close.png" alt ="close" class="close-preview-product" id="close-preview-product"></p>
<h2><?php echo $product_info->title ?></h2>
<p><b><?= $author ?>: </b><?php echo $product_info->author ?></p>
<p><b><?= $description ?>:</b><?php echo $product_info->description ?></p>
<p><b><?= $price ?>: </b><?php echo $product_info->price ?></p>
<a href="/product/show?id=<?= $product_info->id ?>" class="go-to-product"><?= $goToProduct ?></a>