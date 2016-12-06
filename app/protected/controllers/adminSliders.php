<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Admin_Slider;
use \Lib\TokenService;
use App\Models\CheckForm;
use \Lib\CheckFieldsService;


class AdminSliders extends AdminController {

    use CheckFieldsService;

    public function index($fullfilledAction = null, $id =null, $error = null )
    {
        $sliders = (new Admin_Slider())->getSliders();

        return ['view'=>'admin/sliders.php', 'sliders'=>$sliders, 'action'=> $fullfilledAction, 'id' => $id , 'error'=> $error ];
    }

    public function createManufacturersPopUpMenu()
    {
        return ['view'=>'admin/partials/createManufacturersPopUpMenu.php', 'ajax'=> true ];
    }


    public function create($error = null )
    {
        $_SESSION['createManufacturer'] =true;

        $title = $this->stripTags(@$_POST['manufacturer_title']);
        $url = $this->stripTags(@$_POST['manufacturer_url']);

        return  ['view' =>'admin/createManufacturer.php', 'error' => $error , 'title' => $title, 'url' => $url ];
    }


    public function store()
    {
        TokenService::check('prozessAdmin');
        $model = new CheckForm;
        $error['title'] = $model->ifManufacturerTitleEmpty() ;
        $error['url'] = $model->ifManufacturerUrlEmpty() ;



        if ( $error['title'] !== false OR $error['url'] !== false) return   $this->create($error);


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

        $title = $this->stripTags(@$_POST['manufacturer_title']);
        $url = $this->stripTags(@$_POST['manufacturer_url']);

        return  ['view' =>'admin/updateManufacturer.php', 'manufacturer'=> $manufacturer,  'error' => $error, 'title'=>$title, 'url'=>$url  ];
    }

    public function update()
    {
        TokenService::check('prozessAdmin');
        $model = new CheckForm;
        $error['title'] = $model->ifManufacturerTitleEmpty() ;
        $error['url'] = $model->ifManufacturerUrlEmpty() ;

        if ( $error['title'] !== false OR $error['url'] !== false) return   $this->edit($error);

        if(@$_SESSION['editManufacturer']) {
            (new Admin_Manufacturer())->updateManufacturer();
            return $this->index('manufacturerUpdated', $_POST['id']);
        }

        return $this->index();
    }





    public function creteConfirmDeleteWindow()
    {
        $_SESSION['deleteManufacturer'] = true;

        return ['view' =>'admin/partials/createConfirmDeleteManufacturerWindow.php', 'ajax'=>true ];
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