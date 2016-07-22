<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Comments ">
    <meta name="description" content="create comments">
    <title>Admin Comments Page</title>


	<link href="/assets/css/admin.css" rel="stylesheet">


    </head>
    <body>

        <?php  include PATH_SITE.'/resources/admin/partials/message_area.php'  ?>


    <div class="container">

        <section id="update-area" class="update-area--hidden"></section>

        <?php if(isset($_SESSION['admin'])) : ?>

        <header class="main-header ">

            <h1 class="main-header__h1"><?= $this_is_admin_part ?></h1>


            <nav class="main-header__nav ">



                <div class="main-header__touch-button">
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                    <span class="main-header__icon-bar"></span>
                </div>

                 <ul class="main-header__menu" >

                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>" class="main-header__menu-item-link"><?= $main_customer_page ?></a></li>

                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>admin" class="main-header__menu-item-link"><?= $main_page ?></a></li>

                     <li class="main-header__menu-item"><a href="/<?= \Lib\HelperService::currentLang() ?>admincomments" class="main-header__menu-item-link"><?= $comments ?></a></li>

                </ul>
                 <a class="main-header__admin" href="/<?= \Lib\HelperService::currentLang() ?>admin/out" ><?= $exit ?></a>

                <?php $langs = \Lib\HelperService::prozessLangArray(); ?>
                <select name="language" class="main-header__language-select" onchange="window.location.href=this.options[this.selectedIndex].value" >
                    <option selected disabled>Language/Мова</option>
                    <?php foreach ($langs as $key => $value): ?>

                        <option VALUE="/<?= \Lib\HelperService::overrideLang($key) ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
             </nav>


        </header><!--/site-header-->

        <?php endif; ?>

       <section class="content">

         <!--Here include translation block for ajax-->
           <?php include_once ('/admin/partials/translation_for_ajax.php');?>
