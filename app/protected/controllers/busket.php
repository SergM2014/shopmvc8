<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Busket;
use App\Models\DB_Index;


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
        /*return ['view'=> 'customer/smallBusket.php', 'ajax'=>true ];*/
        return $this->refreshSmallBusket();
    }

    public function recount()
    {

        (new DB_Busket())->refreshBusketSession();

        return $this->index();
    }



	
  }
  