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

    public function __construct($in_admin=false)
    {
        $this->amount = ($in_admin)? AMOUNTONPAGEADMIN: AMOUNTONPAGE;
        $this->page = (isset($_GET['p']))? $_GET['p']: 1;
        $this->category='';
        $this->manufacturer='';

        parent::__construct();
    }

    public function getCatalog()
    {

        $page= ($this->page-1)*$this->amount;
        $this->order='';


        if(isset($_GET['order'])) {
            switch($_GET['order']){
                case 'abc': $this->order=' ORDER BY `p`.`title` ASC'; break;
                case 'cba': $this->order=' ORDER BY `p`.`title` DESC'; break;
                case 'cheap_first': $this->order=' ORDER BY `p`.`price` ASC'; break;
                case 'expensive_first': $this->order= ' ORDER BY `p`.`price` DESC'; break;
                case 'default': $this->order= ' ORDER BY `p`.`title` ASC'; break;
            }
        }

        if(isset($_GET['category'])){
            $this->category = $this->conn->quote($_GET['category']);
            $this->category = "WHERE `c`.`title`=".$this->category." ";
            $conjunction =" AND";
        }

        if(isset($_GET['manufacturer'])){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($_GET['manufacturer']);
            $this->manufacturer = $conjunction."`m`.`title`=".$name." ";
        }

        $sql="SELECT `p`.`id` AS product_id , `p`.`author`, `p`.`title` as product_title , `p`.`description`, `p`.`body`,
              `p`.`price`, `p`.`cat_id` AS `product_cat_id`, `p`.`manf_id`, `p`.`images`, `c`.`id` AS `category_id`, `c`.`title` AS category_title , 
              `c`.`eng_translit_title`, `c`.`parent_id`, `m`.`id` as manufacturer_id , `m`.`originTitle` AS manufacturer_title
               FROM `products` `p` LEFT JOIN `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturers` `m` 
               ON `p`.`manf_id` = `m`.`id` ".$this->category.$this->manufacturer.$this->order."
               LIMIT ?, ".$this->amount;

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $page, \PDO::PARAM_INT);
        $stmt->execute();
        $result= $stmt->fetchAll();

//добавляем порядковый номер товарыв для вывода таблиць и розюыраемось з изображениямы
        foreach ($result as $key=> $value){
            $startingLineNumber =(!isset($startingLineNumber))? ($this->page-1)*$this->amount+1: $startingLineNumber+1;
            $result[$key]->startingLineNumber= $startingLineNumber;

            if(!empty($value->images) && $value->images!= false ){

                $images= unserialize($value->images);
                $result[$key]->images= array_values($images);
            }
        }

        return $result;
    }

    public function countPages()
    {

        if(isset($_GET['category'])){
            $this->category = $this->conn->quote($_GET['category']);
            $this->category = "WHERE `c`.`title`=".$this->category." ";
            $conjunction =" AND";
        }

        if(isset($_GET['manufacturer'])){
            if(!isset($conjunction)) { $conjunction = " WHERE ";} else {$conjunction = " AND "; }
            $name= $this->conn->quote($_GET['manufacturer']);
            $this->manufacturer = $conjunction."`m`.`title`=".$name." ";
        }

        $sql= "SELECT COUNT(`p`.`id`) AS number FROM `products` `p` LEFT JOIN
              `categories` `c` ON `p`.`cat_id` = `c`.`id` LEFT JOIN `manufacturers` `m` ON `p`.`id` = `m`.`id` ".$this->category.$this->manufacturer;
        $res= $this->conn->query($sql);
        $res= $res->fetch();
   // var_dump($res);
        $pages= ceil($res->number/$this->amount);

        return $pages;

    }

    public function getManufacturers(){
        $sql ="SELECT `id`, `translitedInEngTitle`, `originTitle` FROM `manufacturers`";
        $res= $this->conn->query($sql);
        $manufacturers= $res->fetchAll();
        return $manufacturers;
    }

}