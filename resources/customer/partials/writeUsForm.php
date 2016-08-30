<h2 class="content-zone__write-us-header"><?= $writeUs ?></h2>


<script src="/lib/ckeditor/ckeditor.js"></script>

<form class="content-zone__form" method="POST" action="/contacts/addMessage" id="content-zone__form">
    <p class="content-zone__form-element">
        <label for="writeUsName" class="content-zone__form-element-titel"><?= $enterYourName ?></label>
        <input type="text" name="writeUsName" id="writeUsName" class="content-zone__form-element-field" required>
        <small id="writeUsNameError" class="content-zone__form-error--hidden"><?= $writeUsNameError ?></small>
    </p>

    <p class="content-zone__form-element">
        <label for="writeUsPhone" class="content-zone__form-element-titel"><?= $enterYourPhone ?></label>
        <br>
        <small><?= $phoneFormatExample ?></small>
        <input type="tel" name="writeUsPhone" id="writeUsPhone" class="content-zone__form-element-field" required>
        <small id="writeUsPhoneError" class="content-zone__form-error--hidden"><?= $writeUsPhoneError ?></small>
    </p>

    <p class="content-zone__form-element">
        <label for="writeUsEmail" class="content-zone__form-element-titel"><?= $enterYourEmail ?></label>
        <input type="email" name="writeUsEmail" id="writeUsEmail" class="content-zone__form-element-field" required>
        <small id="writeUsEmailError" class="content-zone__form-error--hidden"><?= $writeUsEmailError ?></small>
    </p>


    <label class="content-zone__form-element-titel"><?= $enterYourMessage ?></label>
    <p><small><?= $tagsMessageRemark ?></small></p>
    <textarea name="writeUsMessage" id="writeUsMessage" class="content-zone__form-element-message" required></textarea>
    <small id="writeUsMessageError" class="content-zone__form-error--hidden"><?= $writeUsMessageError ?></small>


    <p class="content-zone__form-element-submit-container">
        <button class="content-zone__form-element-submit" id="sendMessage"> <?= $send ?></button>
    </p>
</form>

<script>
    //if (CKEDITOR.instances['writeUsMessage']) { CKEDITOR.remove(CKEDITOR.instances['writeUsMessage']);}

    let writeUsMessage = document.getElementsByClassName('content-zone__write-us')[0].querySelector('#writeUsMessage');
    CKEDITOR.inline( writeUsMessage );
    CKEDITOR.replace(writeUsMessage)


</script>