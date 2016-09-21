<?php

namespace Lib;


class CookieService {

    public static function addCookies()
    {
        $cookies = serialize($_SESSION['busket']);
        setcookie('busket', $cookies, time()+1209600, '/');
        setcookie('totalAmount', $_SESSION['total_amount'], time()+1209600, '/');
        setcookie('totalSum', $_SESSION['total_sum'], time()+1209600, '/');
    }


    public static function getCookies()
    {

        if(!isset($_SESSION['busket']) && isset($_COOKIE['busket'])){
            $_SESSION['busket']= unserialize($_COOKIE['busket']);
        }

        if(!isset($_SESSION['total_amount']) && isset($_COOKIE['totalAmount'])){
            $_SESSION['total_amount'] = $_COOKIE['totalAmount'];
        }

        if(!isset($_SESSION['total_sum']) && isset($_COOKIE['totalSum'])){
            $_SESSION['total_sum'] = $_COOKIE['totalSum'];
        }


    }

}


?>