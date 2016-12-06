<section class="create__block">


    <h2><?= $updateManufacturerHeader ?></h2>

    <form action="/adminManufacturers/update" method="post">


        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">
        <input type="hidden" name="id" value ="<?= (int)$manufacturer->id ?>">

        <label for="category_title" class="create__block-title"><?= $updateManufacturerTitle ?></label>
        <p>
            <input type="text" name="manufacturer_title" id="manufacturer_title" value="<?=  @isset($_POST['manufacturer_title']) ? strip_tags(@$_POST['manufacturer_title']) : $manufacturer->title  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['manufacturer_title'] ?></small></p>

        <br>
        <label for="category_url" class="create__block-title"><?= $updateManufacturerUrl ?></label>
        <p>
            <input type="text" name="manufacturer_url" id="manufacturer_url" value="<?=  @isset($_POST['manufacturer_url']) ? strip_tags(@$_POST['manufacturer_url']) : $manufacturer->url  ?>" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['manufacturer_url'] ?></small></p>

        <br>


        <button type="submit"><?= $updateManufacturer ?></button>

    </form>


</section>