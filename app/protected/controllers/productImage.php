<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Images;
use Lib\TokenService;

/**
 *
 * class for image upload/delete
 *
 * Class Image
 * @package App\Controllers
 */
class ProductImage extends BaseController
{

    public function upload()
    {
        TokenService::check('prozessAdmin');

        $model = new Images;
        $message = $model->uploadImage();

        echo json_encode($message);
       exit();
    }


    public function delete()
    {
       TokenService::check('prozessAdmin');

        $model = new Images;
        $message = $model->deleteImage();

        echo json_encode($message);
        exit();
    }

}

?>