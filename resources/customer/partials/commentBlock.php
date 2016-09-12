<div class="content__comment-block">
    <h2><?= $addYourComment ?></h2>


    <?php  include PATH_SITE.'/resources/customer/partials/upload.php'  ?>



    <form method="post" id="send_comment" >
        <p>Поля обозначеные <span class="red">*</span> есть обязательными</p>
        <br>


        <label for="name"><?= $name ?><span class="red">*</span></label>  <small class="red"><?php if(isset($error['name'])) echo $error['name']; ?></small>
        <p> <input type="text" name="name" id="name" placeholder="<?= $enterYourName ?>" class="input <?php if(isset($error['name'])) echo 'error'; ?>"
                   value="<?php if(isset($post['name'])) echo $post['name']; ?>" maxlength="15" required ></p>

        <label for="email"><?= $email ?><span class="red">*</span></label>   <small class="red"><?php if(isset($error['email'])) echo $error['email']; ?></small>
        <p><input type="email" name="email" id="email" placeholder="<?= $writeYourEmail ?>" class="input <?php if(isset($error['email'])) echo 'error'; ?>"
                  value="<?php if(isset($post['email'])) echo $post['email']; ?>" maxlength="15" required ></p>

        <label for="message"><?= $message ?><span class="red">*</span></label>   <small class="red"><?php if(isset($error['message'])) echo $error['message']; ?></small>
        <p><textarea name="message" id="message" placeholder="<?= $writeYourMessage ?>" cols="40" rows="8"
                     class="input" required ><?php if(isset($post['message'])) echo $post['message']; ?></textarea></p>
        <p class="<?php if(isset($error['message'])) echo 'error'; ?>"></p>
        <br>

        <small><?= $changeCaptcha ?></small>
        <p><img src="<?php echo URL ?>lib/kcaptcha/index.php?<?php echo session_name()?>=<?php echo session_id()?>" id="kcaptcha"></p>
        <label for="keystring">Введите капчу<span class="red">*</span></label>   <small class="red"><?php if(isset($error['keystring'])) echo $error['keystring']; ?></small>

        <p><input type="text" name="keystring" id="keystring" class="input <?php if(isset($error['keystring'])) echo 'error'; ?>" maxlength="10" required ></p>

        <p><input type="hidden" name="_token"  value=""></p>
        <br>
        <p><input type="submit" id="submitComment" value="Отправить"></p>
    </form>


</div>