<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8
{
    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Gregwar\\Captcha\\' => 16,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Gregwar\\Captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/gregwar/captcha',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Controllers\\Admin' => __DIR__ . '/../..' . '/app/protected/controllers/admin.php',
        'App\\Controllers\\Admincomments' => __DIR__ . '/../..' . '/app/protected/controllers/admincomments.php',
        'App\\Controllers\\Catalog' => __DIR__ . '/../..' . '/app/protected/controllers/catalog.php',
        'App\\Controllers\\Comments' => __DIR__ . '/../..' . '/app/protected/controllers/comments.php',
        'App\\Controllers\\Error_404' => __DIR__ . '/../..' . '/app/protected/controllers/404.php',
        'App\\Controllers\\Image' => __DIR__ . '/../..' . '/app/protected/controllers/image.php',
        'App\\Controllers\\Index' => __DIR__ . '/../..' . '/app/protected/controllers/index.php',
        'App\\Core\\AdminController' => __DIR__ . '/../..' . '/app/core/admincontroller.php',
        'App\\Core\\Application' => __DIR__ . '/../..' . '/app/core/application.php',
        'App\\Core\\BaseController' => __DIR__ . '/../..' . '/app/core/basecontroller.php',
        'App\\Core\\DataBase' => __DIR__ . '/../..' . '/app/core/database.php',
        'App\\Core\\Upper\\MainDispatcher' => __DIR__ . '/../..' . '/app/core/upper/maindispatcher.php',
        'App\\Models\\AdminModel' => __DIR__ . '/../..' . '/app/protected/models/admin.php',
        'App\\Models\\Avatar' => __DIR__ . '/../..' . '/app/protected/models/avatar.php',
        'App\\Models\\Categories' => __DIR__ . '/../..' . '/app/protected/models/categories.php',
        'App\\Models\\CheckForm' => __DIR__ . '/../..' . '/app/protected/models/check_form.php',
        'App\\Models\\DB_Catalog' => __DIR__ . '/../..' . '/app/protected/models/db_catalog.php',
        'App\\Models\\DB_Index' => __DIR__ . '/../..' . '/app/protected/models/db_index.php',
        'Gregwar\\Captcha\\CaptchaBuilder' => __DIR__ . '/..' . '/gregwar/captcha/CaptchaBuilder.php',
        'Gregwar\\Captcha\\CaptchaBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/CaptchaBuilderInterface.php',
        'Gregwar\\Captcha\\ImageFileHandler' => __DIR__ . '/..' . '/gregwar/captcha/ImageFileHandler.php',
        'Gregwar\\Captcha\\PhraseBuilder' => __DIR__ . '/..' . '/gregwar/captcha/PhraseBuilder.php',
        'Gregwar\\Captcha\\PhraseBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/PhraseBuilderInterface.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit14fc953014b49481d3c9d0477a55e3f8::$classMap;

        }, null, ClassLoader::class);
    }
}
