<?php
/**
 * Created by PhpStorm.
 * User: s
 * Date: 04.09.16
 * Time: 9:53
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\DB_Search;


class Search extends BaseController
{
    public function index()
    {
        $model = new DB_Search();
        $searchResults = $model->index();

        return ['view'=>'customer/searchResults.php', 'searchResults'=> $searchResults,  'ajax' => true];
    }
}