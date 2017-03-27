<section class="create__block">


    <h2><?= $updateUserHeader ?></h2>

    <form  action="/<?= \Lib\HelperService::currentLang() ?>adminUsers/update" method="post" >

        <input type="hidden" type="hidden" name="action" value="updateUser" >
        <input type="hidden" id="_token" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">
        <input type="hidden" type="hidden" name="id" value="<?= $theUser->id ?>" >



        <br>
        <label for="user_name" class="admin__block-title"><?= $updateUserName ?></label>
        <p>
            <input type="text" name="user_name" id="user_name" value="<?= @$error['user_name']?  strip_tags(@$_POST['user_name']) : $theUser->login ?>" >
        </p>
        <p><small class="admin__block-field-error"><?= @$error['user_name'] ?></small></p>

        <br>

        <label for="user_password" class="admin__block-title"><?= $updateUserPassword ?></label>
        <p>
            <input type="password" name="user_password" id="user_password" value="<?= @$error['user_password']?  @$_POST['user_password'] : "" ?>" >
        </p>
        <p><small class="admin_block-field-error"><?= @$error['user_password'] ?></small></p>

        <br>

        <label for="user_password2" class="admin__block-title"><?= $repeatUserPassword ?></label>
        <p>
            <input type="password" name="user_password2" id="user_password2" value="<?= @$error['user_password2']? @$_POST['user_password2']: ""  ?>"  >
        </p>
        <p><small class="admin__block-field-error"><?= @$error['user_password2'] ?></small></p>

        <br>




        <label for="user_role" class="admin__block-title" ><?= $updateUserRole ?></label>
        <br>

        <?php $role = ($_POST['user_role'])?? $theUser->role_title ?>

        <select id="user_role" name="user_role">

            <option <?= $role == 'superadmin'? 'selected': '' ?> value="superadmin">superadmin</option>
            <option <?= $role == 'admin'? 'selected': '' ?> value="admin">admin</option>
            <option <?= $role == 'user'? 'selected': '' ?> value="user">user</option>

        </select>



        <br>
        <br>
        <button type="submit"><?= $updateUser ?></button>

    </form>




</section>