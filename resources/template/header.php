<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="E shop ">
    <meta name="description" content="training shop">
    <title>Internet shop</title>


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
                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>"><?= $main_page ?></a></li>
                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>catalog"><?= $catalog ?></a></li>
                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>aboutus"><?= $about_us ?></a></li>
                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>downloads"><?= $download ?></a></li>
                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>contacts"><?= $contacts ?></a></li>
                </ul>


                <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>admin"><?php if(isset($_SESSION['login'])){echo "$admin_zone";}else {echo "$enter_admin";};  ?></a>

<?php //get the given languages array
$langs = \Lib\HelperService::prozessLangArray(); ?>

                <ul class="main-header__language-select"><?= \Lib\HelperService::getCurrentLanguageTitle() ?>
                    <div class="main-header__language-select-dropdown hidden">
                        <?php foreach($langs as $key => $value): ?>

                            <li><a href="/<?= \Lib\HelperService::overrideLangInUrl($key) ?>"><?= $value ?></a></li>
                        <?php endforeach; ?>
                    </div>
                </ul>

                <div class="main-header__search-container" ><?= $search ?> <input type="text" name="search" id="search" class="main-header__search-field"  maxlength="20" autofocus >
                    <aside class="main-header__search-result-box--hidden" id="search-results"></aside>
                </div>

             </nav>

<div class="clearfix">
    <div class="busket__container" id="busket-container">
        <img src="/img/busket.jpg" class="busket" alt="the busket">
        <div class="busket__info" id="busket-info">
            <?php \Lib\CookieService::getCookies(); ?>

            <p class="busket__info-item" ><?= $amount ?> : <?php echo (@ $_SESSION['total_amount'])?: '0';  echo ' '.$ukrCurrency;?> </p>
            <p class="busket__info-item" ><?= $sum ?> : <?php echo (@ $_SESSION['total_sum'])?: '0';  echo ' '.$ukrCurrency ?> </p>
        </div>
    </div>
</div><!-- clearfix -->
        </header><!--/site-header-->

       <section class="content">

