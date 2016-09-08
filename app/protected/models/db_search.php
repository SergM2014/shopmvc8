<?php

namespace App\Models;

use App\Core\DataBase;



 class DB_Search extends DataBase
 {
     public function index()
     {
         $search = $_POST['search'];

         $sql = "SELECT `id`, `author`, `title` FROM `products` WHERE `author` LIKE ? OR `title` LIKE ? LIMIT 0,7";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindValue(1, "%$search%", \PDO::PARAM_STR);
         $stmt->bindValue(2, "%$search%", \PDO::PARAM_STR);
         $stmt->execute();
         $result =  $stmt->fetchAll();

         return $result;
     }
 }
