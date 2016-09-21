<?php

namespace App\Models;

use App\Core\DataBase;
use Lib\CookieService;



 class DB_Busket extends DataBase
 {
     protected $id;

     protected $price;

     public function __construct()
     {
         parent::__construct();

         $this->id = (int)$_POST['id'];
         $this->price = floatval($_POST['price']);
     }

     protected function addToSmallBusket(){

         @ $_SESSION['total_amount'] +=1;
         @ $_SESSION['total_sum'] += $this->price;
         CookieService::addCookies();
     }

     public function add()
     {


       if(isset($_SESSION['busket'])){

           if(!isset($_SESSION['busket'])){
               $_SESSION['busket'][$this->id] = 1;
           } else {
               $_SESSION['busket'][$this->id] += 1;
           }

       } else {
           $_SESSION['busket'] = [];
           $_SESSION['busket'][$this->id] = 1;
       }

       $this->addToSmallBusket();


     }
 }
