<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\AdminModel;
use Lib\TokenService;


class Admin  extends BaseController
{

    public function index()
    {
        TokenService::checkAdmin('enter_admin');
        (new AdminModel)->getAdminUser();


      if(!isset($_SESSION['admin'])){
          return ['view'=>'admin/not_admin.php'];
      }
        return ['view'=>'admin/enter_admin.php'];

    }

    public function out()
    {
        unset($_SESSION['admin']);
        return ['view'=>'admin/not_admin.php'];
    }

}