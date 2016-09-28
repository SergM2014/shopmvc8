<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CookieService;
use App\Models\DB_Product;



 class DB_Busket extends DataBase
 {
     protected $newId;

     protected $newPrice;

     public function __construct()
     {
         parent::__construct();

         $this->newId = @(int)$_POST['id'];
         $this->newPrice = floatval(@ $_POST['price']);
     }

     protected function addToSmallBusket(){

         @ $_SESSION['total_amount'] +=1;
         @ $_SESSION['total_sum'] += $this->newPrice;
         CookieService::addCookies();
     }

     public function add()
     {
       if(isset($_SESSION['busket'])){

           if(!isset($_SESSION['busket'])){
               $_SESSION['busket'][$this->newId] = 1;
           } else {
               @$_SESSION['busket'][$this->newId] += 1;
           }

       } else {
           $_SESSION['busket'] = [];
           $_SESSION['busket'][$this->newId] = 1;
       }

       $this->addToSmallBusket();


     }

     public function getBusketInfo()
     {
        if(@ !$_SESSION['busket']) return false;
         $model = new DB_Product();
         $items =[];

         foreach ( $_SESSION['busket'] as $key => $value){
           $item = $model->getProductForBusket($key);
           $item->number = $value;
           $items[] = $item;
        }
        return $items;
     }


     protected  function refreshAmountAndSumInBusket()
     {
         $amountOfItems = 0;
         $totalSum = 0;
         foreach($_SESSION['busket'] as $key => $value){
            $amountOfItems += $value;

             $sql ="SELECT `price` FROM `products` WHERE `id`=?";
             $stmt = $this->conn->prepare($sql);
             $stmt->bindValue(1, $key, \PDO::PARAM_INT);
             $stmt->execute();
             $result = $stmt->fetch();

             $currentPrice = $result->price;

             $totalSum += $currentPrice*$value;

         }

         $_SESSION['total_amount'] = $amountOfItems;
         $_SESSION['total_sum'] = $totalSum;
     }

     public function refreshBusketSession()
     {
 /*var_dump($_POST);
 echo "<br>";*/
         $busket = $_POST;
         foreach ($busket as $key => &$value){
             $value = abs($value);
             if($value =="" OR $value == 0) unset($busket[$key]);
         }

/* var_dump($busket);
 die();*/
        $_SESSION['busket'] = $busket;
         $this->refreshAmountAndSumInBusket();

         CookieService::addCookies();


     }

 }
