<div class="admin__block">

    <?php if($action): ?>

        <aside class="admin-notice <?= @$error ?>" id="admin-notice"  > <div id="admin-notice__close" class="admin-notice__close">X</div> <?=  $$action.@$id ?>

        </aside>
    <?php endif; ?>

    <ul class=sliders-menu">

        <?php foreach ($sliders as $slider): ?>

        <li  class="manufacturers-menu__item-container"><span class="manufacturers-menu__item" data-id="<?= $slider->id ?>"><?= $slider->title ?></span></li>

        <?php endforeach; ?>
    </ul>

</div>



