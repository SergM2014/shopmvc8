<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Admin_Manufacturer;
use \Lib\TokenService;
use App\Models\CheckForm;
use \Lib\CheckFieldsService;


class AdminManufacturers extends AdminController {

    use CheckFieldsService;

    public function index($fullfilledAction = null, $id =null, $error = null )
    {
        $manufacturers = (new Admin_Manufacturer())->getManufacturers();

        return ['view'=>'admin/manufacturers.php', 'manufacturers'=>$manufacturers, 'action'=> $fullfilledAction, 'id' => $id , 'error'=> $error ];
    }

    public function createManufacturersPopUpMenu()
    {
        return ['view'=>'admin/partials/createPopUpMenu.php', 'significant' =>'manufacturer', 'ajax'=> true ];
    }


    public function create($error = null )
    {
        $_SESSION['createManufacturer'] =true;

        return  ['view' =>'admin/createManufacturer.php', 'error' => $error  ];
    }


    public function store()
    {
        TokenService::check('prozessAdmin');

        $errors = (new CheckForm())->checkIfNotEmptyList('manufacturer_title', 'manufacturer_url');

        if(@$errors) return $this->create($errors);

        if(@$_SESSION['createManufacturer']) {

            $id = (new Admin_Manufacturer())->storeManufacturer();
            return $this->index('manufacturerCreated', $id);
        }

        return $this->index();
    }


    public function edit($error = null )
    {
        $manufacturer = (new Admin_Manufacturer())->getOneManufacturer();
        $_SESSION['editManufacturer'] = true;

        return  ['view' =>'admin/updateManufacturer.php', 'manufacturer'=> $manufacturer,  'error' => $error ];
    }

    public function update()
    {
        TokenService::check('prozessAdmin');
        $errors = (new CheckForm())->checkIfNotEmptyList('manufacturer_title', 'manufacturer_url');

        if ( @$errors) return   $this->edit($errors);

        if(@$_SESSION['editManufacturer']) {
            (new Admin_Manufacturer())->updateManufacturer();
            return $this->index('manufacturerUpdated', $_POST['id']);
        }

        return $this->index();
    }





    public function createConfirmDeleteWindow()
    {
        $_SESSION['deleteManufacturer'] = true;

        return ['view' =>'admin/partials/createConfirmDeleteWindow.php', 'significant' =>'manufacturer', 'ajax'=>true ];
    }

    public function delete()
    {
        TokenService::check('prozessAdmin');
        if(!isset($_SESSION['deleteManufacturer'])) return $this->index();

        $model = new Admin_Manufacturer();

        $error = $model ->findProductsInIt();

        if($error)  return $this->index('manufacturerHasProducts', null, 'error');


        $model->deleteManufacturer();
        return $this->index('manufactureryDeleted', $_POST['id']);

    }
   


}