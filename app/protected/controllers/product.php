<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Product;




  class Product  extends BaseController
  {

    public function index()
	{

       $product_info = (new DB_Product())->getPreview();

      return ['view'=>'customer/product/preview.php', 'product_info'=> $product_info, 'ajax'=> true ];
    }

    public function show()
    {
        $model = new DB_Product();
        $productInfo = $model->getProduct();
        $productComments = $model->getComments();

        return ['view'=>'customer/product/show.php', 'productInfo'=> $productInfo, 'productComments' => $productComments ];
    }


	
  }
  