<div class="admin-manufacturers__block">


    <ul class="manufacturers-menu">

        <?php foreach ($manufacturers as $manf): ?>

        <li  class="manufacturers-menu__item-container"><span class="manufacturers-menu__item" data-id="<?= $manf->id ?>"><?= $manf->title ?></span></li>

        <?php endforeach; ?>
    </ul>

</div>



