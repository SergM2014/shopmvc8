<section class="create__block">


    <h2><?= $createUserHeader ?></h2>

    <form enctype="multipart/form-data" action="/adminUsers/store" method="post" >

        <input type="hidden" type="hidden" name="action" value="createUser" >
        <input type="hidden" id="_token" name="_token" value="<?= \Lib\TokenService::printTocken('prozessAdmin') ?>">



        <br>
        <label for="user_name" class="create__block-title"><?= $createUserName ?></label>
        <p>
            <input type="text" name="user_name" id="user_name" value="<?= @$error['user_name']? "" : strip_tags(@$_POST['user_name'])  ?>"  required >
        </p>
        <p><small class="create__block-field-error"><?= @$error['user_name'] ?></small></p>

        <br>

        <label for="user_password" class="create__block-title"><?= $createUserPassword ?></label>
        <p>
            <input type="password" name="user_password" id="user_password" value="<?= @$error['user_password']? "" : strip_tags(@$_POST['user_password'])  ?>" required pattern="\w{6,}" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['user_password'] ?></small></p>

        <br>

        <label for="user_password2" class="create__block-title"><?= $repeatUserPassword ?></label>
        <p>
            <input type="password" name="user_password2" id="user_password2" value="<?= @$error['user_password2']? "" : strip_tags(@$_POST['user_password2'])  ?>" required required pattern="\w{6,}" >
        </p>
        <p><small class="create__block-field-error"><?= @$error['user_password2'] ?></small></p>

        <br>




        <label for="user_role" class="create__block-title" ><?= $createUserRole ?></label>
        <br>

        <select id="user_role" name="user_role">

            <option value="superadmin">superadmin</option>
            <option value="admin">admin</option>
            <option selected value="user">user</option>

        </select>

        <p><small class="create__block-field-error"><?= @$error['user_role'] ?></small></p>

        <br>
        <button type="submit"><?= $createUser ?></button>

    </form>




</section>