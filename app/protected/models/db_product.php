<?php


namespace App\Models;


use App\Core\DataBase;


class DB_Product extends DataBase
{

    public function getPreview()
    {
        $sql = "SELECT `id`, `author`, `title`, `description`, `price` FROM `products` WHERE `id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }

    public function getProduct()
    {
        $id= $_GET['id'] ?? $_POST['id'];

        $sql = "SELECT `p`.`id` AS `product_id`, `p`.`author`, `p`.`title` AS `title`, `p`.`description`,
        `p`.`body`, `p`.`price`,  `p`.`manf_id`,   GROUP_CONCAT( DISTINCT `c`.`title` SEPARATOR ', ') AS `category_title`, GROUP_CONCAT( DISTINCT `c`.`id`) AS `category_id`,
         `m`.`id`, `m`.`eng_translit_title` AS `manf_eng_title`,
        `m`.`title` AS `manf_title`, `m`.`url` AS `manf_url`, GROUP_CONCAT(DISTINCT `im`.`image`) AS `images` 
          FROM `products` `p`  LEFT JOIN `manufacturers` `m` ON `p`.`manf_id`= `m`.`id` 
          LEFT JOIN `images` `im` ON `p`.`id` = `im`.`product_id` 
           JOIN `products_categories` `pivot` ON `p`.`id` = `pivot`.`product_id` JOIN `categories` `c` ON `pivot`.`category_id` = `c`.`id`
           WHERE `p`.`id`=? ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        $images = isset($result->images)? explode(',',$result->images): NULL ;
        $result->images = $images;

        $_SESSION['images'] = [];
        $_SESSION['deleteImageList'] =[];

        return $result;
    }

    public function getComments()
    {
        $id= $_GET['id'] ?? $_POST['id'];

        $order = (@ $_POST['order'] == 'old_first')? 'ASC': 'DESC';

        $sql = "SELECT `avatar`, `name`, `email`, `comment`, `created_at`, `changed`, `published` FROM `comments` WHERE
                `product_id`= ? AND `published`='1' ORDER BY `created_at` $order";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt-> execute();
        $result= $stmt->fetchAll();

        return $result;
    }

    public function getProductForBusket($id)
    {
        $sql = "SELECT `id`, `author`, `title`, `description`, `price` FROM `products` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(/*\PDO::FETCH_ASSOC*/);

        return $result;

    }

    public static function getCategoriesArray($product)
    {
        $array = [];

        $categoryIds = explode(',', $product->category_id);
        $categoryTitles = explode(', ', $product->category_title);

        $size = sizeof($categoryIds);

        for ($i=0; $i < $size; $i++ )
        {
            $array[$categoryIds[$i]] =$categoryTitles[$i];
        }
        return $array;
    }

}