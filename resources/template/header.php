<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Comments ">
    <meta name="description" content="create comments">
    <title>Comments Page</title>


	<link href="/assets/css/default.css" rel="stylesheet">
      <!-- Bootstrap -->
      <!--<link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->


    </head>
    <body>
    <div class="container">

        <header class="main-header ">

            <h1 class="main-header__h1"><?= $welcome ?></h1>



            <nav class="main-header__nav ">

                <a href="/<?= \Lib\HelperService::currentLang() ?>#" class="main-header__logo "><?= $our_brand ?></a>

                <div class="main-header__touch-button">
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                </div>

                 <ul class="main-header__menu" >
                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>#"><?= $main_page ?></a></li>
                </ul>


                <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>admin"><?php if(isset($_SESSION['login'])){echo "Админзона";}else {echo "$enter_admin";};  ?></a>

                <?php $langs = \Lib\HelperService::prozessLangArray(); ?>
                <select name="language" class="main-header__language-select" onchange="window.location.href=this.options[this.selectedIndex].value" >
                    <option selected disabled>Language/Мова</option>
                    <?php foreach ($langs as $key => $value): ?>

                        <option VALUE="/<?= \Lib\HelperService::overrideLang($key) ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>



             </nav>


        </header><!--/site-header-->

       <section class="content">
