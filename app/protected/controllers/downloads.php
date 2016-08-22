<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Index;
use App\Models\Categories;


class Downloads  extends BaseController
{
    /**
     * fire off he index action
     *
     * @return array
     */
    public function index()
    {

        $model= new DB_Index();


        $downloads = $model->getDownloads();

        $carousel = $model->getCarousel();

        $categoriesVertMenu = (new Categories())->getVerticalMenu();

        return ['view'=>'customer/downloads.php', 'downloads'=>$downloads, 'carousel'=>$carousel, 'categoriesVertMenu'=>$categoriesVertMenu];
    }




}