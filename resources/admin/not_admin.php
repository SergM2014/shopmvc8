<?php

if(!isset($_SESSION['admin'])):
    ?>

    <style type="text/css">
        .login_form {width:400px;   margin:0 auto; padding:10px; border:1px solid #000000 }
    </style>

    <a href="/"><?= $back_to_site ?></a>
    <div class="login_form">
        <h3><?= $admin_entry_title ?></h3>
        <!--<div id="login">-->


                <form  method="POST" action="/<?= \Lib\HelperService::currentLang() ?>admin">
                    <input type="hidden" name="_token" value="<?php \Lib\TokenService::printTocken('enter_admin') ?>">
                    <p><label for="login"><?= $login_title ?></label><br>
                        <input   name="login" id="login" type="text"  maxlength="25"> </p>
                    <p><label for="password"><?= $password_title ?></label><br>
                        <input   name="password" id="password" type="password" maxlength="20" > </p>
                    <!--<p><input type="checkbox" id="remember_me" name="remember_me" >
                        <label for="remember_me">Remember me</label></p>-->
                    <br>
                    <p><input  type="submit" value="<?= $go_to_admin_title ?>"></p>

                </form>


        </div><!--login
    </div><!--login_form


    </div><!--frame-->
<?php endif; ?>

