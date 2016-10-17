<?php

namespace App\Models;
use App\Core\DataBase;

use function \succeeded_upload;
use function \restricted_file_type;
use function \too_big_file;
use function \smth_is_wrong;
use function \file_deleted;

class Images extends DataBase
{

    public function uploadImage(){

        $path = PATH_SITE.UPLOAD_FILE.'productsImages/';
        //$tmp_path= PATH_SITE.UPLOAD_FILE.'tmp/';
        $thumb_path= PATH_SITE.UPLOAD_FILE.'productsImages/thumbs/';

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

            $name = $this->resizeImage($_FILES['file'], $thumb_path);

            // Загрузка файла и вывод сообщения
            if(!@copy($thumb_path.$name, $path.$name)) {
                return $response =["message"=>"<span class='image-upload--failed'>". smth_is_wrong()." </span>", "error" => true];
            }
            else {

                $_SESSION['image']= $name;

                $response=["message"=>"<span class='image-upload--succeded'>".succeeded_upload()."</span>", "success"=>true, "bild"=>$_SESSION['image']];
                chmod ($path.$name , 0777);
            }
            // Удаляем временный файл
           // unlink(PATH_SITE.UPLOAD_FILE.'productImages/thumbs/' . $name);
        }

        return $response;
    }


    private function resizeImage($file, $thumb_path)
    {

        $file['name'] = strtolower($file['name']);
        $arr = explode('.', $file['name']);
        $file['name'] = $arr[0].'_'.time().'.'.$arr[1];

        // $w =100;
       // $h=130;
        $h = 300;

        // Качество изображения по умолчанию
        $quality = 75;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] == 'image/jpeg')
            $source = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $source = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/gif')
            $source = imagecreatefromgif($file['tmp_name']);
        else
            return false;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($source);
        $h_src = imagesy($source);

        // Если высота больше заданной
        if($h_src>$h){

            // Вычисление пропорций
            $ratio = $h_src/$h;
            $w_dest = round($w_src / $ratio);
            $h_dest = round($h_src / $ratio);

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);

            // Копируем старое изображение в новое с изменением параметров
            imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, $thumb_path. $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($source);
            chmod ($thumb_path . $file['name'] , 0777);

            return $file['name'];
        } else {
            // Вывод картинки и очистка памяти
            //output image into browser or file
            imagejpeg($source, $thumb_path. $file['name'], $quality);
            imagedestroy($source);
            chmod ($thumb_path . $file['name'] , 0777);

            return $file['name'];
        }
    }


    public function deleteImage()
    {
        $avatar = @ $_SESSION['image'];
        @ unlink ( PATH_SITE.UPLOAD_FILE.'productsImages/'.$_SESSION['image']);
        @ unlink ( PATH_SITE.UPLOAD_FILE.'productsImages/thumbs/'.$_SESSION['image']);
        unset ( $_SESSION['image']);
        $response= ["message"=>"<span class='image-delete--succeded'>". file_deleted() ."</span>", "bild"=> $avatar];

        return $response;
    }







}