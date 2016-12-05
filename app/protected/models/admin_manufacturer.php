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

        $sql = "SELECT `id`, `title`, `eng_translit_title`, `url` FROM `manufacturers` WHERE `id`=? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();

        return $res;
    }






    public function updateManufacturer ()
    {
        $manufacturerTitle = $this->stripTags($_POST['manufacturer_title']);

        $engTranslitTitle = LangService::translite_in_Latin($manufacturerTitle);

        $manufacturerUrl = $this->stripTags($_POST['manufacturer_url']);

        $sql = "UPDATE `manufacturers` SET `title`=? , `url`=? , `eng_translit_title`=? WHERE `id`=?";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(1, $manufacturerTitle, \PDO::PARAM_STR);
        $stmt->bindValue(2, $manufacturerUrl, \PDO::PARAM_STR);
        $stmt->bindValue(3, $engTranslitTitle, \PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        unset ($_SESSION['editManufacturer']);
    }




    public function findProductsInIt()
    {
        $sql = "SELECT `id` FROM `products` WHERE `manf_id` =?";
        $stmt = $this->conn ->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $res= $stmt->fetch();

        unset($_SESSION['deleteManufacturer']);
        return !!$res;

    }



    public function deleteManufacturer()
    {
        $sql = "DELETE FROM `manufacturers` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1 ,$_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        unset($_SESSION['deleteManufacturer']);
    }

}