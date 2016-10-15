<?php


namespace App\Models;


use App\Core\DataBase;
use function \empty_field;

class Admin_Product extends DataBase
{

    public function checkIfNotEmpty($updatedProduct)
    {
        $fieldsArray=['author', 'title', 'price', 'description', 'body', 'manufacturer', 'category'];
        $error= [];


        foreach ($fieldsArray as $item){
            if(strlen($_POST[$item])<1) $error[$item]= empty_field();
            $updatedProduct->$item = $_POST[$item];
        }


        return $error;
    }

    public function updateProduct()
    {
        $sql = "UPDATE `products` SET `author`=?, `title`=?, `description`=?, `body`=?, `price`=?, `cat_id`=?, `manf_id`=? WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['author'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['title'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['description'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['body'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $_POST['price'], \PDO::PARAM_STR);
        $stmt->bindValue(6, $_POST['category'], \PDO::PARAM_INT);
        $stmt->bindValue(7, $_POST['manufacturer'], \PDO::PARAM_INT);
        $stmt->bindValue(8, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

    }

}