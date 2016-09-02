<h2 class="content-zone__write-us-header"><?= $writeUs ?></h2>




<form class="content-zone__form" method="POST" action="/contacts/addMessage" id="content-zone__form">
    <p class="content-zone__form-element">
        <label for="name" class="content-zone__form-element-titel"><?= $enterYourName ?> *</label>
        <input type="text" name="name"  class="content-zone__form-element-field" value="<?= @ $_POST['name'] ?>" required>
        <small id="nameError" class="content-zone__form-error"><?= @ $error['name'] ?></small>
    </p>

    <p class="content-zone__form-element">
        <label for="writeUsPhone" class="content-zone__form-element-titel"><?= $enterYourPhone ?> *</label>
        <br>
        <small><?= $phoneFormatExample ?></small>
        <input type="tel" name="phone"  class="content-zone__form-element-field"  pattern="\d{3}-\d{3}-\d{2}-\d{2}" value="<?= @ $_POST['phone'] ?>" required>
        <small id="writeUsPhoneError" class="content-zone__form-error"><?= @ $error['phone'] ?></small>
    </p>

    <p class="content-zone__form-element">
        <label for="email" class="content-zone__form-element-titel"><?= $enterYourEmail ?> *</label>
        <input type="email" name="email"  class="content-zone__form-element-field" value="<?= @ $_POST['email'] ?>">
        <small id="emailError" class="content-zone__form-error"><?=  @ $error['email'] ?></small>
    </p>


    <label class="content-zone__form-element-titel"><?= $enterYourMessage ?> *</label>
    <p><small><?= $tagsMessageRemark ?></small></p>
    <textarea name="message" id="message" class="content-zone__form-element-message" cols="45" rows="15" required><?= @ $_POST['message'] ?></textarea>
    <small id="messageError" class="content-zone__form-error"><?= @ $error['message'] ?></small>


    <div class="content-zone__form-element">
        <label for="captcha-img-container" class="content-zone__form-element-titel"><?= $changeCaptcha ?></label>
        <div id="captcha-img-container" class="content-zone__form-element-field">
            <?php include PATH_SITE.'/resources/customer/partials/captcha.php'; ?>
        </div>
        <label for="captcha" class="content-zone__form-element-titel"><?= $enterCaptcha ?> *</label>
        <input type="text" name="captcha" id="captcha" placeholder="<?= $enterCaptcha ?>"  class="content-zone__form-element-field <?php if(isset($error['captcha'])) echo "error"; ?>" required>
        <small class="content-zone__form-error"><?= @$error['captcha'] ?></small>
    </div>

    <p class="content-zone__form-element-submit-container">
        <button class="content-zone__form-element-submit" id="sendMessage"> <?= $send ?></button>
    </p>

    <p class="content-zone__form-element-titel"><?= $inputRemark ?></p>
</form>

