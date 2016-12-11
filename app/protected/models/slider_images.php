<?php

namespace App\Models;

use App\Core\DataBase;

use function  \succeeded_upload;
use function \restricted_file_type;
use function \too_big_file;
use function \smth_is_wrong;
use function \file_deleted;

class Slider_Images extends DataBase
{

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

        unset ( $_SESSION[$_POST['action']]);
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