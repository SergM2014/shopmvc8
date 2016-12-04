<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Admin_Manufacturer;
use \Lib\TokenService;
use App\Models\CheckForm;
use \Lib\CheckFieldsService;


class AdminManufacturers extends AdminController {

    use CheckFieldsService;

    public function index($fullfilledAction = null, $id =null, $error = null )
    {
        $manufacturers = (new Admin_Manufacturer())->getManufacturers();

        return ['view'=>'admin/manufacturers.php', 'manufacturers'=>$manufacturers, 'action'=> $fullfilledAction, 'id' => $id , 'error'=> $error ];
    }

    public function createManufacturersPopUpMenu()
    {
        return ['view'=>'admin/partials/createManufacturersPopUpMenu.php', 'ajax'=> true ];
    }


    public function create($error = null )
    {
        $_SESSION['createManufacturer'] =true;

        $title = $this->stripTags(@$_POST['manufacturer_title']);
        $url = $this->stripTags(@$_POST['manufacturer_url']);

        return  ['view' =>'admin/createManufacturer.php', 'error' => $error , 'title' => $title, 'url' => $url ];
    }


    public function store()
    {
        TokenService::check('prozessAdmin');
        $model = new CheckForm;
        $error['title'] = $model->ifManufacturerTitleEmpty() ;
        $error['url'] = $model->ifManufacturerUrlEmpty() ;

        if ( $error['title'] !== false AND $error['url'] !== false) return   $this->create($error);


        if(@$_SESSION['createManufacturer']) {

            $id = (new Admin_Manufacturer())->storeManufacturer();
            return $this->index('manufacturerCreated', $id);
        }

        return $this->index();
    }


    public function edit($error = null )
    {
        $category = (new Admin_Manufacturer())->getOneManufacturer();
        $_SESSION['editCategorytitle'] = true;
        $categories = (new Admin_Category())->getAdminDropDownMenu($category);
        return  ['view' =>'admin/updateCategory.php', 'category'=> $category, 'categories'=> $categories, 'error' => $error  ];
    }

    public function update()
    {
        TokenService::check('prozessAdmin');
        $model = new CheckForm;
        $error = $model->ifCategoryTitleEmpty();

        if ( $error) return   $this->edit($error);


        if(@$_SESSION['editCategorytitle']) {

            (new Admin_Category())->updateCategory();
            return $this->index('categoryUpdated', $_POST['id']);
        }

        return $this->index();
    }





    public function creteConfirmDeleteWindow()
    {
        $_SESSION['deleteCategory'] = true;

        return ['view' =>'admin/partials/createConfirmDeleteCategoryWindow.php', 'ajax'=>true ];
    }

    public function delete()
    {
        TokenService::check('prozessAdmin');
        if(!isset($_SESSION['deleteCategory'])) return $this->index();

        $model = new Admin_Category();

        $error = $model ->findChildCategories();

        if($error)  return $this->index('categoryHasChildren', null, 'error');

        $error = $model->findProductsInCategory();
        if($error)  return $this->index('categoryHasProducts', null, 'error');

        $model->deleteCategory();
        return $this->index('categoryDeleted', $_POST['id']);

    }
   


}