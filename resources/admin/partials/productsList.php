
<table class="admin-products-list">
    <tr class="admin-products-list__header">
        <th>№</th><th><?= $images ?></th><th><?= $author ?></th><th><?= $productTitle ?></th><th><?= $description ?></th><th><?= $price ?></th><th><?= $category ?></th><th><?= $manufacturerTitle ?></th>
    </tr>
<?php foreach ($products as $product): ?>


    <tr class="admin-products-list__row">
        <td><?= $product->startingLineNumber ?></td><td><?= $product->images ?></td><td><?= $product->author ?></td><td><?= $product->product_title ?></td>
        <td><i><?= $product->description ?></i></td><td><?= $product->price ?></td><td><?= $product->category_title ?></td><td><?= $product->manufacturer_title ?></td>
    </tr>

<?php endforeach; ?>
</table>

<?php if($pages>1): ?>

    <nav class="products-pagination" id="products-pagination">

        <?php
        $current =$_GET['p']?? $_POST['p']?? 1;

        for($i =0; $i<$pages; $i++): ?>

            <?php if($i==0 && $current>1){ ?>  <span class="pagination-item" data-p="1"> << </span> <?php } ?>
            <?php if($i == 0 && $pages>1 && $current>1) {  ?> <span class="pagination-item" data-p="<?= $current-1 ?>"> < </span>  ... <?php } ?>
            <?php

            if($i> ($current-6) && $i<($current+4)): ?>

                <?php if($i+1==$current){echo '<span class="pagination-item-current" id="pagination-item-current" data-p="'.($i+1).'">'.($i+1).'</span>'; }
                        else { echo '<span class="pagination-item" data-p="'.($i+1).'" >'. ($i+1).'</span>';} ?>

            <?php endif; ?>
            <?php if($current<$pages): ?>
                <?php if($i == $pages-1 && $pages>1 && $current<$pages) {  ?>...  <span class="pagination-item" data-p="<?= $current+1 ?>" > > </span> <?php } ?>
                <?php if($i==$pages-1){ ?>  <span class="pagination-item" data-p="<?= $pages ?>" > >> </span> <?php } ?>
            <?php endif; ?>


        <?php endfor; ?>
    </nav>

<?php endif; ?>