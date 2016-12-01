<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Admin_Category;
use \Lib\TokenService;
use App\Models\CheckForm;


class AdminCategories extends AdminController {


    public function index($fullfilledAction = null, $id =null)
    {
        $categories = (new Admin_Category())->getCategoriesMenu();

        return ['view'=>'admin/categories.php', 'categories'=>$categories, 'action'=> $fullfilledAction, 'id' => $id  ];
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
//var_dump($error);
        if ( $error) return   $this->edit($error);


        if(@$_SESSION['editCategorytitle']) {

            (new Admin_Category())->updateCategory();
            return $this->index('categoryUpdated', $_POST['id']);
        }

        return $this->index();
    }
   


}