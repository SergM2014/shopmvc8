<?php


namespace App\Models;


use App\Core\DataBase;
use Lib\LangService;
use Lib\CheckFieldsService;


class Admin_Slider extends DataBase
{
    use CheckFieldsService;

   public function getSliders()
   {
       $sql = "SELECT `id`, `image`, `title`, `url` FROM `slider`";
       $stmt = $this->conn->query($sql);
       $res = $stmt->fetchAll();
       return $res;

   }

    public function storeSlider()
    {
        $sliderTitle = strip_tags($_POST['slider_title']);


        $sliderUrl = strip_tags($_POST['slider_url']);

        $sql = "INSERT INTO `slider` ( `image`, `url`, `title` ) VALUES (?, ?, ? )";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindValue(1, $_SESSION['createSlider'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $sliderUrl, \PDO::PARAM_STR);
        $stmt->bindValue(3, $sliderTitle, \PDO::PARAM_STR);


        $stmt->execute();
        $id = $this->conn->lastInsertId();
        unset ($_SESSION['createSlider']);
        unset ($_SESSION['makeSlider']);
        return $id;
    }



    public function getOneSlider()
    {
        $id = @$_GET['id']?: @$_POST['id'];
        $sql = "SELECT `id`, `image`,  `url`, `title` FROM `slider` WHERE `id`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();

        return $res;
    }



    public function updateSlider ()
    {
        $sliderTitle = strip_tags($_POST['slider_title']);

        $sliderUrl = strip_tags($_POST['slider_url']);

        if(@$_SESSION['updateSlider']) {

            $sql = "UPDATE `slider` SET `title` = ? , `url` = ? , `image` = ? WHERE `id`=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $sliderTitle, \PDO::PARAM_STR);
            $stmt->bindValue(2, $sliderUrl, \PDO::PARAM_STR);
            $stmt->bindValue(3, $_SESSION['updateSlider'], \PDO::PARAM_STR);
            $stmt->bindValue(4, $_POST['id'], \PDO::PARAM_INT);
        } else {
            $sql = "UPDATE `slider` SET `title` = ? , `url` = ?  WHERE `id`=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $sliderTitle, \PDO::PARAM_STR);
            $stmt->bindValue(2, $sliderUrl, \PDO::PARAM_STR);
            $stmt->bindValue(3, $_POST['id'], \PDO::PARAM_INT);
        }

        $stmt->execute();
        unset ($_SESSION['editSlider']);
        unset ($_SESSION['updateSlider']);
    }





    public function deleteSlider()
    {
        $sql = "DELETE FROM `slider` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1 ,$_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        unset($_SESSION['deleteSlider']);
    }

}