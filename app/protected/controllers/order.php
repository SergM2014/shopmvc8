<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Index;




  class Order  extends BaseController
  {
      /**
       * fire off he index action
       *
       * @return array
       */
    public function showForm()
	{

      return ['view'=>'customer/orderForm.php', 'ajax' => true ];
    }


      public function refreshCaptcha()
      {
          $builder = (new DB_Index)->printCaptcha();
          return ['view' => 'customer/partials/captcha.php', 'builder' => $builder, 'ajax' => true];
      }


	
  }
  