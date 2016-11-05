<?php


namespace App\Models;


use App\Core\DataBase;
use function \empty_field;

class Admin_Product extends DataBase
{

    public function checkIfNotEmpty($product)
    {
        $fieldsArray=['author', 'title', 'price', 'description', 'body', 'manufacturer_id', 'category_id'];
        $error= [];

        foreach ($fieldsArray as $item){
            if(strlen($_POST[$item])<1) $error[$item]= empty_field();
            $product->$item = $_POST[$item];
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


    public function addProduct()
    {
        $sql = "INSERT INTO `products` (`author`, `title`, `description`, `body`, `price`, `cat_id`, `manf_id`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['author'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['title'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['description'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['body'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $_POST['price'], \PDO::PARAM_STR);
        $stmt->bindValue(6, $_POST['category_id'], \PDO::PARAM_INT);
        $stmt->bindValue(7, $_POST['manufacturer_id'], \PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }




    public function addProductsImages($addedProductId = null)
    {
        if(!isset($_SESSION['images'])) return;

        $id = $addedProductId ?? $_POST['id'];

        $sql = "INSERT INTO images (`product_id`, `image`) VALUES (?, ? )";
        $stmt = $this->conn->prepare($sql);

        foreach ($_SESSION['images'] as $image) {

            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $image);
            $stmt->execute();
        }

        unset($_SESSION['images']);
    }

    public function removeProductsImages()
    {
        if(!isset($_SESSION['deleteImageList'])) return;
        $sql = "DELETE FROM `images` WHERE `image`=?";
        $stmt = $this->conn->prepare($sql);

        foreach ($_SESSION['deleteImageList'] as $image) {

            $stmt->bindValue(1, $image, \PDO::PARAM_STR);

            $stmt->execute();
        }

        unset($_SESSION['images']);
        unset($_SESSION['deleteImageList']);
    }

    public function sortImagesSequence(){
        $arr = explode(',', $_POST['imagesSort']);
        $sortedArr = [];
        foreach($arr as $key => $value){
            $sortedArr[$key+1] = $value;
        }

       $sql = "UPDATE `images` SET `sequence_number` = ? WHERE `image` = ?";
        $stmt = $this->conn->prepare($sql);
        foreach($sortedArr as $key =>$value){
            $stmt->bindValue(1, $key, \PDO::PARAM_INT);
            $stmt->bindValue(2, $value, \PDO::PARAM_INT);
            $stmt->execute();
        }

    }

    public function getCategoryAndManufacturerInfo($product)
    {

        $sql = "SELECT `id` , `title` FROM `categories` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['category_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $cat = $stmt->fetch();

        $sql = "SELECT `id`, `title` FROM `manufacturers` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['manufacturer_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $manf = $stmt->fetch();

        $product->cat_id = $cat->id;
        $product->category_title = $cat->title;
        $product->manf_id = $manf->id;
        $product->manf_title = $manf->title;

    }

    public function deleteProduct()
    {
        $sql = "DELETE FROM `products` WHERE `id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
//owing toe goreign key images are deleting myself
        /*$sql = "DELETE FROM `images` WHERE `product_id` = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();*/
    }

}