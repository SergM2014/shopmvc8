<?php

namespace App\Models;
use App\Core\DataBase;
use Lib\CheckFieldsService;
use Lib\HelperService;
/*use function \empty_field;
use function \wrong_email;
use function \wrong_captcha;
use function \empty_comment;
use function \updated_comment;
use function \changed_yes;*/

class CheckForm extends DataBase
{
    use CheckFieldsService;

    /**
     *
     *check if the income array after cleaning is not empty
     *
     * @return array
     */
    private function checkIfNotEmpty()
    {
        $data= HelperService::cleanInput($_POST, 'comment');
        $error=[];
        if(empty($data['name'])) $error['name']= empty_field();
        if(empty($data['email'])) $error['email']= empty_field();
        if(empty($data['comment'])) $error['comment']= empty_comment();
        if(empty($data['captcha'])) $error['captcha']= empty_field();

        return $error;
    }

    public function checkFields()
    {
        $error = $this->checkIfNotEmpty();
        if(!filter_var(@$_POST['email'], FILTER_VALIDATE_EMAIL)) $error['email']= wrong_email();
        if($_SESSION['phrase'] != $_POST['captcha']) $error['captcha'] = wrong_captcha();
        return $error;
    }

    public function insertComment()
    {
        $data= HelperService::cleanInput($_POST, 'comment');
        $data['comment'] = $this->stripTags($_POST['comment']);

        $avatar = @ $_SESSION['avatar'];

        $sql = "INSERT INTO `comments` (`avatar`, `name`, `email`, `comment`, `published`, `changed`, `date`) VALUES (?, ?, ?, ?, '0', '0', NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $avatar, \PDO::FETCH_ASSOC);
        $stmt->bindValue(2, $data['name'], \PDO::FETCH_ASSOC);
        $stmt->bindValue(3, $data['email'], \PDO::FETCH_ASSOC);
        $stmt->bindValue(4, $data['comment'], \PDO::FETCH_ASSOC);
        $stmt->execute();


         unset ($_SESSION['avatar']);
    }

    public function ifCommentNotEmpty()
    {
        if(empty($_POST['comment'])) return ["comment_error" => empty_comment()];
    }


    public function updateComment()
    {
        $comment = $this->stripTags($_POST['comment']);
        $sql = "UPDATE `comments` SET `comment`= ?, `published`=?, `changed`= '1' WHERE `id` =?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $comment, \PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['published'], \PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['id'], \PDO::PARAM_INT);
        $stmt->execute();
        return ["comment"=> $comment, "success" => updated_comment(), "changed"=>"YES", "published" => $_POST['published']];
    }


}