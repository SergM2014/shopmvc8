<?php


namespace App\Models;


use App\Core\DataBase;
use function \empty_field;

class Admin_Product extends DataBase
{

    public function checkIfNotEmpty($updatedProduct)
    {
        $fieldsArray=['author', 'title', 'price', 'description', 'body', 'manufacturer_id', 'category_id'];
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
        $stmt->bindValue(6, $_POST['category_id'], \PDO::PARAM_INT);
        $stmt->bindValue(7, $_POST['manufacturer_id'], \PDO::PARAM_INT);
        $stmt->bindValue(8, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

    }

    public function addProductsImages()
    {
        $sql = "INSERT INTO images (`product_id`, `image`) VALUES (?, ? )";
        $stmt = $this->conn->prepare($sql);

        foreach ($_SESSION['images'] as $image) {

            $stmt->bindValue(1, $_POST['id']);
            $stmt->bindValue(2, $image);
            $stmt->execute();
        }

       // unset($_SESSION['images']);
    }

    public function removeProductsImages()
    {
        $sql = "DELETE FROM `images` WHERE `image`=?";
        $stmt = $this->conn->prepare($sql);

        foreach (@$_SESSION['deleteImageList'] as $image) {

            $stmt->bindValue(1, $image, \PDO::PARAM_STR);

            $stmt->execute();
        }

        unset($_SESSION['images']);
        unset($_SESSION['deleteImageList']);
    }

}