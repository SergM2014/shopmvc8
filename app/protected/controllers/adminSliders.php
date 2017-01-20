<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\Admin_Slider;
use \Lib\TokenService;
use App\Models\CheckForm;
use \Lib\CheckFieldsService;
use function noSlider;


class AdminSliders extends AdminController {

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

        $sliders = (new Admin_Slider())->getSliders();

        return ['view'=>'admin/sliders.php', 'sliders'=>$sliders, 'action'=> $fullfilledAction, 'id' => $id , 'error'=> $error ];
    }

    public function createslidersPopUpMenu()
    {
        return ['view'=>'admin/partials/createPopUpMenu.php', 'significant'=>'slider', 'ajax'=> true ];
    }


    public function create($error = null )
    {
        $_SESSION['makeSlider'] = true;

        return  ['view' =>'admin/createSlider.php', 'error' => $error  ];
    }


    public function store()
    {
        TokenService::check('prozessAdmin');

        if(@$_SESSION['makeSlider']) {

            return $this->persistSlider();
        }

        return $this->index();
    }


    public function edit($error = null )
    {
        $slider = (new Admin_Slider())->getOneSlider();
        $_SESSION['editSlider'] = true;


        return  ['view' =>'admin/updateSlider.php', 'theSlider'=> $slider,  'error' => $error  ];
    }

    public function update()
    {
        TokenService::check('prozessAdmin');


        if(@$_SESSION['editSlider']) {

            return $this->updateSlider();
        }

        return $this->index();
    }





    public function createConfirmDeleteWindow()
    {
        $_SESSION['deleteSlider'] = true;

        return ['view' =>'admin/partials/createConfirmDeleteWindow.php', 'significant'=>'slider', 'ajax'=>true ];
    }

    public function delete()
    {
        TokenService::check('prozessAdmin');
        if(!isset($_SESSION['deleteSlider'])) return $this->index();

        $model = new Admin_Slider();

        $model->deleteSlider();
        return $this->index('sliderDeleted', $_POST['id']);

    }

    /**
     * @return array
     */
    private function persistSlider()
    {
        $error = (new CheckForm())->checkIfNotEmptyList('slider_title', 'slider_url');

        if (@!$_SESSION['createSlider']) $error['noSlider'] = noSlider();

        if ($error) return $this->create($error);

        $id = (new Admin_Slider())->storeSlider();
        return $this->index('sliderCreated', $id);
    }

    /**
     * @return array
     */
    private function updateSlider()
    {
        $error = (new CheckForm())->checkIfNotEmptyList('slider_title', 'slider_url');
        if ($error) return $this->edit($error);
        (new Admin_Slider())->updateSlider();
        return $this->index('sliderUpdated', $_POST['id']);
    }





}