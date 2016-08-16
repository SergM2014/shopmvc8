<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Catalog;
use App\Models\Categories;



class Catalog  extends BaseController
{
    /**
     * fire off he index action
     *
     * @return array
     */
    public function index()
    {


        $leftCatalogtMenu = (new Categories())->getLeftCataloglMenu();

        $catalogModel= new DB_Catalog();
        $catalogResults = $catalogModel->getCatalog();
        $manufacturersList = $catalogModel->getManufacturers();
        $pages = $catalogModel->countPages();


        return ['view'=>'customer/catalog.php', 'leftCatalogMenu' => $leftCatalogtMenu, 'catalogResults'=>$catalogResults,
        'manufacturersList' => $manufacturersList, 'pages' => $pages];
    }







}
