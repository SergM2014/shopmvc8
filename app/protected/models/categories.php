<?php


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


    public function getVerticalMenu()
    {
        $leftMenu ="<ul class='left-menu__ul'>";
        $leftMenu.= $this->printOutLeftMenu();
        $leftMenu.= "</ul>";
        return $leftMenu;
    }


//для выпадающего меню
    private function printOutLeftMenu($parent = 0)
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
                    $print.= $this->printOutLeftMenu($category->id);
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



    public function getLeftCataloglMenu()
    {
        $leftMenu ="<ul class='left-catalog-menu'>";
        $leftMenu.= $this->printOutlLeftCatalogMenu();
        $leftMenu.= "</ul>";
        return $leftMenu;
    }


    protected function printOutlLeftCatalogMenu(  $parent = 0)
    {
        if(!isset($print)){$print='';}
        foreach($this->categories as $category){
            if($category->parent_id ==$parent ){

                $print.='<li  class="left-catalog-menu__item"><a href="'.URL.'catalog?category='. $category->eng_translit_title .'" class="left-catalog-menu__link">'.$category->title.'</a>' ;
                foreach($this->categories as $sub_cat){
                    if($sub_cat->parent_id == $category->id){
                        $flag = TRUE; break;
                    }
                }

                if(isset($flag)){
                    $print.= "<ul>";
                    $print.= $this->printOutlLeftCatalogMenu( $category->id);
                    $print.= "</ul>";
                    $print.= "</li>";
                } else{
                    $print.="</li>";
                }
            }
        }
        return $print;
    }







// dropdown categories menu in admin part
    protected function printOutDropDownMenu( $parent=0)
    {
        static $suffix = 1;
        if(!isset($print)){$print='';}
        foreach($this->categories as $category){
            if($category->parent_id ==$parent ){

                $print.="<option class='drop-down-menu-item  nested-$suffix' value='$category->eng_translit_title' >$category->title</option>" ;
                foreach($this->categories as $sub_cat){
                    if($sub_cat->parent_id == $category->id){
                        $flag = TRUE; break;
                    }
                }

                if(isset($flag)){
                    $suffix++;
                    $print.= $this->printOutDropDownMenu( $category->id);
                    $print.= "</option>";
                    $suffix--;
                } else{
                    $print.="</option>";
                }
            }
        }
        return $print;
    }

    public function getDropDownMenu()
    {
        $dropDownMenu ="<select class='categories-drop-down-menu'>";
        $dropDownMenu.="<option></option>";
        $dropDownMenu.= $this->printOutDropDownMenu();
        $dropDownMenu.= "</select>";

        return $dropDownMenu;
    }




}