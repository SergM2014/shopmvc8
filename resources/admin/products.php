


<h2 class="admin__h2-title"><?= $prozessYourProducts ?></h2>

<input type="hidden" name="_token" id="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

<div  class="products__drop-down-container">
    <select  name="order" id="order-drop-down-menu">
        <option value="default"></option>
        <option value="abc"><?= $aZ ?></option>
        <option value="cba"><?= $zA ?></option>
        <option value="cheap_first"><?= $cheapFirst ?></option>
        <option value="expensive_first"><?= $expensiveFirst ?></option>
    </select>


    <?= $categories  ?>

    <select name="manufacturers" class="manufacturers-drop-down-menu" id="manufacturers-drop-down-menu">
        <option></option>
        <?php foreach ($manufacturers as $manufacturer): ?>
            <option value ="<?= $manufacturer->eng_translit_title ?>"><?= $manufacturer->title ?></option>

        <?php endforeach; ?>
    </select>

    <button type="button" id="products__drop-down-container-btn" class="products__drop-down-container-btn">OK<button>
</div>

<div id="insert-products" class="admin-products-list-container">

    <?php if($action): ?>
        <aside class="admin-product-list-notice" id="admin-product-list-notice" ><?=  $$action.$id ?>
            <span id="admin-products-list-notice__close" class="admin-products-list-notice__close">X</span>
        </aside>
    <?php endif; ?>

    <?php include PATH_SITE.'/resources/admin/partials/productsList.php'; ?>

</div>
