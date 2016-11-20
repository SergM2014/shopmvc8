<?php

namespace App\Models;

use App\Core\DataBase;


class DB_Catalog extends DataBase
{
    private $amount;
    private $page;
    private $order;
    private $category;
    private $manufacturer;

    public function __construct($inAdmin = false)
    {
        $this->amount = ($inAdmin)? AMOUNTONPAGEADMIN: AMOUNTONPAGE;
        $this->page = $_GET['p']?? $_POST['p']?? 1;
        $this->category='';
        $this->manufacturer='';

        parent::__construct();
    }

    public function getCatalog()
    {

        $page= ($this->page-1)*$this->amount;
        $this->order='';


        $order= $_GET['order']?? $_POST['order']?? null;

        $category = $_GET['category']?? $_POST['category']?? null;
        $manufacturer= $_GET['manufacturer']?? $_POST['manufacturer']?? null;



            switch( @ $order){
                case 'abc': $this->order=' ORDER BY `p`.`title` ASC'; break;
                case 'cba': $this->order=' ORDER BY `p`.`title` DESC'; break;
                case 'cheap_first': $this->order=' ORDER BY `p`.`price` ASC'; break;
                case 'expensive_first': $this->order= ' ORDER BY `p`.`price` DESC'; break;
                default: $this->order= ' ORDER BY `p`.`title` ASC'; break;
            }


        if(isset($category)){
            $this->category = $this->conn->quote($category);

            $this->category = "WHERE `c`.`eng_translit_title`=".$this->category." ";
            $conjunction =" AND";
        }

        if(isset($manufacturer)){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($manufacturer);

            $this->manufacturer = $conjunction."`m`.`eng_translit_title`=".$name." ";
        }

        $sql="SELECT `p`.`id` AS product_id , `p`.`author`, `p`.`title` as product_title , `p`.`description`, `p`.`body`,
              `p`.`price`, `p`.`cat_id` AS `product_cat_id`, `p`.`manf_id`,  `c`.`id` AS `category_id`, `c`.`title` AS category_title , 
              `c`.`eng_translit_title`, `c`.`parent_id`, `m`.`id` as manufacturer_id , `m`.`title` AS manufacturer_title , GROUP_CONCAT(`im`.`image`) AS `images`
               FROM `products` `p` LEFT JOIN `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturers` `m` 
               ON `p`.`manf_id` = `m`.`id`
                LEFT JOIN `images` `im` ON `p`.`id`= `im`.`product_id`
                $this->category $this->manufacturer GROUP BY `p`.`id` $this->order LIMIT ?, $this->amount  " ;

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $page, \PDO::PARAM_INT);
        $stmt->execute();

        $result= $stmt->fetchAll();

//добавляем порядковый номер товарыв для вывода таблиць // и розюыраемось з изображениямы
        foreach ($result as $key=> $value){
            $startingLineNumber =(!isset($startingLineNumber))? ($this->page-1)*$this->amount+1: $startingLineNumber+1;
            $result[$key]->startingLineNumber= $startingLineNumber;

            if(!empty($value->images) && $value->images!= false ){

                $images= explode(',', $value->images);

                $result[$key]->images= array_values($images);

            }
        }

        return $result;
    }

    public function countPages()
    {
        $category = $_GET['category']?? $_POST['category']?? null;
        $manufacturer= $_GET['manufacturer']?? $_POST['manufacturer']?? null;

        if(isset($category)){
            $this->category = $this->conn->quote($category);
            $this->category = "WHERE `c`.`title`=".$this->category." ";
            $conjunction =" AND";
        }

        if(isset($manufacturer)){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($manufacturer);
            $this->manufacturer = $conjunction."`m`.`title`=".$name." ";
        }

        $sql= "SELECT COUNT(`p`.`id`) AS number FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturers` `m` ON `p`.`id` = `m`.`id`$this->category $this->manufacturer";
        $res= $this->conn->query($sql);
        $res= $res->fetch();
   
        $pages= ceil($res->number/$this->amount);

        return $pages;

    }

    public function getManufacturers(){
        $sql ="SELECT `id`, `eng_translit_title`, `title` FROM `manufacturers`";
        $res= $this->conn->query($sql);
        $manufacturers= $res->fetchAll();
        return $manufacturers;
    }

}