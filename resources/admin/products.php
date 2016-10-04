


<h2 class="admin__h2-title"><?= $prozessYourProducts ?></h2>

<div  class="select-order__container">
    <select  name="order">
        <option  value="old_first"><?= $oldFirst ?></option>
        <option  value="new_first"><?= $newFirst ?></option>
        <option value="email"><?= $mailOrder ?></option>
        <option value="name"><?= $nameOrder ?></option>
    </select>


    <?= $categories  ?>

    <select name="manufacturers" class="manufacturers-drop-down-menu">
        <option></option>
        <?php foreach ($manufacturers as $manufacturer): ?>
            <option value ="<?= $manufacturer->eng_translit_title ?>"><?= $manufacturer->title ?></option>

        <?php endforeach; ?>
    </select>

    <button type="button" id="reorder" class="select-order__button">OK<button>
</div>

<div id="insert-products" class="admin-products-list-container">

    <?php include PATH_SITE.'/resources/admin/partials/productsList.php'; ?>

</div>
