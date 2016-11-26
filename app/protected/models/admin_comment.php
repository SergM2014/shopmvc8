<?php


namespace App\Models;


use App\Core\DataBase;
use Lib\CheckFieldsService;

class Admin_Comment extends DataBase
{
    use CheckFieldsService;

    public function getAllComments()
    {
        switch(@$_POST['order2']){
            case 'old_first':
                $order2 = "`c`.`created_at` ASC";
                break;
            case 'new_first':
                $order2 = "`c`.`created_at` DESC";
                break;
            default:
                $order2 = '`c`.`created_at` DESC';
        }

        switch (@$_POST['order1'])
        {
            case 'email':
                $order1 = "`c`.`email`, ";
                break;
            case 'name':
                $order1 = "`c`.`name`, ";
                break;
            case 'product':
                $order1= "`c`.`product_id`, ";
                break;
            default:
                $order1 = "";
        }

        $p = @$_POST['p']? : 1;
        $start = ($p-1)*AMOUNTONPAGEADMIN;

        $sql = "SELECT `c`.`id`, `c`.`product_id`, `c`.`avatar`, `c`.`name`, `c`.`email`, `c`.`comment`, `c`.`created_at`, `c`.`changed`, `c`.`published`, `p`.`title`
                FROM `comments` `c` JOIN `products` `p` ON `c`.`product_id` = `p`.`id`  ORDER BY $order1  $order2   LIMIT ?, ? ";
        $stmt = $this->conn->prepare($sql);

        $stmt ->bindValue(1, $start, \PDO::PARAM_INT);
        $stmt ->bindValue(2, AMOUNTONPAGEADMIN, \PDO::PARAM_INT);
        $stmt ->execute();

        $res = $stmt->fetchAll();
        return $res;

    }


    public function countAdminCommentsPages()
    {
        $sql = "SELECT `id` FROM `comments`";
        $stmt= $this->conn->query($sql);
        $rows =  $stmt->rowCount();

        $res = ceil($rows/AMOUNTONPAGEADMIN);
        return $res;
    }


    public function publish()
    {
        $sql = "SELECT `published` FROM `comments` WHERE  `id` =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $published = $stmt->fetchColumn();
        if($published == "1") return false;


        $sql = "UPDATE `comments` SET `published`='1' WHERE `id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        return true;

    }

    public function unpublish()
    {
        $sql = "SELECT `published` FROM `comments` WHERE  `id` =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        $published = $stmt->fetchColumn();
        if($published == "0") return false;


        $sql = "UPDATE `comments` SET `published`='0' WHERE `id`= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        return true;

    }

    public function getOneComment()
    {
        $id = @$_GET['id']? : @$_POST['id'];

        $sql = "SELECT `c`.`id`, `c`.`product_id`, `c`.`avatar`, `c`.`name`, `c`.`email`, `c`.`comment`,
        `c`.`created_at`, `c`.`changed`, `c`.`published`, `p`.`title` AS `product_title` FROM `comments` `c` JOIN `products` `p`
         ON c.product_id = p.id WHERE `c`.`id`=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }

    public function updateCommentText()
    {
        $comment = $this->stripTags($_POST['comment']);
        $sql= "UPDATE `comments` SET `comment`=?, `published`='1' WHERE `id`=?";
        $stmt = $this ->conn->prepare($sql);
        $stmt->bindValue(1, $comment, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['id'], \PDO::PARAM_STR);
        $stmt->execute();
        unset($_SESSION['edit']);

    }

}