<div><img src="/public/img/small-close.png" class="busket__close" id="busket-close"> </div>

<?php if(!empty($busketItems)) : ?>

<h2 class="busket__header"><?= $busketHeader ?></h2>

<form id="busketOrder">
    <table>
       <tr>
           <th class="busket__product-title"><?= $author ?></th> <th class="busket__product-title"><?= $productTitle ?></th>
           <th class="busket__product-title"><?= $description ?></th><th class="busket__product-title"><?= $price ?></th>
           <th class="busket__product-title"><?= $amount ?></th>
       </tr>

        <?php foreach ($busketItems as $item): ?>
        <?php @ $totalSum += $item->price*$item->number ?>
            <tr>
                <td><?= $item->author ?></td><td><?= $item->title ?></td><td class="busket__product-description"><?= $item->description ?></td>
                <td class="busket__product-price"><?= $item->price ?><?= $ukrCurrency ?></td>
                <td class="busket__product-amount"><input type="text" name="<?= $item->id ?>" value="<?= $item->number ?>" class="busket__change-amount" ></td>
            </tr>

        <?php endforeach; ?>

    <tr>
        <td colspan="3" class="product__general-price-description"><?= $generalPrice ?>:</td><td class="busket__general-price-sum" colspan="2"><?= $totalSum.' '. $ukrCurrency?></td>
    </tr>
    </table>

    <div class="busket__footer">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessBusket') ?>">

        <button type="submit" class="busket__make-order" id="busket-make-order"><?= $makeOrder ?></button>

        <button type="submit" class="busket__update-btn" id="busket-update-btn"><?= $updateBusket ?></button>

        <button type="button" class="busket__close-btn" id="busket-close-btn"><?= $closeBusket ?></button>


    </div>
</form>

<?php else: ?>

    <h2 class="busket__header"><?= $emptyBusket ?></h2>

<?php endif; ?>

