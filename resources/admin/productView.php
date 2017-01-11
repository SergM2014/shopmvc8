<section id="admin-product__form" class="admin-product__form">

    <h2 class="admin-product__form-title"><?= $editProduct ?></h2>

    <section class="product-images">

        <div class="product-images-list" id="product-images-list" >
            <?php if(@$product->images): ?>
                <?php  foreach( $product->images as $image): ?>
                    <img src="/uploads/productsImages/thumbs/<?= $image ?>" class="product-image-preview"
                         title="<?= $clickToSeePopUp ?>" alt="image" data-image="<?= $image ?>" >
                <?php endforeach; ?>
            <?php endif; ?>
        </div>


        <?php include_once(PATH_SITE.'/resources/admin/partials/addImage.php') ?>


    </section>


    <section class="form">


        <form action="/adminProducts/update" method="post">

            <input type="hidden" name="imagesSort" id="imagesSort" >
            <input type="hidden" name="id" id="id" value="<?= $product->product_id ?>">
            <input type="hidden" name="_token" id="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">

            <div class="admin-product__field" >
                <label for="author" class="admin-product__field-label" ><?= $author ?></label><br>
                <input type="text" name="author" id="author" value="<?= $product->author ?>">
                <small class="admin-product__field-error"><?= @ $errors['author'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="title" class="admin-product__field-label"><?= $productTitle ?></label><br>
                <input type="text" name="title" id="title" value="<?= $product->title ?>">
                <small class="admin-product__field-error"><?= @ $errors['title'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="description" class="admin-product__field-label"><?= $description ?></label><br>
                <textarea id="description" cols="45" rows="15" name="description"><?= $product->description ?></textarea>
                <small class="admin-product__field-error"><?= @ $errors['description'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="body" class="admin-product__field-label"><?= $body ?></label><br>
                <textarea id="body" cols="45" rows="15" name="body"><?= $product->body ?></textarea>
                <small class="admin-product__field-error"><?= @ $errors['body'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="price" class="admin-product__field-label"><?= $price ?></label><br>
                <input type="text" id="price" name="price" value="<?= $product->price ?>">
                <small class="admin-product__field-error"><?= @ $errors['price'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="category_list" class="admin-product__field-label"><?= $category ?></label><br>

                <section id="category_list">

                    <input type="hidden" name="category_id" id="category_id" value="">

                    <label for="admin-product__existing-categories" class="admin-product__field-label"><small><?= $existingCategories ?></small></label><br>
                    <ul id="admin-product__existing-categories" class="admin-product__existing-categories">

                        <?php foreach($productExistingCategories as $key =>$value) : ?>
                            <?php include(PATH_SITE.'/resources/admin/partials/existingCategory.php') ?>
                        <?php endforeach  ?>
                    </ul>

                    <script>
                        let ids= [];
                        let categoriesList = document.getElementById('admin-product__existing-categories').querySelectorAll('li');

                        for (let i=0; i<categoriesList.length; i++){
                         ids.push(categoriesList[i].dataset.categoryId);
                        }

                        let idsValue = ids.join(',');

                        document.getElementById('category_id').value= idsValue;
                    </script>


                    <button type="button" id="admin-product__add-category-btn" class="admin-product__add-category-btn"><?= $addCategory ?></button>
                    <div id="admin-product__add-category" class="admin-product__add-category--hidden">
                        <aside class="admin-product__add-category-notice"><?= $clickToAddCategory ?></aside>
                        <?= $categories ?>
                    </div>

                </section>
                <small class="admin-product__field-error"><?= @ $errors['category_id'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="manufacturer_id" class="admin-product__field-label"><?= $manufacturerTitle ?></label><br>
                <select name="manufacturer_id"  id="manufacturer_id">
                    <option selected value="<?= $product->manf_id ?>"><?= $product->manf_title ?></option>

                    <?php foreach ($manufacturers as $manufacturer): ?>

                        <option value ="<?= $manufacturer->id ?>"><?= $manufacturer->title ?></option>

                    <?php endforeach; ?>

                </select>
            </div>

            <div class="admin-product__field">

                <button type="submit"><?= $update ?></button>
            </div>


        </form>
    </section>
</section>


<script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js"></script>
<script src="/assets/js/sortable.js"></script>