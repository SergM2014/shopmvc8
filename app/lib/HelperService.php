<?php

namespace Lib;


/**
 *
 * the class provides many usefull helper function
 *
 * Class HelperService
 * @package Lib
 */
class HelperService {
    /**
     * make ininputs fields free from tags
     *
     * @param $arr
     * @param null $esc
     * @return mixed
     */
    public static function cleanInput($arr, $esc=null){

        foreach($arr as $key=>$value){
            if ($esc!= $key){$arr[$key]=htmlspecialchars($value, ENT_QUOTES);}
            else{$arr[$key]=$value;}
        }
        return $arr;
    }

    /**
     *
     * sending email
     *
     * @param $message
     * @param $from
     * @param $name
     * @param $phone
     */
    public static function tomail( $message, $from, $name, $phone){
         $time_now = LangService::rus_date("j F Y H:i ", time());
         $to= ADMINEMAIL;
         $title = $time_now. "\n Повидомлення з сайту Имя ".$name." Телефон ".$phone;

         $from = $from;
    //Возвращает TRUE, если письмо было принято для передачи, иначе FALSE.
        $mail= mail($to, $title, $message, 'From '.$from);
       
     }

    /**
     * convert the string with languages LANG into assoc array
     *
     * @return array
     */
    public static function prozessLangArray()
    {

        $langs = [];

        foreach (LANG as $ln) {
            $arr = explode('=>', $ln);
            $key = trim($arr[0], ' ');
            $value = trim($arr[1], ' ');
            $langs[$key] = $value;
        }
        return $langs;
    }


    /**
     *
     * find out the language component in url
     *
     * @return string
     */
    public static function currentLang()
    {
        $langs = self::prozessLangArray();

        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');
        $url = trim($url, ' ');
        foreach ($langs as $key => $value){
            $position = strpos($url, $key);
            if($position === 0) { return $key.'/';}
        }

        return '';
    }


    /**
     *
     * for droplist of the possible language in the header
     * override language in url
     *
     * @param $lang
     * @return string url
     */
    public static function overrideLang($lang)
    {
        //get associative array of languages
        $langs = self::prozessLangArray();

        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');
        $url = trim($url, ' ');

      if(strpos($url, '/')) {
       $url = explode('/', $url);
          foreach ($langs as $key=> $value){

              $position = array_search($key, $url);
              if(($position != false)) { unset($url[$position]);}
          }
      } else {
          foreach($langs as $key=>$value){
              if($key == $url){ unset($url); break;}
          }

      }

        if(is_string($url)) {$adress= $url; $url= []; $url[0] = $adress;}
        if(!isset($url)) $url =[];

        if(DEFAULT_LANG != $lang)  array_unshift($url, $lang);

        $url = @ implode($url, '/');
        return $url;

    }



}