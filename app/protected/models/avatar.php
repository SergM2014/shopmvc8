<?php

namespace App\Models;
use App\Core\DataBase;

use function \succeeded_upload;
use function \restricted_file_type;
use function \too_big_file;
use function \smth_is_wrong;
use function \file_deleted;

class Avatar extends DataBase
{

    public function uploadAvatar(){

        $path = PATH_SITE.UPLOAD_FILE.'avatars/';
        $tmp_path= PATH_SITE.UPLOAD_FILE.'tmp/';
        // Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');

        // Максимальный размер файла 2mb
        $size = 2048000;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array(strtolower($_FILES['add-comment__choose-avatar']['type']), $types))

                return $response =["message"=>"<span class='error'>".restricted_file_type(). "</span>", "error"=>true];

            // Проверяем размер файла
            if ($_FILES['add-comment__choose-avatar']['size'] > $size)

                return $response =["message"=>"<span class='add-comment__avatar-image--error'>". too_big_file().$_FILES['FileInput']['size']."</span>", "error" => true];

            $name = $this->resizeAvatar($_FILES['add-comment__choose-avatar'], $tmp_path);

            // Загрузка файла и вывод сообщения
            if(!@copy($tmp_path.$name, $path.$name)) {
                return $response =["message"=>"<span class='add-comment__avatar-image--error'>". smth_is_wrong()." </span>", "error" => true];
            }
            else {

                $_SESSION['avatar']= $name;


                $response=["message"=>"<span class='add-comment__avatar-image--loaded'>".succeeded_upload()."</span>", "success"=>true, "bild"=>$_SESSION['avatar']];
                chmod ($path.$name , 0777);
            }
            // Удаляем временный файл
            unlink(PATH_SITE.UPLOAD_FILE.'tmp/' . $name);
        }

        return $response;
    }



    private function resizeAvatar($file, $tmp_path)
    {

        $file['name'] = strtolower($file['name']);
        $arr = explode('.', $file['name']);
        $file['name'] = $arr[0].'_'.time().'.'.$arr[1];

        // $w =100;
        $h=130;

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
            imagejpeg($dest, $tmp_path. $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($source);
            chmod ($tmp_path . $file['name'] , 0777);

            return $file['name'];
        } else {
            // Вывод картинки и очистка памяти
            //output image into browser or file
            imagejpeg($source, $tmp_path. $file['name'], $quality);
            imagedestroy($source);
            chmod ($tmp_path . $file['name'] , 0777);

            return $file['name'];
        }
    }


    public function deleteAvatar()
    {
        $avatar = @ $_SESSION['avatar'];
        @ unlink ( PATH_SITE.UPLOAD_FILE.'avatars/'.$_SESSION['avatar']);
        unset ( $_SESSION['avatar']);
        $response= ["message"=>"<span class='add-comment__avatar-image--deleted'>". file_deleted() ."</span>", "bild"=> $avatar];

        return $response;
    }







}