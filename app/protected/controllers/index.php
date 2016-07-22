<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Index;


  class Index  extends BaseController
  {
      /**
       *
       *
       * fire toff he index action
       *
       * @return array
       */
    public function index()
	{
        $model = new DB_Index();
        $result = $model->getResult();
        $pages = $model->getPublishedPages();

        $builder = $model->printCaptcha();


      return ['view'=>'customer/index.php', 'builder'=>$builder, 'result'=>$result, 'pages'=>$pages];
    }

    public function refreshCaptcha()
    {
        $builder = (new DB_Index)->printCaptcha();
        return ['view' => 'customer/partials/captcha.php', 'builder' => $builder, 'ajax' => true];
    }


	
  }
  