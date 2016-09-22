<div><img src="/img/small-close.png" class="busket__close" id="busket-close"> </div>
<h2 class="busket__header"><?= $busketHeader ?></h2>

<table>
   <tr>
       <th><?= $author ?></th> <th><?= $productTitle ?></th><th><?= $description ?></th><th><?= $price ?></th><th><?= $amount ?></th>
   </tr>

<?php foreach ($busketItems as $item): ?>
<?php @ $totalSum += $item->price*$item->number ?>
    <tr>
        <td><?= $item->author ?></td><td><?= $item->title ?></td><td><?= $item->description ?></td><td><?= $item->price ?></td>
        <td><input type="text" value="<?= $item->number ?>"  class="busket__change-price"> <?= $ukrCurrency ?></td>
    </tr>

<?php endforeach; ?>
<tr>
    <td colspan="4"><?= $generalPrice ?>:</td><td><?= $totalSum.':'. $ukrCurrency?></td>
</tr>
</table>

<p>
    <button class="busket__close-btn" id="busket-close-btn"><?= $closeBusket ?></button>
</p>

