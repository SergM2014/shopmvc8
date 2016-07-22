<?php

namespace App\Models;
use App\Core\DataBase;
use Gregwar\Captcha\CaptchaBuilder;

use function \published;
use function \unpublished;
use function \deleted;

 class DB_Index extends DataBase
  {
     /**
      * gathering general comment info from DB due to page and order
      *
      * @return resul of query
      */
   public function getResult()
   {
      $p = @ $_POST['p']? : '1';
      $start = (int)($p-1)*AMOUNTONPAGE;

      switch(@ $_POST['order']){
          case 'old_first': $order = "`date` DESC"; break;
          case 'new_first': $order = "`date` ASC"; break;
          case 'email': $order = "`email`"; break;
          case 'name': $order = "`name`"; break;
         default: $order = "`date` DESC";
      }

       $quoted_order= $this->conn->quote($order);
       $sql = "SELECT `id`, `avatar`, `name`, `comment`, `date`, `changed`, `published` FROM `comments` WHERE `published`='1' ORDER BY ".$order." LIMIT ?, ?";

        $stmt = $this->conn->prepare($sql);

      // $stmt->bindValue(1, $order, \PDO::PARAM_STR);
       $stmt->bindValue(1, $start, \PDO::PARAM_INT);
       $stmt->bindValue(2, AMOUNTONPAGE, \PDO::PARAM_INT);
       $stmt->execute();
       $result = $stmt->fetchAll();

       return $result;
   }

     /**
      *
      * get the number of published pages
      *
      * @return float
      */
     public function getPublishedPages()
     {
         $sql= "SELECT `id` FROM `comments` WHERE `published`='1'";
         $stmt = $this->conn->query($sql);
         $count = $stmt->rowCount();
         $number = ceil($count/AMOUNTONPAGE);
         return $number;
     }

     public function printCaptcha()
     {
         $builder = new CaptchaBuilder;
         $builder->build();
         $_SESSION['phrase'] = $builder->getPhrase();
         return $builder;
     }




     public function countAdminCommentsPages()
     {
         $sql= "SELECT `id` FROM `comments`";
         $stmt = $this->conn->query($sql);
         $count = $stmt->rowCount();
         $number = ceil($count/AMOUNTONPAGEADMIN);
         return $number;
     }

     public function getAdminCommentsResult()
     {
         $p = @ $_POST['p']? : '1';
         $start = (int)($p-1)*AMOUNTONPAGEADMIN;

         switch(@ $_POST['order']){
             case 'old_first': $order = "`date` ASC"; break;
             case 'new_first': $order = "`date` DESC"; break;
             case 'email': $order = "`email`"; break;
             case 'name': $order = "`name`"; break;
             default: $order = "`date` ASC";
         }

         //$quoted_order= $this->conn->quote($order);//doesnot work
         $sql = "SELECT `id`, `avatar`, `name`, `email`, `comment`, `date`, `changed`, `published` FROM `comments` ORDER BY ".$order." LIMIT ?, ?";

         $stmt = $this->conn->prepare($sql);

         // $stmt->bindValue(1, $order, \PDO::PARAM_STR);
         $stmt->bindValue(1, $start, \PDO::PARAM_INT);
         $stmt->bindValue(2, AMOUNTONPAGEADMIN, \PDO::PARAM_INT);
         $stmt->execute();
         $result = $stmt->fetchAll();

         return $result;
     }

     public function publishAll($data)
     {
        if(is_string($data)) $data = explode(',', $data);

         $arr= [];
         foreach ($data as $one){
             $this->publish($one);
             $arr[] =$one;
         }

         return ["items" => $arr, "message" => published()];
     }

     private function publish($id)
     {
         $sql = "UPDATE `comments` SET `published`='1' WHERE `id`= ?";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindValue(1, $id, \PDO::PARAM_INT);
         $stmt->execute();
     }


     public function unpublishAll($data)
     {
         if(is_string($data)) $data = explode(',', $data);
         $arr= [];
         foreach ($data as $one){
             $this->unpublish($one);
             $arr[] =$one;
         }

         return ["items" => $arr, "message" => unpublished()];
     }

     private function unpublish($id)
     {
         $sql = "UPDATE `comments` SET `published`='0' WHERE `id`= ?";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindValue(1, $id, \PDO::PARAM_INT);
         $stmt->execute();
     }


     public function deleteAll($data)
     {
         if(is_string($data)) $data = explode(',', $data);
         $arr= [];
         foreach ($data as $one){
             $this->deleteOne($one);
             $arr[] =$one;
         }

         return ["items" => $arr, "message" => deleted()];
     }

     private function deleteOne($id)
     {
         $sql = "DELETE FROM `comments`  WHERE `id`= ?";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindValue(1, $id, \PDO::PARAM_INT);
         $stmt->execute();
     }

     public function getOneComment()
     {
         $sql= "SELECT `id`, `avatar`, `name`, `email`, `comment`, `changed`, `published`, `date` FROM `comments` WHERE `id` = ?";
         $stmt = $this-> conn ->prepare($sql);
         $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
         $stmt->execute();
         $result = $stmt->fetch();

         return $result;

     }


	
  }
  
