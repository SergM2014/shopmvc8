<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Index;
use App\Models\Categories;


class Contacts  extends BaseController
{
    /**
     * fire off he index action
     *
     * @return array
     */
    public function index()
    {

        $model= new DB_Index();

        $contactsInfo = $model->getContactsInfo();

        $carousel = $model->getCarousel();

        $categoriesVertMenu = (new Categories())->getVerticalMenu();

        $builder = $model->printCaptcha();

        return ['view'=>'customer/contacts.php', 'contactsInfo' => $contactsInfo, 'carousel'=>$carousel, 'categoriesVertMenu'=>$categoriesVertMenu, 'builder'=>$builder];
    }

    public function addMessage()
    {

        return ['view'=>'customer/partials/writeUsForm.php', 'ajax'=> true ];
    }




}