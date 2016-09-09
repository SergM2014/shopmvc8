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

}