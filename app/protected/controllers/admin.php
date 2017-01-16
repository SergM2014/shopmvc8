<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AdminModel;
use Lib\TokenService;


class Admin  extends BaseController
{

    public function index()
    {
        TokenService::checkAdmin('enterAdmin');
        $adminModel = new AdminModel();
        $adminModel->getAdminUser();


      if(!isset($_SESSION['admin'])){

          return ['view'=>'admin/notAdmin.php'];
      }
        //delete unnecessary images
        $adminModel->removeUnnecessaryImages();
        return ['view'=>'admin/admin.php'];

    }

    public function leave()
    {
        unset($_SESSION['admin']);
        return ['view'=>'admin/notAdmin.php'];
    }

}