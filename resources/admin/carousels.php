<div class="admin__block">

    <?php if($action): ?>

        <aside class="admin-notice <?= @$error ?>" id="admin-notice"  > <div id="admin-notice__close" class="admin-notice__close">X</div> <?=  $$action.@$id ?>

        </aside>
    <?php endif; ?>

    <section class="carousels-menu">

        <?php foreach ($carousels as $carousel): ?>

        <div  class="carousels-menu__item-container" data-id="<?= $carousel->id ?>" >

               <p> <span class="admin__block-title"><?= $sliderUrl ?> </span> <?= $carousel->url ?></p>
            <img src="/uploads/carousel/<?= $carousel->image ?>" alt="" class="carousel-menu__image">
        </div>

        <?php endforeach; ?>
    </section>

</div>



