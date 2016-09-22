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
               $_SESSION['busket'][$this->newId] += 1;
           }

       } else {
           $_SESSION['busket'] = [];
           $_SESSION['busket'][$this->newId] = 1;
       }

       $this->addToSmallBusket();


     }

     public function getBusketInfo()
     {

         $model = new DB_Product();
         $items =[];

        foreach ( $_SESSION['busket'] as $key => $value){
           $item = $model->getProductForBusket($key);
           $item->number = $value;
           $items[] = $item;
        }
        return $items;
     }

 }
