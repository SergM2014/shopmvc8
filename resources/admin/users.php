<div class="admin__block">

    <?php if($action): ?>

        <aside class="admin-notice <?= @$error ?>" id="admin-notice"  > <div id="admin-notice__close" class="admin-notice__close">X</div> <?=  $$action.@$id ?>

        </aside>
    <?php endif; ?>

    <section class="users-menu">

        <?php foreach ($usersList as $user): ?>

        <div  class="user-menu__item-container" data-id="<?= $user->id ?>" >

                <span class="admin__block-title"><small>Login </small></span> <?= $user->login ?>
                <span class="admin__block-title"><small>Role </small></span> <?= $user->role_title ?>
                

        </div>

        <?php endforeach; ?>
    </section>

</div>



