<?php

namespace App\Models;

use App\Core\DataBase;

//these function are for ajax translation
/*use function \published;
use function \unpublished;
use function \deleted;*/

 class DB_Index extends DataBase
 {

    public function getSlider()
    {
        $sql = "SELECT `image`, `url`, `title` FROM `slider`";
        $result = $this->conn->query($sql);
        $carousel = $result->fetchAll();
        return $carousel;
    }

     //get results for carousel
     public function getCarousel()
     {
         $sql = "SELECT `image`, `url` FROM `carousel`";
         $result = $this->conn->query($sql);
         $carousel = $result->fetchAll();
         return $carousel;

     }

     public function getAboutUsInfo()
     {
        $sql= "SELECT `aboutUs` FROM `background`";
         $result = $this->conn->query($sql);
         $aboutUs = $result->fetchColumn(0);

         return $aboutUs;
     }



 }
