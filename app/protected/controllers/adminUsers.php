<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\AdminModel;
use App\Models\CheckForm;
use \Lib\TokenService;



class AdminUsers extends AdminController {

    use \Lib\CheckFieldsService;

    public function __construct()
    {
        session_start();

        if(@$_SESSION['admin']['upgrading_status']<3){
            if (isset($_POST['ajax'])){
                echo json_encode(["message" => "you do not have permission to fire off the controller"]); exit();
            }
            header('Location: /admin');
        }

    }

    public function index($fullfilledAction = null, $id =null, $error = null )
    {

        $users = (new AdminModel())->getUsers();

        return ['view'=>'admin/users.php', 'usersList'=>$users, 'action'=> $fullfilledAction, 'id' => $id , 'error'=> $error ];
    }

    public function createUsersPopUpMenu()
    {
        return ['view'=>'admin/partials/createPopUpMenu.php', 'significant'=> 'user'  , 'ajax'=> true ];
    }


    public function create($error = null )
    {
        $_SESSION['makeUser'] = true;

        return  ['view' =>'admin/createUser.php', 'error' => $error  ];
    }


    public function store()
    {
        TokenService::check('prozessAdmin');

        if(@$_SESSION['makeUser']) {

            return $this->persistUser();
        }

        return $this->index();
    }


    public function edit($error = null )
    {

        $theUser = (new AdminModel())->getOneUser();
        $_SESSION['editUser'] = true;


        return  ['view' =>'admin/updateUser.php', 'theUser' => $theUser, 'error' => $error  ];
    }

    public function update()
    {
        TokenService::check('prozessAdmin');


        if(@$_SESSION['editUser']) {

            return $this->updateUser();
        }

        return $this->index();
    }





    public function createConfirmDeleteWindow()
    {
        $_SESSION['deleteUser'] = true;

        return ['view' =>'admin/partials/createConfirmDeleteWindow.php', 'significant'=> 'user'  , 'ajax'=>true ];
    }

    public function delete()
    {
        TokenService::check('prozessAdmin');
        if(!isset($_SESSION['deleteUser'])) return $this->index();

        (new AdminModel())->deleteUser();
        return $this->index('userDeleted', $_POST['id']);

    }

    /**
     * @return array
     */
    private function persistUser()
    {
        $checkFormModel = new CheckForm();
        $error = $checkFormModel->checkIfNotEmptyList('user_name', 'user_password', 'user_password2');

        if ($error) return $this->create($error);

        $error = $checkFormModel->deal2PasswordsFields();
        if ($error) return $this->create($error);

        $id = (new AdminModel())->storeUser();
        return $this->index('userCreated', $id);
    }

    /**
     * @return array
     */
    private function updateUser()
    {
        $checkFormModel = new CheckForm();
        $error = $checkFormModel->checkIfNotEmptyList( 'user_name');
        if ($error) return $this->edit($error);

        if(@!empty($_POST['user_password'])){
            $error = $checkFormModel->deal2PasswordsFields();
            if ($error) return $this->edit($error);
        }


        (new AdminModel())->updateUser();
        return $this->index('userUpdated', $_POST['id']);
    }


}