<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Index;
use App\Models\Categories;
use App\Models\CheckForm;


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

        $model= new DB_Index();

        $contactsInfo = $model->getContactsInfo();

        $carousel = $model->getCarousel();

        $categoriesVertMenu = (new Categories())->getVerticalMenu();


        $model2 = new CheckForm();

        $error = $model2->checkFields();

        if(!empty($error)) {
            $builder = (new DB_Index())->printCaptcha();
            return ['view' => 'customer/contacts.php', 'error' => $error, 'builder' => $builder, 'contactsInfo' => $contactsInfo, 'carousel'=>$carousel, 'categoriesVertMenu'=>$categoriesVertMenu,];
        }

        return ['view' => 'customer/contacts.php', 'success'=> true, 'contactsInfo' => $contactsInfo, 'carousel'=>$carousel, 'categoriesVertMenu'=>$categoriesVertMenu,];
    }




}