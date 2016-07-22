<?php

//    define('PATH_SITE',  $_SERVER['DOCUMENT_ROOT']);

    //if document root is public  then find and delete string 'public in root
    $arr = explode('/', $_SERVER['DOCUMENT_ROOT']);
    array_pop($arr);
    $document_root = implode('/', $arr);
    define('PATH_SITE', $document_root);

    define('NAMESITE','shopmvc8');
    define('URL','http://shopmvc8/');
    define('AMOUNTONPAGE',3);
    define('AMOUNTONPAGEADMIN',6);
    define('HOST', 'localhost'); //сервер
    define('USER', 'root'); //пользователь
    define('PASSWORD', '1'); //пароль
    //define('NAME_BD', 'database/database.sqlite');
    define('NAME_BD', 'shopmvc8');
    define('DEBUG_MODE', true ); //режим отладки

	define('UPLOAD_FILE','/public/uploads/');
	define('LINKCOUNT',5);
	define('ADMINEMAIL', 'weisse@ukr.net');
    define('DEFAULT_LANG', 'uk');

    const LANG = ['uk=>Українська', 'en=>English'];
	
	date_default_timezone_set('Europe/Kiev');




    $directory = new DirectoryIterator(PATH_SITE.'/app/lib/');
    foreach ($directory as $file) {
        if($file->getExtension() == 'php') include_once PATH_SITE.'/app/lib/'.$file;
    }



require PATH_SITE.'/vendor/autoload.php';

/**
 * if case of development all errors must be outputed ot screen
 */
	if (DEBUG_MODE){
					ini_set("display_errors","1");
					ini_set("display_startup_errors","1");
					ini_set('error_reporting', E_ALL);
	}








?>
