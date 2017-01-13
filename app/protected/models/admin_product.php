<?php


namespace App\Models;


use App\Core\DataBase;
use Lib\CheckFieldsService;
use function \empty_field;

class Admin_Product extends DataBase
{

    use CheckFieldsService;


    public function checkIfNotEmpty($product)
    {
        $fieldsArray=['author', 'title', 'price', 'description', 'body', 'manufacturer_id', 'category_ids'];
        $error= [];

        foreach ($fieldsArray as $item){
            if(strlen($_POST[$item])<1) $error[$item]= empty_field();
            $product->$item = $_POST[$item];
        }


        return $error;
    }

    public function addProduct()
    {
        $_POST['description'] = self::stripTags($_POST['description']);
        $_POST['body'] = self::stripTags($_POST['body']);


        $addedProductId = $this->addProductInDb();
        $this->addCategoriesInDb($addedProductId);
        $this->addProductsImages($addedProductId);

        if(!empty($_POST['imagesSort'])) $this->sortImagesSequence();

        return $addedProductId;
    }

    protected function addProductInDb()
    {
        $sql = "INSERT INTO `products` (`author`, `title`, `description`, `body`, `price`, `manf_id`) VALUES (?,  ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['author'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['title'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['description'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['body'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $_POST['price'], \PDO::PARAM_STR);
        $stmt->bindValue(6, $_POST['manufacturer_id'], \PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    protected function addCategoriesInDb($addedProductId)
    {
        $ids = explode(',', $_POST['category_ids']);
        $sql = "INSERT INTO `products_categories` (`product_id`, `category_id`) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);

        foreach ($ids as $id){
            $stmt ->bindValue(1, $addedProductId, \PDO::PARAM_INT);
            $stmt ->bindValue(2, $id, \PDO::PARAM_INT);
            $stmt ->execute();
        }
    }


    public function updateProduct()
    {
        $_POST['description'] = self::stripTags($_POST['description']);
        $_POST['body'] = self::stripTags($_POST['body']);

        $this->updateProductInDb();
        $this->updateProductCategories();
        $this->addProductsImages();
        $this->removeProductsImages();
        if(!empty($_POST['imagesSort'])) $this->sortImagesSequence();
    }


    protected function updateProductInDb()
    {
        $sql = "UPDATE `products` SET `author`=?, `title`=?, `description`=?, `body`=?, `price`=?,  `manf_id`=? WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['author'], \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['title'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['description'], \PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['body'], \PDO::PARAM_STR);
        $stmt->bindValue(5, $_POST['price'], \PDO::PARAM_STR);
        $stmt->bindValue(6, $_POST['manufacturer_id'], \PDO::PARAM_INT);
        $stmt->bindValue(7, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

    }

    protected function updateProductCategories()
    {
        $sql = "DELETE from `products_categories` WHERE `product_id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $categoryIds= explode(',', $_POST['category_ids']);
        $sql= "INSERT INTO `products_categories` (`product_id`, `category_id`) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        foreach($categoryIds as $id){
            $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
            $stmt->bindValue(2, $id, \PDO::PARAM_INT);
            $stmt->execute();
        }


    }


    protected function addProductsImages($addedProductId = null)
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

    protected function removeProductsImages()
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

    protected function sortImagesSequence(){
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

    public function getManufacturerInfo($product)
    {
        $sql = "SELECT `id`, `title` FROM `manufacturers` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['manufacturer_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $manf = $stmt->fetch();


        $product->manf_id = $manf->id;
        $product->manf_title = $manf->title;

    }

    public function deleteProduct()
    {
        $sql = "DELETE FROM `products` WHERE `id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

        $sql= "DELETE FROM `products_categories` WHERE `product_id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();

    }


    public function getUpdatedProductInfo($updatedProduct, $product)
    {
       // $updatedProduct->category_eng_title = $product->category_eng_title;
        $updatedProduct->category_title = $product->category_title;
        $updatedProduct->product_id = $product->product_id;
        $updatedProduct->manf_title = $product->manf_title;
        $updatedProduct->manf_eng_title = $product->manf_eng_title;
    }
}