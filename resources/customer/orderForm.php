<section class="final-order-form">

    <form action="/<?= \Lib\HelperService::currentLang() ?>busket/makeOrder" method="post">

        <input type="hidden" name="_token" value="<?= \Lib\TokenService::printTocken('prozessBusket') ?>">

        <div class="final-order-form__input-field">
            <p><?= $enterYourName ?><span class="warning">*</span></p>
            <input type="text" name="name" placeholder="<?= $enterYourName ?>" required>
        </div>

        <div class="final-order-form__input-field">
            <p><?= $phoneFormatExample ?><span class="warning">*</span></p>
            <input type="tel" name="phone" placeholder="<?= $enterYourPhone ?>" pattern="\d{3}-\d{3}-\d{2}-\d{2}"  required>
        </div>

        <div class="final-order-form__input-field">
            <p><?= $enterYourEmail ?></p>
            <input type="text" name="email" placeholder="<?= $enterYourEmail ?>"  >
        </div>

        <div class="final-order-form__input-field">
            <p><?= $enterYourMessage ?></p>
            <textarea name="message" cols="48" rows="15" placeholder="<?= $enterYourMessage ?>" ></textarea>
        </div>

        <div class="final-order-form__input-field">
            <button type="submit" class="final-order-form__submit-btn"  id = "final-order-form__submit-btn" ><?= $makeOrder ?></button>
        </div>
        <p class="warning"><?= $inputRemark ?></p>



    </form>

</section>
