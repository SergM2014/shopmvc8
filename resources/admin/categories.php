<div id="admin-categories__block" class="admin-categories__block">

    <?php if($action): ?>

        <aside class="admin-notice <?= @$error ?>" id="admin-notice"  > <div id="admin-notice__close" class="admin-notice__close">X</div> <?=  $$action.@$id ?>

        </aside>
    <?php endif; ?>

<?php echo $categories; ?>

</div>

