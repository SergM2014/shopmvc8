<section class="create__block">


    <h2><?= $createManufacturerHeader ?></h2>

    <form action="/adminManufacturers/store" method="post">


        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

        <label for="manufacturer_title" class="create__block-title"><?= $createManufacturerTitle ?></label>
        <p>
            <input type="text" name="manufacturer_title" id="manufacturer_title" value="<?= @$error['manufacturer_title']? "" : strip_tags(@$_POST['manufacturer_title'])  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['manufacturer_title'] ?></small></p>

        <br>
        <label for="manufacturer_url" class="create__block-title"><?= $createManufacturerUrl ?></label>
        <p>
            <input type="text" name="manufacturer_url" id="manufacturer_url" value="<?= @$error['manufacturer_url']? "" : strip_tags(@$_POST['manufacturer_url'])  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['manufacturer_url'] ?></small></p>

        <br>


        <button type="submit"><?= $createManufacturer ?></button>

    </form>


</section>