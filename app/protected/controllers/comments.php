<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CheckForm;
use App\Models\DB_Index;
use Lib\TokenService;


class Comments  extends BaseController
{
    /**
     *
     * reorder the comment list
     *
     * @return array
     */
    public function reorder()
    {
        $model = new DB_Index;
        $result = $model->getResult();
        $pages = $model->getPublishedPages();

        return ['view'=>'customer/partials/comments_list.php','result'=>$result, 'pages'=> $pages, 'ajax'=>true ];
    }

    /**
     * chec the correct fulfillment of input fields
     * in error case reloud the form with errors
     * in case of sucess reload success mesage
     *
     * @return Response
     */
    public function addComment()
    {
        TokenService::check('add_comment');

        $model = new CheckForm;
        $error = $model->checkFields();//checkIfNotEmpty();
        if (!empty($error)) {
            $builder = (new DB_Index)->printCaptcha();
            return ['view' => 'customer/partials/comment_form.php', 'error' => $error, 'builder' => $builder, 'data' => $_POST, 'ajax' => true];
        }

        $model->insertComment();
        return ['view' => 'customer/partials/succeeded_comment.php', 'ajax' => true];

    }

}