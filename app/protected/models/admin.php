<?php

namespace App\Models;
use App\Core\DataBase;


class AdminModel extends DataBase
{
    public function getAdminUser()
    {

        if( @!$_POST['login'] OR !$_POST['password']) return;
        $sql = "SELECT `login` , `password`, `role` FROM `users` WHERE `login`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if( password_verify( $_POST['password'], $user->password ) ) $_SESSION['admin']= true;

    }
    public function getLoopCounter()
    {
        $p = @ $_POST['p']? : '1';
        $counter = (int)($p-1)*AMOUNTONPAGEADMIN +1;
        return $counter;
    }

    public  function removeUnnecessaryImages()
    {
        $this->cleanDirectory(PRODUCTS_IMAGES, 'images');
        $this->cleanDirectory(PRODUCTS_IMAGES_THUMBS, 'images');
        $this->cleanDirectory(SLIDER_IMAGES, 'slider');
        $this->cleanDirectory(CAROUSEL_IMAGES, 'images');
        $this->cleanDirectory(AVATARS_IMAGES, 'comments', 'avatar');

        /*
        $productImagesArray = $this->getDirectoryImages(AVATARS_IMAGES);

        $sql = "SELECT `avatar` FROM `comments`";
        $result = $this->conn->query($sql);
        $res = $result->fetchAll();

        $productImagesDbArray =[];

        foreach ($res as $one){
            if(!is_null($one->avatar))
            $productImagesDbArray[] =$one->avatar;
        }

        $arrayDiff = array_diff($productImagesArray, $productImagesDbArray);
        foreach($arrayDiff as $image){
            @unlink(PATH_SITE.UPLOAD_FOLDER.AVATARS_IMAGES.$image);

        }*/





    }

    private function getDirectoryImages($directory)
    {
        $extentionsArray = ['jpg','png','jpeg','gif'];
        $productImagesArray = [];

        $dir = new \DirectoryIterator(PATH_SITE.UPLOAD_FOLDER.$directory);

        foreach ($dir as $file){
            if ($file->isFile()) {
                $ext = $file->getExtension();
                if(in_array($ext, $extentionsArray)){
                    $productImagesArray[] = $file->getFilename();
                }
            }
        }
        return $productImagesArray;
    }

    private function cleanDirectory($folder, $table, $column = 'image')
    {
        $productImagesArray = $this->getDirectoryImages($folder);

        $sql = "SELECT `$column` FROM `$table`";
        $result = $this->conn->query($sql);
        $res = $result->fetchAll();

        $productImagesDbArray =[];

        foreach ($res as $one){
            $productImagesDbArray[] =$one->image;
        }
        $arrayDiff = array_diff($productImagesArray, $productImagesDbArray);
        foreach($arrayDiff as $image){
            @unlink(PATH_SITE.UPLOAD_FOLDER.$folder.$image);

        }
    }

}