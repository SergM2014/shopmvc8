<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Index;
use App\Models\Categories;


class Aboutus  extends BaseController
{
    /**
     * fire off he index action
     *
     * @return array
     */
    public function index()
    {

        $model= new DB_Index();

        $aboutUs = $model->getAboutUsInfo();

        $carousel = $model->getCarousel();

        $categoriesVertMenu = (new Categories())->getVerticalMenu();

        return ['view'=>'customer/aboutUs.php', 'aboutUs'=>$aboutUs, 'carousel'=>$carousel, 'categoriesVertMenu'=>$categoriesVertMenu];
    }




}
