<section class="update-category__block">


    <h2><?= $editCategory ?></h2>
    <form action="/adminCategories/update" method="post">

        <input type="hidden" name="id" value="<?= $category->id ?>">
        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

        <label for="category_title" class="update-category__block-title"><?= $editCategoryTitle ?></label>
        <p>
            <input type="text" name="category_title" id="category_title" value="<?= @!$error ? $category->title: '' ?>" >
        </p>
        <p><small class="update-category__block-field-error"><?= @$error ?></small></p>

        <br>


        <label for="parent_id" class="update-category__block-title" ><?= $chooseParentCategory ?></label>
        <p>
            <?= $categories ?>
        </p>
        <br>
        <button type="submit"><?= $updateCategory ?></button>

    </form>


</section>
