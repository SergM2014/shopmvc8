<?php


namespace App\Models;


use App\Core\DataBase;
use Lib\LangService;
use Lib\CheckFieldsService;


class Admin_Manufacturer extends DataBase
{
    use CheckFieldsService;

   public function getManufacturers()
   {
       $sql = "SELECT `id`, `title`, `url`, `eng_translit_title` FROM `manufacturers`";
       $stmt = $this->conn->query($sql);
       $res = $stmt->fetchAll();
       return $res;

   }

    public function storeManufacturer()
    {
        $manufacturerTitle = $this->stripTags($_POST['manufacturer_title']);

        $engTranslitTitle = LangService::translite_in_Latin($manufacturerTitle);

        $url = $this->stripTags($_POST['manufacturer_url']);

        $sql = "INSERT INTO `manufacturers` ( `title`, `eng_translit_title`, `url`) VALUES (?, ?, ? )";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(1, $manufacturerTitle, \PDO::PARAM_STR);
        $stmt->bindValue(2, $engTranslitTitle, \PDO::PARAM_STR);
        $stmt->bindValue(3, $url, \PDO::PARAM_STR);

        $stmt->execute();
        $id = $this->conn->lastInsertId();
        unset ($_SESSION['createManufacturer']);
        return $id;
    }



    public function getOneManufacturer()
    {
        $id = @$_GET['id']?: @$_POST['id'];

        $sql = "SELECT `id`, `title`, `eng_translit_title`, `url` FROM `categories` WHERE `id`=? ";

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

}