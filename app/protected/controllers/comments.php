<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\CheckForm;
use App\Models\DB_Index;
use App\Models\DB_Product;



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
        $model = new DB_Product();
        $result = $model->getComments();

        return ['view'=>'customer/partials/orderedComments.php','productComments'=>$result, 'ajax'=>true ];
    }

    /**
     * check the correct fulfillment of input fields
     *
     * @return Response
     */
    public function addComment()
    {
        $model = new CheckForm;
        $error = $model->checkFields();//checkIfNotEmpty();
        if (!empty($error)) {

            $model = new DB_Product();
            $productInfo = $model->getProduct();
            $productComments = $model->getComments();
            $builder = (new DB_Index)->printCaptcha();
            return ['view' => 'customer/product/show.php', 'error' => $error, 'productInfo'=> $productInfo, 'productComments' => $productComments, 'builder' => $builder, 'data' => $_POST];
        }

        $model->insertComment();
        return ['view' => 'customer/commentAdded.php', 'success' => true];

    }

}