<?php

namespace App\Controllers;

use App\Core\AdminController;
use App\Models\AdminModel;
use App\Models\DB_Index;
use Lib\TokenService;
use App\Models\CheckForm;

class Admincomments extends AdminController {

    public function index()
    {
        extract(($this->getCommentsResults()));

        return ['view'=> 'admin/index.php', 'results'=>$results, 'pages'=>$pages, 'loop_counter'=>$loop_counter];
    }

    public function paginate()
    {
        extract(($this->getCommentsResults()));

        return ['view'=>'admin/partials/comments_list.php', 'results'=>$results, 'pages'=>$pages, 'loop_counter'=>$loop_counter, 'ajax'=> true ];
    }

    private function getCommentsResults()
    {
        $model = new DB_Index;
        $comments['results'] = $model->getAdminCommentsResult();
        $comments['pages'] = $model->countAdminCommentsPages();
        $comments['loop_counter'] = (new AdminModel)->getLoopCounter();
        return $comments;
    }

    public function publish()
    {
        TokenService::check('prozess_comment');
        $result = (new DB_Index)->publishAll($_POST['checked']);

       echo json_encode($result); exit();
    }

    public function unpublish()
    {
        TokenService::check('prozess_comment');

        $result = (new DB_Index)->unpublishAll($_POST['checked']);

        echo json_encode($result); exit();
    }

    public function deleteItems()
    {
        TokenService::check('prozess_comment');

        $result = (new DB_Index)->deleteAll($_POST['checked']);

        echo json_encode($result); exit();
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