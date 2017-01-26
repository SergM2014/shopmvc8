<?php $id = (int)$_POST['id']; ?>

<!--<p class='popUp-menu-item' id="popUp-menu-item-view" data-product-id = "<?/*= $id */?>" data-image="<?/*= $_POST['image'] */?>" ><?/*= $viewImage */?></p>-->
<p class='popUp-menu-item' id="popUp-menu-item-delete" data-product-id = "<?= $id ?>" data-image="<?= $_POST['image'] ?>"><?= $delete ?></p>