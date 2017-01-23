<?php


namespace App\Models;


use App\Core\DataBase;
use Lib\LangService;
use Lib\CheckFieldsService;


use function  \succeeded_upload;
use function \restricted_file_type;
use function \too_big_file;
use function \smth_is_wrong;
use function \file_deleted;


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


    public function uploadImage(){

        $path = PATH_SITE.UPLOAD_FOLDER.SLIDER_IMAGES;



        // Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');

        // Максимальный размер файла 20mb
        $size = 20480000;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array(strtolower($_FILES['file']['type']), $types))

                return $response =["message"=>"<span class='image-upload--failed'>".restricted_file_type(). "</span>", "error"=>true];

            // Проверяем размер файла
            if ($_FILES['file']['size'] > $size)

                return $response =["message"=>"<span class='image-upload--failed'>". too_big_file().$_FILES['file']['size']."</span>", "error" => true];

            $name = $this->createFileName($_FILES['file'] ['name']);

            // Загрузка файла и вывод сообщения

            if(!move_uploaded_file($_FILES['file']['tmp_name'], $path.$name)) {
                return $response =["message"=>"<span class='image-upload--failed'>". smth_is_wrong()." </span>", "error" => true];
            }
            else {


                // $'createSlider or updateSlider

                $_SESSION[$_POST['action']] = $name;

                $response=["message"=>"<span class='image-upload--succeded'>".succeeded_upload()."</span>", "success"=>true, "image"=>$name, 'path'=>UPLOADS.SLIDER_IMAGES];
                chmod ($path.$name , 0777);
            }

        }

        return $response;
    }


    public function deleteImage()
    {
        $slider = @ $_SESSION[$_POST['action']];

        @unlink(PATH_SITE.UPLOAD_FOLDER.SLIDER_IMAGES.$slider);

        unset ( $_SESSION[@$_POST['action']]);
        $response= ["message"=>"<span class='image-delete--succeded'>". file_deleted() ."</span>", "bild"=> $slider];

        return $response;
    }


    private function createFileName($name)
    {
        $name = strtolower($name);
        $arr = explode('.', $name);
        $name = $arr[0].'_'.time().'.'.$arr[1];
        return $name;
    }

}