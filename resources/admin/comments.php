<h2> <?= $adminCommentPage ?></h2>

<input type="hidden" name="_token" id="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

<div class="comments__drop-down-container">

    <form   id="comments_drop-down-container">

        <?= $groupBy ?>
        <select name = "order1" id="order1-drop-down-menu">
            <option></option>
            <option value="email"> Email </option>
            <option value="name"><?= $name ?></option>
            <option value="product"><?= $product ?></option>
        </select>

        <select  name="order2" id="order2-drop-down-menu">

            <option value="new_first" selected><?= $newFirst ?></option>
            <option value="old_first"><?= $oldFirst ?></option>
        </select>

        <button type="button" id="comments__drop-down-container-btn" class="comments__drop-down-container-btn">OK<button>
    </form>

</div>

<div class="admin-comments-list-container" id="admin-comments-list-container">


    <?php if($action): ?>
        <aside class="admin-notice" id="admin-notice" ><?=  $$action.$id ?>
            <span id="admin-notice__close" class="admin-notice__close">X</span>
        </aside>
    <?php endif; ?>


    <?php include PATH_SITE.'/resources/admin/partials/commentsList.php'; ?>

</div>
