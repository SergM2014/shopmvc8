<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Categories;
use App\Models\DB_Catalog;
use App\Models\DB_Product;
use App\Models\Admin_Product;
use App\Models\Admin_Category;
use Lib\CheckFieldsService;
use Lib\TokenService;


class AdminProducts extends AdminController {

    use CheckFieldsService;

    public function index($fullfilledAction = null, $id =null )
    {
        $categories = (new Categories)->getDropDownMenu();
        $catalog = new DB_Catalog(true);
        $manufacturers = $catalog->getManufacturers();
        $products = $catalog->getCatalog();
        $pages = $catalog->countPages();


        return ['view'=> 'admin/products.php', 'categories' => $categories, 'manufacturers'=>$manufacturers,
            'products' =>$products, 'pages'=>$pages, 'action'=> $fullfilledAction, 'id' => $id ];
    }

    public function refresh()
    {
        $catalog = new DB_Catalog(true);
        $products = $catalog->getCatalog();
        $pages = $catalog->countPages();

        return ['view'=> 'admin/partials/productsList.php', 'products' =>$products, 'pages'=>$pages, 'ajax'=>true ];
    }



    public function edit()
    {
        $product = (new DB_Product())->getProduct();

        $productExistingCategories =  DB_Product::getCategoriesArray($product);

        $manufacturers = (new DB_Catalog(true))->getManufacturers();

        $categories = (new Admin_Category())->getCategoriesMenu();


        return ['view'=> 'admin/productView.php', 'product' => $product, 'productExistingCategories' => $productExistingCategories, 'categories'=> $categories, 'manufacturers'=>$manufacturers];

    }


    public function createProductsPopUpMenu()
    {
        return ['view' =>'admin/partials/createPopUpMenu.php', 'significant' =>'product', 'ajax'=>true ];
    }

    public function createImagePopUpMenu()
    {
        return ['view' =>'admin/partials/createImagePopUpMenu.php', 'ajax'=>true ];
    }


    protected function showUpdateErrors($updatedProduct, $errors)
    {
        $product = (new DB_Product())->getProduct();

        $manufacturers = (new DB_Catalog(true))->getManufacturers();

        $categories = (new Admin_Category())->getCategoriesMenu();

        $productExistingCategories= (new Admin_Category())->getPointedCategories();



        (new Admin_Product())->getUpdatedProductInfo($updatedProduct, $product);

        return ['view'=> 'admin/productView.php', 'product' => $updatedProduct, 'categories'=> $categories, 'productExistingCategories'=>$productExistingCategories,
            'manufacturers'=>$manufacturers, 'errors' => $errors];
    }

    protected function showAddErrors($product, $errors)
    {
        (new Admin_Product())->getManufacturerInfo($product);

        $manufacturers = (new DB_Catalog(true))->getManufacturers();

        $productExistingCategories= (new Admin_Category())->getPointedCategories();

        $categories = (new Admin_Category())->getCategoriesMenu();

        return ['view'=> 'admin/createProduct.php', 'product' => $product, 'categories'=> $categories, 'productExistingCategories'=>$productExistingCategories,
            'manufacturers'=> $manufacturers, 'errors' => $errors];
    }

    public function update()
    {
        TokenService::check('prozessAdmin');
        $updatedProduct = new \stdClass();
        $model= new Admin_Product();
        $errors = $model->checkIfNotEmpty($updatedProduct);

        if(!empty($errors)){

            return $this->showUpdateErrors($updatedProduct, $errors);
        }

        $model->updateProduct();

        return $this->index('productUpdated', $_POST['id']);
    }

// delete image in admin products
    public function addImageToDeleteList()
    {
        TokenService::check('prozessAdmin');
        $_SESSION['deleteImageList'][] = $_POST['image'];
        echo json_encode(["message"=> "added to delete list"]); exit();
    }

    public function create()
    {
        $manufacturers = (new DB_Catalog(true))->getManufacturers();

        $categories = (new Admin_Category())->getCategoriesMenu();

        return ['view'=> 'admin/createProduct.php', 'manufacturers'=>$manufacturers, 'categories' => $categories ];
    }


    public function store()
    {
        TokenService::check('prozessAdmin');

        $product = new \stdClass();
        $model= new Admin_Product();
        $errors = $model->checkIfNotEmpty($product);

        if(!empty($errors)){ return $this->showAddErrors($product, $errors); }

        $addedProductId = $model->addProduct();

        return $this->index('productAdded', $addedProductId);
    }

    public function delete(){
        TokenService::check('prozessAdmin');
        (new Admin_Product())->deleteProduct();
        return $this->index('productDeleted', $_POST['id']);
    }

    public function createConfirmDeleteWindow()
    {
        return ['view' =>'admin/partials/createConfirmDeleteWindow.php', 'significant' =>'product', 'ajax'=>true ];
    }

    public function addCategory()
    {
        return ['view' => 'admin/partials/existingCategory.php', 'ajax' => true ];
    }




}