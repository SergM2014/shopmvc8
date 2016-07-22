<?php

namespace App\Models;
use App\Core\DataBase;


class AdminModel extends DataBase
{
    public function getAdminUser()
    {

        if(!$_POST['login'] OR !$_POST['password']) return;
        $sql = "SELECT `login` , `password`, `role` FROM `users` WHERE `login`=? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $_POST['login'], \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        if( password_verify( $_POST['password'], $user['password'] ) ) $_SESSION['admin']= true;

    }
    public function getLoopCounter()
    {
        $p = @ $_POST['p']? : '1';
        $counter = (int)($p-1)*AMOUNTONPAGEADMIN +1;
        return $counter;
    }

}