<section id="admin-product__form" class="admin-product__form">

    <h1 class="admin-product__form-title"><?= $addProduct ?></h1>

    <section class="product-images">

        <div class="product-images-list" id="product-images-list" >

        </div>


        <?php include_once(PATH_SITE.'/resources/admin/partials/addImage.php') ?>

    </section>



    <section class="form">




        <form action="/adminProducts/store" method="post">

            <input type="hidden" name="imagesSort" id="imagesSort" >
            <input type="hidden" name="id" id="id" value="">

            <div class="admin-product__field" >
                <label for="author" class="admin-product__field-label" ><?= $author ?></label><br>
                <input type="text" name="author" id="author" value="<?= @$product->author ?>">
                <small class="admin-product__field-error"><?= @ $errors['author'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="title" class="admin-product__field-label"><?= $productTitle ?></label><br>
                <input type="text" name="title" id="title" value="<?= @$product->title ?>">
                <small class="admin-product__field-error"><?= @ $errors['title'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="description" class="admin-product__field-label"><?= $description ?></label><br>
                <textarea id="description" cols="45" rows="15" name="description"><?= @$product->description ?></textarea>
                <small class="admin-product__field-error"><?= @ $errors['description'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="body" class="admin-product__field-label"><?= $body ?></label><br>
                <textarea id="body" cols="45" rows="15" name="body"><?= @$product->body ?></textarea>
                <small class="admin-product__field-error"><?= @ $errors['body'] ?></small>
            </div>

            <div class="admin-product__field">
                <label for="price" class="admin-product__field-label"><?= $price ?></label><br>
                <input type="text" id="price" name="price" value="">
                <small class="admin-product__field-error"><?= @ $errors['price'] ?><?= @$product->price ?></small>
            </div>

            <div class="admin-product__field">
                <label for="category_id" class="admin-product__field-label"><?= $category ?></label><br>
                <?= $categories ?>
            </div>

            <div class="admin-product__field">
                <label for="manufacturer_id" class="admin-product__field-label"><?= $manufacturerTitle ?></label><br>
                <select name="manufacturer_id"  id="manufacturer_id">


                    <?php foreach ($manufacturers as $manufacturer): ?>
                       <?php if (isset($product->manf_id)): ?>
                            <option selected value="<?= $product->manf_id ?>"><?= $product->manf_title ?></option>
                       <?php endif; ?>
                        <option value ="<?= $manufacturer->id ?>"><?= $manufacturer->title ?></option>

                    <?php endforeach; ?>

                </select>
            </div>

            <div class="admin-product__field">

                <button type="submit"><?= $save ?></button>
            </div>


        </form>
    </section>
</section>

<script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js"></script>
<script src="/assets/js/sortable.js"></script>