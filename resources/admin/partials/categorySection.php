<div class="admin-product__field">
    <label for="category_list" class="admin-product__field-label"><?= $category ?></label><br>

    <section id="category_list">

        <input type="hidden" name="category_ids" id="category_ids" value="">



            <label for="admin-product__existing-categories" class="admin-product__field-label"><small><?= $existingCategories ?></small></label><br>
            <ul id="admin-product__existing-categories" class="admin-product__existing-categories">

                <?php if(@$productExistingCategories): ?>

                <?php foreach($productExistingCategories as $key =>$value) : ?>
                    <?php include(PATH_SITE.'/resources/admin/partials/existingCategory.php') ?>
                <?php endforeach  ?>

                <?php else: ?>

                <?php endif ?>

            </ul>

            <script>
                let ids= [];
                let categoriesList = document.getElementById('admin-product__existing-categories').querySelectorAll('li');

                for (let i=0; i<categoriesList.length; i++){
                    ids.push(categoriesList[i].dataset.categoryId);
                }

                let idsValue = ids.join(',');

                document.getElementById('category_ids').value= idsValue;
            </script>



        <button type="button" id="admin-product__add-category-btn" class="admin-product__add-category-btn"><?= $addCategory ?></button>
        <div id="admin-product__add-category" class="admin-product__add-category--hidden">
            <aside class="admin-product__add-category-notice"><?= $clickToAddCategory ?></aside>
            <?= $categories ?>
        </div>

    </section>
    <small class="admin-product__field-error"><?= @ $errors['category_ids'] ?></small>
</div>
