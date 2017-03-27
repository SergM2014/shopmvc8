<section class="update-comment__block">

    <h2><?= $comment->product_title ?></h2>

    <?php if($comment->avatar): ?>

        <div class = "avatar-container">
            <img src="/uploads/avatars/<?= $comment->avatar ?>">
        </div>

    <?php endif; ?>

    <div class="update-comment__block-title"><?= $name ?>: </div>
    <p><?=  $comment->name ?></p>

    <div class="update-comment__block-title"><?= $email ?>: </div>
    <p> <?= $comment->email ?></p>

    <form action="/<?= \Lib\HelperService::currentLang() ?>adminComments/update" method ="post">

        <input type="hidden" name="id" value="<?= $comment->id ?>">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>" >

        <div class="update-comment__block-title"><label><?= $commentTitle ?></label></div>

        <p> <textarea cols="45" rows="15" name="comment" ><?= @$error['comment'] ? htmlspecialchars(@$_POST['comment']): $comment->comment ?></textarea></p>

        <p><small class="update-comment__block-field-error"><?= @$error['comment'] ?></small></p>

    <span class="update-comment__block-title"><?= $created ?>: </span>
    <?= $comment->created_at ?>
    <p><?= $comment->changed == 1? '<span class="changed">'.$changed.'</span>' : '<span class="notChanged">'.$notChanged.'</span>' ?></p>
    <p>
        <input type="radio" name="published" value="1" <?= $comment->published == "1"? 'checked':'' ?> ><span class="<?= $comment->published == "1"? 'published':'' ?>"><?= $published ?></span>
        <input type="radio" name="published" value="0" <?= $comment->published == "0"? 'checked':'' ?> ><span class="<?= $comment->published == "0"? 'notPublished':'' ?>"> <?= $notPublished ?></span>
    </p>
    <br>
        <button type="submit" id="update-comment__block-submit-btn"><?= $updateComment ?></button>
    </form>

</section>
