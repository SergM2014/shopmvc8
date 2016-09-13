<?php foreach($productComments as $commentItem): ?>


    <article class="product__comment-item">
        <div class=" product__comment-item-avatar ">
            <?php if (isset($commentItem->avatar)){ ?> <p><img src="/uploads/avatars/<?php echo $commentItem->avatar; ?>" > </p> <?php } ?>
            <b> <?php echo $commentItem->name ?></b>
        </div>
        <div class="product__comment-item-text">
            <i><?php echo $commentItem->comment ?></i>

        </div>
        <p class="product__comment-item-time" ><b><?php echo date('d-m-Y H:i',strtotime($commentItem->created_at)); ?></b></p>
    </article>



<?php endforeach; ?>