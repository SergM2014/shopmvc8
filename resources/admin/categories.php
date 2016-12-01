<div id="admin-categories__block" class="admin-categories__block">

    <?php if($action): ?>
        <aside class="admin-notice" id="admin-notice" ><?=  $$action.$id ?>
            <span id="admin-notice__close" class="admin-notice__close">X</span>
        </aside>
    <?php endif; ?>

<?php echo $categories; ?>

</div>

