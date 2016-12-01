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
        'App\\Controllers\\Aboutus' => __DIR__ . '/../..' . '/app/protected/controllers/aboutUs.php',
        'App\\Controllers\\Admin' => __DIR__ . '/../..' . '/app/protected/controllers/admin.php',
        'App\\Controllers\\AdminCategories' => __DIR__ . '/../..' . '/app/protected/controllers/adminCategories.php',
        'App\\Controllers\\AdminComments' => __DIR__ . '/../..' . '/app/protected/controllers/adminComments.php',
        'App\\Controllers\\AdminProducts' => __DIR__ . '/../..' . '/app/protected/controllers/adminProducts.php',
        'App\\Controllers\\Busket' => __DIR__ . '/../..' . '/app/protected/controllers/busket.php',
        'App\\Controllers\\Catalog' => __DIR__ . '/../..' . '/app/protected/controllers/catalog.php',
        'App\\Controllers\\Comments' => __DIR__ . '/../..' . '/app/protected/controllers/comments.php',
        'App\\Controllers\\Contacts' => __DIR__ . '/../..' . '/app/protected/controllers/contacts.php',
        'App\\Controllers\\Downloads' => __DIR__ . '/../..' . '/app/protected/controllers/downloads.php',
        'App\\Controllers\\Error_404' => __DIR__ . '/../..' . '/app/protected/controllers/404.php',
        'App\\Controllers\\Image' => __DIR__ . '/../..' . '/app/protected/controllers/image.php',
        'App\\Controllers\\Index' => __DIR__ . '/../..' . '/app/protected/controllers/index.php',
        'App\\Controllers\\Order' => __DIR__ . '/../..' . '/app/protected/controllers/order.php',
        'App\\Controllers\\Product' => __DIR__ . '/../..' . '/app/protected/controllers/product.php',
        'App\\Controllers\\ProductImage' => __DIR__ . '/../..' . '/app/protected/controllers/productImage.php',
        'App\\Controllers\\Search' => __DIR__ . '/../..' . '/app/protected/controllers/search.php',
        'App\\Core\\AdminController' => __DIR__ . '/../..' . '/app/core/admincontroller.php',
        'App\\Core\\Application' => __DIR__ . '/../..' . '/app/core/application.php',
        'App\\Core\\BaseController' => __DIR__ . '/../..' . '/app/core/basecontroller.php',
        'App\\Core\\DataBase' => __DIR__ . '/../..' . '/app/core/database.php',
        'App\\Core\\Upper\\MainDispatcher' => __DIR__ . '/../..' . '/app/core/upper/maindispatcher.php',
        'App\\Models\\AdminModel' => __DIR__ . '/../..' . '/app/protected/models/admin.php',
        'App\\Models\\Admin_Category' => __DIR__ . '/../..' . '/app/protected/models/admin_category.php',
        'App\\Models\\Admin_Comment' => __DIR__ . '/../..' . '/app/protected/models/admin_comment.php',
        'App\\Models\\Admin_Product' => __DIR__ . '/../..' . '/app/protected/models/admin_product.php',
        'App\\Models\\Avatar' => __DIR__ . '/../..' . '/app/protected/models/avatar.php',
        'App\\Models\\Categories' => __DIR__ . '/../..' . '/app/protected/models/categories.php',
        'App\\Models\\CheckForm' => __DIR__ . '/../..' . '/app/protected/models/check_form.php',
        'App\\Models\\DB_Busket' => __DIR__ . '/../..' . '/app/protected/models/db_busket.php',
        'App\\Models\\DB_Catalog' => __DIR__ . '/../..' . '/app/protected/models/db_catalog.php',
        'App\\Models\\DB_Index' => __DIR__ . '/../..' . '/app/protected/models/db_index.php',
        'App\\Models\\DB_Product' => __DIR__ . '/../..' . '/app/protected/models/db_product.php',
        'App\\Models\\DB_Search' => __DIR__ . '/../..' . '/app/protected/models/db_search.php',
        'App\\Models\\Images' => __DIR__ . '/../..' . '/app/protected/models/images.php',
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
