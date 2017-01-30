<?php

namespace App\Models;

use App\Core\Prozess_Image;

use function  \succeeded_upload;
use function \smth_is_wrong;
use function \file_deleted;

class Carousel_Images extends Prozess_Image
{

    public function uploadImage(){

        $path = PATH_SITE.UPLOAD_FOLDER.CAROUSEL_IMAGES;

        $error =  $this->checkUploadFileErrors();
        if(!empty($error)) return $error;

            $name = $this->resizeImage($_FILES['file'], $path, CAROUSEL_H, CAROUSEL_W);

            // Загрузка файла и вывод сообщения

            if(!@$name) {
                return $response =["message"=>"<span class='image-upload--failed'>". smth_is_wrong()." </span>", "error" => true];
            }
            else {


                $_SESSION[$_POST['action']] = $name;

                $response=["message"=>"<span class='image-upload--succeded'>".succeeded_upload()."</span>", "success"=>true, "image"=>$name, 'path'=>UPLOADS.CAROUSEL_IMAGES];
                chmod ($path.$name , 0777);
            }


        return $response;
    }





    public function deleteImage()
    {
        $avatar = @ $_SESSION[$_POST['action']];
        @ unlink ( PATH_SITE.UPLOAD_FOLDER.CAROUSEL_IMAGES.$avatar);
        unset ( $_SESSION[@$_POST['action']]);
        $response= ["message"=>"<span class='image-delete--succeded'>". file_deleted() ."</span>", "image"=> $avatar];

        return $response;
    }







}