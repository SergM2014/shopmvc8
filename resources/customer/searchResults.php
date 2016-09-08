<?php


if($searchResults) : ?>

    <?php foreach($searchResults as $result) : ?>

        <p class="search-results__item" data-id="<?= $result->id ?>"><?= $result->author.'  ' ?><em><?= $result->title ?></em></p>

    <?php endforeach; ?>
<?php else: ?>
    <p class="search-results__nothing-found"><?= $nothingFound ?></p>
<?php endif; ?>
