<h2 class="busket-errors__title"><?= $busketErrorsTitle ?></h2>
<div class="busket-errors__messages">
    <?php foreach ($errors as $errorName =>$error): ?>
    <h4><?= $youMadeErrorIn.' '. $$errorName  .' =>'?> <?= $error ?></h4>
        <br>

    <?php endforeach; ?>

    <h3 class="busket-errors__messages-footer"><?= $tryOneMoreTime ?></h3>
</div>