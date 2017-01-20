<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Admin_Carousel;
use \Lib\TokenService;
use App\Models\CheckForm;
use \Lib\CheckFieldsService;
use function noCarousel;


class AdminCarousels extends AdminController {

    use CheckFieldsService;

    public function __construct()
    {
        session_start();

        if(@$_SESSION['admin']['upgrading_status']<2){
            if (isset($_POST['ajax'])){
                echo json_encode(["message" => "you do not have permission to fire off the controller"]); exit();
            }
            header('Location: /admin');
        }

    }

    public function index($fullfilledAction = null, $id =null, $error = null )
    {

        $carousels = (new Admin_Carousel())->getCarousels();

        return ['view'=>'admin/carousels.php', 'carousels'=>$carousels, 'action'=> $fullfilledAction, 'id' => $id , 'error'=> $error ];
    }

    public function createCarouselsPopUpMenu()
    {
        return ['view'=>'admin/partials/createPopUpMenu.php', 'significant'=> 'carousel'  , 'ajax'=> true ];
    }


    public function create($error = null )
    {
        $_SESSION['makeCarousel'] = true;

        return  ['view' =>'admin/createCarousel.php', 'error' => $error  ];
    }


    public function store()
    {
        TokenService::check('prozessAdmin');

        if(@$_SESSION['makeCarousel']) {

            return $this->persistCarousel();
        }

        return $this->index();
    }


    public function edit($error = null )
    {
        $slider = (new Admin_Carousel())->getOneCarousel();
        $_SESSION['editCarousel'] = true;


        return  ['view' =>'admin/updateCarousel.php', 'theCarousel'=> $slider,  'error' => $error  ];
    }

    public function update()
    {
        TokenService::check('prozessAdmin');


        if(@$_SESSION['editCarousel']) {

            return $this->updateCarousel();
        }

        return $this->index();
    }





    public function createConfirmDeleteWindow()
    {
        $_SESSION['deleteCarousel'] = true;

        return ['view' =>'admin/partials/createConfirmDeleteWindow.php', 'significant'=> 'carousel'  , 'ajax'=>true ];
    }

    public function delete()
    {
        TokenService::check('prozessAdmin');
        if(!isset($_SESSION['deleteCarousel'])) return $this->index();

        $model = new Admin_Carousel();

        $model->deleteCarousel();
        return $this->index('carouselDeleted', $_POST['id']);

    }

    /**
     * @return array
     */
    private function persistCarousel()
    {
        $error = (new CheckForm())->checkIfNotEmptyList('carousel_url');

        if (@!$_SESSION['createCarousel']) $error['noCarousel'] = noCarousel();

        if ($error) return $this->create($error);

        $id = (new Admin_Carousel())->storeCarousel();
        return $this->index('carouselCreated', $id);
    }

    /**
     * @return array
     */
    private function updateCarousel()
    {
        $error = (new CheckForm())->checkIfNotEmptyList( 'carousel_url');
        if ($error) return $this->edit($error);
        (new Admin_Carousel())->updateCarousel();
        return $this->index('carouselUpdated', $_POST['id']);
    }


}