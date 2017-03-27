<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\AdminModel;
use App\Models\DB_Index;
use Lib\TokenService;
use App\Models\CheckForm;

use App\Models\Admin_Comment;

class AdminComments extends AdminController {

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

    public function index($fullfilledAction = null, $id =null )
    {
        extract(($this->getCommentsResults()));

        return ['view'=> 'admin/comments.php', 'results'=>$results, 'pages'=>$pages, 'loop_counter'=>$loop_counter,
            'action'=> $fullfilledAction, 'id' => $id ];
    }

    public function refresh()
    {
        extract(($this->getCommentsResults()));

        return ['view'=> 'admin/partials/commentsList.php', 'results'=>$results, 'pages'=>$pages, 'loop_counter'=>$loop_counter, 'ajax' => true ];
    }


    private function getCommentsResults()
    {
        $model = new Admin_Comment;
        $comments['results'] = $model->getAllComments();
        $comments['pages'] = $model->countAdminCommentsPages();
        $comments['loop_counter'] = (new AdminModel)->getLoopCounter();
        return $comments;
    }

    public function createCommentsPopUpMenu()
    {

        return ['view' =>'admin/partials/createCommentsPopUpMenu.php', 'ajax'=>true ];
    }


    public function unpublish()
    {
        TokenService::check('prozessAdmin');

        if(!(new Admin_Comment())->unpublish()) return $this->index();

        return $this->index('commentUnpublished', $_POST['id']);
    }

    public function publish()
    {
        TokenService::check('prozessAdmin');

       if(!(new Admin_Comment())->publish()) return $this->index();

       return $this->index('commentPublished', $_POST['id']);

    }

    public function edit($error = null)
    {
        $comment = (new Admin_Comment())->getOneComment();

        $_SESSION['edit'] = true;

        return ['view'=>'admin/updateComment.php', 'comment'=>$comment , 'error' => $error];
    }



    public function update()
    {
        TokenService::check('prozessAdmin');
        $error = (new CheckForm())->checkIfNotEmptyList('comment');
        if ( $error) return   $this->edit($error);


        if(@$_SESSION['edit']) {
           (new Admin_Comment())->update();
           return $this->index('commentChanged', $_POST['id']);
        }

       return $this->index();
    }




}