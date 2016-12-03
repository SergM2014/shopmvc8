<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Admin_Category;
use \Lib\TokenService;
use App\Models\CheckForm;


class AdminCategories extends AdminController {


    public function index($fullfilledAction = null, $id =null, $error = null )
    {
        $categories = (new Admin_Category())->getCategoriesMenu();

        return ['view'=>'admin/categories.php', 'categories'=>$categories, 'action'=> $fullfilledAction, 'id' => $id , 'error'=> $error ];
    }

    public function createCategoriesPopUpMenu()
    {
        return ['view'=>'admin/partials/createCategoriesPopUpMenu.php', 'ajax'=> true ];
    }

    public function edit($error = null )
    {
        $category = (new Admin_Category())->getOneCategory();
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

    public function create($error = null )
    {
        $_SESSION['createCategory'] =true;
        $categories = (new Admin_Category())->getAdminDropDownMenu();
        return  ['view' =>'admin/createCategory.php',  'categories'=> $categories, 'error' => $error  ];
    }

    public function store()
    {
        TokenService::check('prozessAdmin');
        $model = new CheckForm;
        $error = $model->ifCategoryTitleEmpty();

        if ( $error) return   $this->create($error);


        if(@$_SESSION['createCategory']) {

            $id = (new Admin_Category())->storeCategory();
            return $this->index('categoryCreated', $id);
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