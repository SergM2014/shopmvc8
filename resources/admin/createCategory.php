<section class="create-category__block">


    <h2><?= $createCategoryHeader ?></h2>

    <form action="/adminCategories/store" method="post">


        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

        <label for="category_title" class="create-category__block-title"><?= $createCategoryTitle ?></label>
        <p>
            <input type="text" name="category_title" id="category_title" value="<?= @!$error ? @$category->title: '' ?>" >
        </p>
        <p><small class="create-category__block-field-error"><?= @$error ?></small></p>

        <br>


        <label for="parent_id" class="create-category__block-title" ><?= $chooseParentCategory ?></label>
        <p>
            <?= $categories ?>
        </p>
        <br>
        <button type="submit"><?= $createCategory ?></button>

    </form>


</section>