<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Avatar;
use Lib\TokenService;

/**
 *
 * class for image upload/delete
 *
 * Class Image
 * @package App\Controllers
 */
class Image extends BaseController
{

    public function upload()
    {
        TokenService::check('prozessAvatar');

        $model = new Avatar;
        $message = $model->uploadAvatar();

        echo json_encode($message);
       exit();
    }


    public function delete()
    {
       TokenService::check('prozessAvatar');

        $model = new Avatar;
        $message = $model->deleteAvatar();

        echo json_encode($message);
        exit();
    }

}

?>