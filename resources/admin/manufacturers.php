<div class="admin-manufacturers__block">

    <?php if($action): ?>

        <aside class="admin-notice <?= @$error ?>" id="admin-notice"  > <div id="admin-notice__close" class="admin-notice__close">X</div> <?=  $$action.@$id ?>

        </aside>
    <?php endif; ?>

    <ul class="manufacturers-menu">

        <?php foreach ($manufacturers as $manf): ?>

        <li  class="manufacturers-menu__item-container"><span class="manufacturers-menu__item" data-id="<?= $manf->id ?>"><?= $manf->title ?></span></li>

        <?php endforeach; ?>
    </ul>

</div>



