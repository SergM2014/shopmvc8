<?php


namespace App\Models;


use App\Core\DataBase;
use Lib\LangService;
use Lib\CheckFieldsService;
use function makeMainCategory;

class Admin_Category extends DataBase
{
    use CheckFieldsService;

   public function getCategories()
   {
       $sql = "SELECT `id`, `title`, `parent_id`, `eng_translit_title` FROM `categories`";
       $stmt = $this->conn->query($sql);
       $res = $stmt->fetchAll();
       return $res;

   }

    public function getCategoriesMenu()
    {
        $categories = $this->getCategories();

        $leftMenu ="<ul class='categories-menu'>";
        $leftMenu.= $this->printOutCategoriesMenu($categories);
        $leftMenu.= "</ul>";
        return $leftMenu;
    }


    protected function printOutCategoriesMenu( $categories, $parent = 0)
    {
        if(!isset($print)){$print='';}
        foreach($categories as $category){
            if($category->parent_id ==$parent ){

                $print.='<li  class="categories-menu__item-container"><span class="categories-menu__item" data-id="'.$category->id .'">'.$category->title.'</span>' ;
                foreach($categories as $sub_cat){
                    if($sub_cat->parent_id == $category->id){
                        $flag = TRUE; break;
                    }
                }

                if(isset($flag)){
                    $print.= "<ul>";
                    $print.= $this->printOutCategoriesMenu($categories, $category->id);
                    $print.= "</ul>";
                    $print.= "</li>";
                } else{
                    $print.="</li>";
                }
            }
        }
        return $print;
    }

    public function getOneCategory()
    {
        $id = @$_GET['id']?: @$_POST['id'];

        $sql = "SELECT `id`, `parent_id`, `title`, `eng_translit_title` FROM `categories` WHERE `id`=? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();


        $sql = "SELECT `title` AS `parent_title` FROM `categories` WHERE  `id`= $res->parent_id";
        $stmt = $this->conn->query($sql);
        $res2 = $stmt->fetchColumn();

        if($res2) $res->parent_title = $res2;

        return $res;

    }

    protected function printOutAdminDropDownMenu($categories, $parent=0)
    {
        static $suffix = 1;
        if(!isset($print)){$print='';}

        foreach($categories as $category){
            if($category->parent_id ==$parent ){

                $print.="<option class='drop-down-menu-item  nested-$suffix' value='$category->id' >$category->title</option>" ;
                foreach($categories as $sub_cat){
                    if($sub_cat->parent_id == $category->id){
                        $flag = TRUE; break;
                    }
                }

                if(isset($flag)){
                    $suffix++;
                    $print.= $this->printOutAdminDropDownMenu($categories, $category->id);
                    $print.= "</option>";
                    $suffix--;
                } else{
                    $print.="</option>";
                }
            }
        }
        return $print;
    }


    public function getAdminDropDownMenu($category= null )
    {
        $categories = $this->getCategories();
        $parentId= @$category->parent_id ?: 0;

        $disclaimer = @$category->parent_title ? : makeMainCategory();

        $dropDownMenu ="<select id='category_id' name='category_id'>";
        $dropDownMenu.="<option class='drop-down-menu-item' selected value='$parentId' >$disclaimer </option>";
        $dropDownMenu.= $this->printOutAdminDropDownMenu($categories);
        $dropDownMenu.= "</select>";

        return $dropDownMenu;
    }

    public function updateCategory ()
    {
        $categoryTitle = $this->stripTags($_POST['category_title']);

        $engTranslitTitle = LangService::translite_in_Latin($categoryTitle);

        $sql = "UPDATE `categories` SET `title`=? , `parent_id`=? , `eng_translit_title`=? WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(1, $categoryTitle, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['category_id'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $engTranslitTitle, \PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        unset ($_SESSION['editCategorytitle']);
    }


    public function storeCategory()
    {
        $categoryTitle = $this->stripTags($_POST['category_title']);

        $engTranslitTitle = LangService::translite_in_Latin($categoryTitle);

        $sql = "INSERT INTO `categories` ( `title`, `parent_id`, `eng_translit_title`) VALUES (?, ?, ? )";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(1, $categoryTitle, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['category_id'], \PDO::PARAM_INT);
        $stmt->bindValue(3, $engTranslitTitle, \PDO::PARAM_STR);

        $stmt->execute();
        $id = $this->conn->lastInsertId();
        unset ($_SESSION['createCategory']);
        return $id;
    }

    public function findChildCategories()
    {
        $sql = "SELECT `id` FROM `categories` WHERE `parent_id` =?";
        $stmt = $this->conn ->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $res= $stmt->fetch();

        unset($_SESSION['deleteCategory']);
        return !!$res;

    }

    public function findProductsInCategory()
    {
        $sql = "SELECT `id` FROM `products` WHERE `cat_id` =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt ->execute();
        $res = $stmt->fetch();
        unset($_SESSION['deleteCategory']);
        return !!$res;
    }

    public function deleteCategory()
    {
        $sql = "DELETE FROM `categories` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1 ,$_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        unset($_SESSION['deleteCategory']);
    }

    /**
     * get the aray of categories where $id => $title
     *
     * @return array
     */
    public function getPointedCategories()
    {
        if(!$_POST['category_ids']) return false;
        $ids = explode(',', $_POST['category_ids']);


        $array =[];
        $sql ="SELECT `title` FROM `categories` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        foreach($ids as $id) {
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);
            $stmt->execute();
            $title= $stmt->fetchColumn();

            $array[$id]= $title;
        }
        return $array;
    }

}