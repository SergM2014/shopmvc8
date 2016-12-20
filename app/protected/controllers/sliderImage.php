<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Admin_Slider;
use Lib\TokenService;

/**
 *
 * class for image upload/delete
 *
 * Class Image
 * @package App\Controllers
 */
class SliderImage extends BaseController
{

    public function upload()
    {
        TokenService::check('prozessAdmin');

        $message = (new Admin_Slider())->uploadImage();

        echo json_encode($message);
        exit();
    }


    public function delete()
    {
       TokenService::check('prozessAdmin');

        $message = (new Admin_Slider())->deleteImage();

        echo json_encode($message);
        exit();
    }

}

?>