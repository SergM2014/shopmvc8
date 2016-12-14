<?php


namespace App\Models;


use App\Core\DataBase;
use Lib\LangService;
use Lib\CheckFieldsService;


class Admin_Carousel extends DataBase
{
    use CheckFieldsService;

   public function getCarousels()
   {
       $sql = "SELECT `id`, `image`, `url` FROM `carousel`";
       $stmt = $this->conn->query($sql);
       $res = $stmt->fetchAll();
       return $res;

   }

    public function storeCarousel()
    {
        $carouselUrl = strip_tags($_POST['carousel_url']);

        $sql = "INSERT INTO `carousel` ( `image`, `url` ) VALUES (?, ? )";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(1, $_SESSION['createCarousel'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $carouselUrl, \PDO::PARAM_STR);


        $stmt->execute();
        $id = $this->conn->lastInsertId();
        unset ($_SESSION['createCarousel']);
        unset ($_SESSION['makeCarousel']);
        return $id;
    }



    public function getOneCarousel()
    {
        $id = @$_GET['id']?: @$_POST['id'];
        $sql = "SELECT `id`, `image`,  `url` FROM `carousel` WHERE `id`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();

        return $res;
    }



    public function updateCarousel ()
    {
        $carouselUrl = strip_tags($_POST['carousel_url']);

        if(@$_SESSION['updateCarousel']) {

            $sql = "UPDATE `carousel` SET  `url` = ? , `image` = ? WHERE `id`=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $carouselUrl, \PDO::PARAM_STR);
            $stmt->bindValue(2, $_SESSION['updateCarousel'], \PDO::PARAM_STR);
            $stmt->bindValue(3, $_POST['id'], \PDO::PARAM_INT);
        } else {
            $sql = "UPDATE `carousel` SET `url` = ?  WHERE `id`=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $carouselUrl, \PDO::PARAM_STR);
            $stmt->bindValue(2, $_POST['id'], \PDO::PARAM_INT);
        }

        $stmt->execute();
        unset ($_SESSION['editCarousel']);
        unset ($_SESSION['updateCarousel']);
    }





    public function deleteCarousel()
    {
        $sql = "DELETE FROM `carousel` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1 ,$_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        unset($_SESSION['deleteCarousel']);
    }

}