<div class="admin__block">

    <?php if($action): ?>

        <aside class="admin-notice <?= @$error ?>" id="admin-notice"  > <div id="admin-notice__close" class="admin-notice__close">X</div> <?=  $$action.@$id ?>

        </aside>
    <?php endif; ?>

    <ul class="sliders-menu">

        <?php foreach ($sliders as $slider): ?>

        <li  class="sliders-menu__item-container" data-id="<?= $slider->id ?>" >
               <p> <span class="admin__block-title"> <?= $sliderName ?> </span> <?= $slider->title ?> </p>
               <p> <span class="admin__block-title"><?= $sliderUrl ?> </span> <?= $slider->url ?></p>
            <img src="/uploads/slider/<?= $slider->image ?>" alt="" class="slider-menu__image">
        </li>

        <?php endforeach; ?>
    </ul>

</div>



