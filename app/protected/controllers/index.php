<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Index;
use App\Models\Categories;


  class Index  extends BaseController
  {
      /**
       * fire off he index action
       *
       * @return array
       */
    public function index()
	{
       $model = new DB_Index();

        $slider = $model->getSlider();

        $carousel = $model->getCarousel();

        $categoriesVertMenu = (new Categories())->getVerticalMenu();

      return ['view'=>'customer/index.php', 'slider'=>$slider, 'carousel'=>$carousel, 'categoriesVertMenu'=>$categoriesVertMenu];
    }



    public function refreshCaptcha()
    {
        $builder = (new DB_Index)->printCaptcha();
        return ['view' => 'customer/partials/captcha.php', 'builder' => $builder, 'ajax' => true];
    }


	
  }
  