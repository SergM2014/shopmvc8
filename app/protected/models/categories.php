<?php
/**
 * Created by PhpStorm.
 * User: s
 * Date: 09.08.16
 * Time: 12:15
 */

namespace App\Models;


use App\Core\DataBase;
use function \click_it;
use function \has_sub_categories;

class Categories extends DataBase
{
    private $categories;

    public  function __construct()
    {
        parent::__construct();

        $sql = "SELECT `id`, `title`, `parent_id`, `eng_translit_title` FROM `categories`";
        $result = $this->conn->query($sql);
        $categories = $result->fetchAll();

        $this->categories = $categories;
    }



    private function printOutMenu($parent = 0)
    {
static $suffix = 1;
        if(!isset($print)){$print=''; }

        foreach($this->categories as $category){
            if($category->parent_id ==$parent ){

                $print.='<li class="left-menu_li" data-category-id ='.$category->id.' data-parent-id='.$category->parent_id.'> <div class="left-menu__item  nested-'.$suffix.'"  ><a href="/categories?title='.$category->eng_translit_title.'" class="left-menu__link">'. $category->title .'</a>' ;

                foreach($this->categories as $sub_cat){
                    if($sub_cat->parent_id == $category->id){ $flag = TRUE; break; }
                }

                if(isset($flag)){
$suffix=$suffix+1;
                    $print.= "<img src='/img/arrow_down.png' alt='".has_sub_categories()."' title='".click_it()."' class='left-menu__contains-subcatetegories-sign'  > </div> <ul class='hidden'>";
                    $print.= $this->printOutMenu($category->id);
                    $print.= "</ul>";
                    $print.= "</li>";
                    $flag = null;
$suffix = $suffix-1;
                } else{
                    $print.="</div></li>";
                }
            }
        }
        return $print;
    }

    public function getVerticalMenu()
    {
        $leftMenu ="<ul class='left-menu__ul'>";
        $leftMenu.= $this->printOutMenu();
        $leftMenu.= "</ul>";
        return $leftMenu;
    }
}