
<table class="admin-products-list">
    <tr class="admin-products-list__header">
        <th>№</th><th><?= $images ?></th><th><?= $author ?></th><th><?= $productTitle ?></th><th><?= $description ?></th><th><?= $category ?></th><th><?= $manufacturerTitle ?></th>
    </tr>
<?php foreach ($products as $product): ?>


    <tr class="admin-products-list__row">
        <td><?= $product->startingLineNumber ?></td><td><?= $product->images ?></td><td><?= $product->author ?></td><td><?= $product->product_title ?></td>
        <td><i><?= $product->description ?></i></td><td><?= $product->category_title ?></td><td><?= $product->manufacturer_title ?></td>
    </tr>

<?php endforeach; ?>
</table>

<?php if($pages>1): ?>

    <nav class="pagination">

        <?php
        $current =$_GET['p']?? $_POST['p']?? 1;

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

<?php endif; ?>