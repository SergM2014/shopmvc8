<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Carousel_Images;
use Lib\TokenService;

/**
 *
 * class for image upload/delete
 *
 * Class Image
 * @package App\Controllers
 */
class CarouselImage extends BaseController
{

    public function upload()
    {
        TokenService::check('prozessAdmin');

        $message = (new Carousel_Images())->uploadImage();

        echo json_encode($message);
        exit();
    }


    public function delete()
    {
       TokenService::check('prozessAdmin');

        $message = (new Carousel_Images())->deleteImage();

        echo json_encode($message);
        exit();
    }

}

?>