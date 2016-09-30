<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Busket;
use Lib\TokenService;


class Busket  extends BaseController
  {
      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
        $busketItems =(new DB_Busket())->getBusketInfo();


      return ['view'=>'customer/busket.php', 'busketItems' => $busketItems, 'ajax'=>true ];
    }


    public function refreshSmallBusket()
    {
        return ['view'=> 'customer/smallBusket.php', 'ajax'=>true ];
    }


    public function add()
    {
        (new DB_Busket())->add();

        return $this->refreshSmallBusket();
    }


    public function recount()
    {
        TokenService::check('prozessBusket');

        (new DB_Busket())->refreshBusketSession();

        return $this->index();
    }


    public function makeOrder()
    {
        TokenService::check('prozessBusket');
        $model =  new DB_Busket;
        $errors = $model->checkIfNotEmpty();
        if(!empty($errors)){
            return ['view' => 'customer/makeOrderErrors.php', 'errors' => $errors];
        }

        $model-> addOrder();
        return ['view' => 'customer/succeededOrder.php'];
    }

	
  }
  