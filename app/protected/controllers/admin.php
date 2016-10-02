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

        (new AdminModel)->getAdminUser();

      if(!isset($_SESSION['admin'])){
          return ['view'=>'admin/notAdmin.php'];
      }
        return ['view'=>'admin/admin.php'];

    }

    public function leave()
    {
        unset($_SESSION['admin']);
        return ['view'=>'admin/notAdmin.php'];
    }

}