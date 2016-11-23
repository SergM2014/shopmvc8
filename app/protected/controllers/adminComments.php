<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\AdminModel;
use App\Models\DB_Index;
use Lib\TokenService;
use App\Models\CheckForm;

use App\Models\Admin_Comment;

class AdminComments extends AdminController {

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
        TokenService::check('prozess_comment');

        $result = (new DB_Index)->unpublishAll($_POST['checked']);

        echo json_encode($result); exit();
    }

    public function publish()
    {
        TokenService::check('prozessAdmin');

       if(!(new Admin_Comment())->publish()) return $this->index();

       return $this->index('commentPublished', $_POST['id']);

    }

    public function getOneComment()
    {
        $comment = (new DB_Index)-> getOneComment();
        return ['view'=> 'admin/partials/update_comment_form.php', 'comment'=> $comment, 'ajax'=>true ];
    }

    public function updateComment()
    {
        TokenService::check('prozess_comment');
        $model = new CheckForm;
        $error_response = $model->ifCommentNotEmpty();
        if (@ $error_response) {
            echo json_encode($error_response); exit();
        }

        $response = $model->updateComment();

        echo json_encode($response); exit();
    }

    public function getUpdatedComment()
    {
        $comment = (new DB_Index)-> getOneComment();
        return ['view'=> 'admin/partials/updated_comment_table_row.php', 'comment'=> $comment, 'ajax'=>true ];
    }


}