<section id="admin-product__update-form" class="admin-product__update-form">

    <section class="update-form__images">
        <div class="update-form__images-list" id="update-form__images-list" >

            <?php foreach($product->images as $image): ?>
                <img src="/uploads/productsImages/thumbs/<?= $image ?>" class="product-image-preview"
                     title="<?= $clickToSeePopUp ?>" title="<?= $clickToSeePopUp ?>" data-image="<?= $image ?>" >
            <?php endforeach; ?>

        </div>


        <button type="button" class="update-form__add-image-btn" id="update-form__add-image-btn" ><?= $addImage ?></button>

        <form id="update-form__image-area" class="update-form__image-area--hidden" id="update-form__image-area" enctype="multipart/form-data" method="post"  hidden="true" >

            <div class="update-form__image-area-left">

                <img src="<?php echo isset($_SESSION['image'])? '/uploads/productsImages/'.$_SESSION['image']: '/img/nophoto.jpg'; ?>" class="update-form__image-thumb" id="image_preview">


               <div class="update-form__progress-container" id="progress-container" hidden >
                   <progress id="progress" max="100" value="0">

                   </progress>
               </div>

            </div>
            <div class="update-form__image-area-right">
                <input type="file" id="file"  <?= !isset($_SESSION['image'])? '': 'hidden' ?> >
                <span class="update-form__image-area-output" id="output"></span>
                <button type="button" class="update-form__image-area-btn" id="image-submit-btn" <?= !isset($_SESSION['image'])? '': 'hidden' ?> hidden ><?= $load ?></button>
                <button type="button" class="update-form__image-area-btn" id="image-reset-btn"  <?= isset($_SESSION['image'])? '': 'hidden' ?> ><?= $delete ?></button>

            </div>

        </form>
<script src="/assets/js/adminUploadImage.js"></script>
    </section>

    <h2>This is product</h2>

    <form action="/adminProducts/update" method="post">

        <input type="hidden" name="id" id="id" value="<?= $product->product_id ?>">

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
            <label for="category_id" class="admin-product__field-label"><?= $category ?></label><br>
            <?= $categories ?>
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

