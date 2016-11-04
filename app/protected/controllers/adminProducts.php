<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Categories;
use App\Models\DB_Catalog;
use App\Models\DB_Product;
use App\Models\Admin_Product;
use Lib\CheckFieldsService;


class AdminProducts extends AdminController {

    use CheckFieldsService;

    public function index(/*$updatedProductId = null*/$action = null, $id =null )
    {
        $categories = (new Categories)->getDropDownMenu();
        $catalog = new DB_Catalog(true);
        $manufacturers = $catalog->getManufacturers();
        $products = $catalog->getCatalog();
        $pages = $catalog->countPages();


        return ['view'=> 'admin/products.php', 'categories' => $categories, 'manufacturers'=>$manufacturers,
            'products' =>$products, 'pages'=>$pages, /*'success' =>$updatedProductId*/ 'action'=> $action, 'id' => $id ];
    }

    public function refresh()
    {
        $catalog = new DB_Catalog(true);
        $products = $catalog->getCatalog();
        $pages = $catalog->countPages();
        return ['view'=> 'admin/partials/productsList.php', 'products' =>$products, 'pages'=>$pages, 'ajax'=>true ];
    }

    public function show()
    {
        $model = new DB_Product();

        $product = $model->getProduct();

        $manufacturers = (new DB_Catalog(true))->getManufacturers();

        $categories = (new Categories)->getAdminDropDownMenu($product);


        return ['view'=> 'admin/productView.php', 'product' => $product, 'categories'=> $categories, 'manufacturers'=>$manufacturers];

    }

    public function createProductsPopUpMenu()
    {
        return ['view' =>'admin/partials/createProductsPopUpMenu.php', 'ajax'=>true ];
    }

    public function createImagePopUpMenu()
    {
        return ['view' =>'admin/partials/createImagePopUpMenu.php', 'ajax'=>true ];
    }



    public function update()
    {
        $updatedProduct = new \stdClass();
        $model= new Admin_Product();
        $errors = $model->checkIfNotEmpty($updatedProduct);
        if(!empty($errors)){

            $model = new DB_Product();
            $product = $model->getProduct();

            $manufacturers = (new DB_Catalog(true))->getManufacturers();

            $categories = (new Categories)->getAdminDropDownMenu($product);

            $this->getUpdatedProductInfo($updatedProduct, $product);

            return ['view'=> 'admin/productView.php', 'product' => $updatedProduct, 'categories'=> $categories,
                'manufacturers'=>$manufacturers, 'errors' => $errors];

        }

        $_POST['description'] = self::stripTags($_POST['description']);
        $_POST['body'] = self::stripTags($_POST['body']);

        $model->updateProduct();
        $model->addProductsImages();
        $model->removeProductsImages();
       if(!empty($_POST['imagesSort'])) $model->sortImagesSequence();

        return $this->index('productUpdated', $_POST['id']);
    }

    private function getUpdatedProductInfo($updatedProduct, $product)
    {
        $updatedProduct->category_eng_title = $product->category_eng_title;
        $updatedProduct->category_title = $product->category_title;
        $updatedProduct->product_id = $product->product_id;
        $updatedProduct->manf_title = $product->manf_title;
        $updatedProduct->manf_eng_title = $product->manf_eng_title;
    }

    public function addImageToDeleteList()
    {
        $_SESSION['deleteImageList'][] = $_POST['image'];
        return true;
    }

    public function create()
    {
        $manufacturers = (new DB_Catalog(true))->getManufacturers();

        $categories = (new Categories)->getAddProductAdminDropDownMenu();

        return ['view'=> 'admin/createProduct.php', 'manufacturers'=>$manufacturers, 'categories' => $categories ];
    }

    public function store()
    {
        $product = new \stdClass();
        $model= new Admin_Product();
        $errors = $model->checkIfNotEmpty($product);
        if(!empty($errors)){

            $model->getCategoryAndManufacturerInfo($product);

            $manufacturers = (new DB_Catalog(true))->getManufacturers();

            $categories = (new Categories)->getAdminDropDownMenu($product);

            return ['view'=> 'admin/createProduct.php', 'product' => $product, 'categories'=> $categories,
                'manufacturers'=>$manufacturers, 'errors' => $errors];
        }

        $_POST['description'] = self::stripTags($_POST['description']);
        $_POST['body'] = self::stripTags($_POST['body']);


        $addedProductId = $model->addProduct();
        $model->addProductsImages($addedProductId);

        if(!empty($_POST['imagesSort'])) $model->sortImagesSequence();

        return $this->index('productAdded', $_POST['id']);
    }




}