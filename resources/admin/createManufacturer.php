<section class="create__block">


    <h2><?= $createManufacturerHeader ?></h2>

    <form action="/adminManufacturers/store" method="post">


        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

        <label for="category_title" class="create__block-title"><?= $createManufacturerTitle ?></label>
        <p>
            <input type="text" name="manufacturer_title" id="manufacturer_title" value="<?= @$error['title']? "" : @$title  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['title'] ?></small></p>

        <br>
        <label for="category_url" class="create__block-title"><?= $createManufacturerUrl ?></label>
        <p>
            <input type="text" name="manufacturer_url" id="manufacturer_url" value="<?= @$error['url']? "" : @$url  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['url'] ?></small></p>

        <br>


        <button type="submit"><?= $createManufacturer ?></button>

    </form>


</section>