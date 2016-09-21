<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Busket;



  class Busket  extends BaseController
  {
      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
       //$model = new DB_Index();


      return ['view'=>'customer/busket.php', 'ajax'=>true ];
    }


    public function add()
    {
        (new DB_Busket())->add();
        return ['view'=> 'customer/smallBusket.php', 'ajax'=>true ];
    }



	
  }
  