<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Product;




  class Product  extends BaseController
  {

    public function index()
	{

       $product_info = (new DB_Product())->getPreview();

      return ['view'=>'customer/product.php', 'product_info'=> $product_info, 'ajax'=> true ];
    }




	
  }
  