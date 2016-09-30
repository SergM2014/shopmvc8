<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CheckFieldsService;
use Lib\HelperService;
use Lib\CookieService;

use function \empty_field;



 class DB_Busket extends DataBase
 {
     use CheckFieldsService;

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

         $busket = $_POST;
         foreach ($busket as $key => &$value){
             $value = abs($value);
             if($value =="" OR $value == 0) unset($busket[$key]);
         }

        $_SESSION['busket'] = $busket;
         $this->refreshAmountAndSumInBusket();

         CookieService::addCookies();


     }


     public function checkIfNotEmpty()
     {
         $data= HelperService::cleanInput($_POST);
         $error=[];
         if(empty($data['name'])) $error['name']= empty_field();
         if(empty($data['phone'])) $error['phone']= empty_field();

         return $error;
     }


     public function addOrder()
     {
         $data = HelperService::cleanInput($_POST , 'message');
         $message = $this->stripTags($_POST['message']);

         $products = @ json_encode($_SESSION['busket']);
 //защита против повтоного обновления makeorder
         if(!isset($_SESSION['busket'])) { return;}

         $sql = "INSERT INTO `orders` (`name`, `email`, `phone`, `message`, `products`) VALUES (?, ?, ?, ?, ?)";
         $stmt = $this->conn ->prepare($sql);
         $stmt -> bindValue(1, $data['name'], \PDO::PARAM_STR);
         $stmt -> bindValue(2, $data['email'], \PDO::PARAM_STR);
         $stmt -> bindValue(3, $data['phone'], \PDO::PARAM_STR);
         $stmt -> bindValue(4, $message, \PDO::PARAM_STR);
         $stmt -> bindValue(5, $products, \PDO::PARAM_STR);
         $stmt -> execute();

         $currentId = $this->conn ->LastInsertId();

         unset ($_SESSION['busket']);
         unset ($_SESSION['total_amount']);
         unset ($_SESSION['total_sum']);

         CookieService::deleteBusketCookies();

         HelperService::toMail($message, 'order#'.$currentId , $data['name'], $data['phone']);

     }

 }
