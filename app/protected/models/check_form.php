<?php

namespace App\Models;
use App\Core\DataBase;
use Lib\CheckFieldsService;
use Lib\HelperService;
use function \empty_field;
use function \wrong_email;
use function \wrong_captcha;
use function \empty_message;
use function \updated_comment;
use function \changed_yes;

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
        $data= HelperService::cleanInput($_POST, 'message');
        $error=[];
        if(empty($data['name'])) $error['name']= empty_field();
        if(empty($data['email'])) $error['email']= empty_field();
        if(empty($data['message'])) $error['message']= empty_message();
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

    public function insertMessage()
    {
        $data= HelperService::cleanInput($_POST, 'message');
        $data['message'] = $this->stripTags($_POST['message']);



        $sql = "INSERT INTO `messages` (`name`, `email`, `phone`, `message`, `date`) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(1, $data['name'], \PDO::FETCH_ASSOC);
        $stmt->bindValue(2, $data['email'], \PDO::FETCH_ASSOC);
        $stmt->bindValue(3, $data['phone'], \PDO::FETCH_ASSOC);
        $stmt->bindValue(4, $data['message'], \PDO::FETCH_ASSOC);
        $stmt->execute();



    }

    public function ifMessageNotEmpty()
    {
        if(empty($_POST['message'])) return ["message_error" => empty_message()];
    }





}