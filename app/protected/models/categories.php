<?php
/**
 * Created by PhpStorm.
 * User: s
 * Date: 09.08.16
 * Time: 12:15
 */

namespace App\Models;


use App\Core\DataBase;

class Categories extends DataBase
{
    public $categories;

    public  function __construct()
    {
        parent::__construct();

        $sql = "SELECT `id`, `title`, `parent_id`, `eng_translit_title` FROM `categories`";
        $result = $this->conn->query($sql);
        $categories = $result->fetchAll();

        $this->categories = $categories;
    }

    public function getVerticalMenu($parent = 0)
    {
//die(var_dump($this->categories));

        foreach ($this->categories as $category) {
            if($category->parent_id == $parent){
                $print = '<li><span>'.$category->title.'</span>';
                foreach($this->categories as $sub_cat){
                    if($sub_cat->parent_id == $category->id){$flag = true; break;}
                }

                if($flag == true){
                    $print.='<ul>';
                    $print.= $this->getVerticalMenu($category->id);
                    $print.= '<ul>';
                    $print.= '<li>';
                }
            }//end if
        }//end foreach
        return $print;
    }
}