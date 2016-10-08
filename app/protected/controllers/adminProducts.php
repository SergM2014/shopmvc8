<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Categories;
use App\Models\DB_Catalog;


class AdminProducts extends AdminController {

    public function index()
    {
        $categories = (new Categories)->getDropDownMenu();
        $catalog = new DB_Catalog(true);
        $manufacturers = $catalog->getManufacturers();
        $products = $catalog->getCatalog();
        $pages = $catalog->countPages();


        return ['view'=> 'admin/products.php', 'categories' => $categories, 'manufacturers'=>$manufacturers, 'products' =>$products, 'pages'=>$pages];
    }

    public function refresh()
    {
        $catalog = new DB_Catalog(true);
        $products = $catalog->getCatalog();
        $pages = $catalog->countPages();
        return ['view'=> 'admin/partials/productsList.php', 'products' =>$products, 'pages'=>$pages, 'ajax'=>true ];
    }

    public function update()
    {
        die('You are in update now');
    }

    public function createProductsPopUpMenu()
    {
        return ['view' =>'admin/partials/createProductsPopUpMenu.php', 'ajax'=>true ];
    }

}