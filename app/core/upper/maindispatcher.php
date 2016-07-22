<?php
namespace App\Core\Upper;

use Lib\HelperService;
/**
 * the router class due to the url choose the appropriate controller
 * Class MainDispatcher
 * @package App\Core\Upper
 */
abstract class MainDispatcher
 {
	/**
	 * get the url-path, defines controller itself and its action + 404 redirection
	 * @return array
	 */
	public function getController(){

		$url = $this->getRidOfGET();

        $url = $this->getLanguageComponent($url);

		if(!is_array($url) && !empty($url)){ $controller[0]= $url; $controller[1]= 'index';}

		if(empty($url)){$controller[0]= 'index'; $controller[1]= 'index';}

		if(!isset($controller)){$controller= $url;}
//404 redirection
		if(
            !class_exists('\App\Controllers\\'.ucfirst($controller[0])) OR
            !method_exists('\App\Controllers\\'.ucfirst($controller[0]), $controller[1] )
        )
        { $controller[0] = 'error_404'; $controller[1] = 'index'; }




		return $controller;
	}

    /**
     *
     * liquidate GET varianle from URL
     * @return string
     */
	private function getRidOfGET()
	{
		$url = $_SERVER['REQUEST_URI'];
		$url= trim($url, '/');
//cast information after &
		if(stripos($url, '?')!== false){ $url = explode('?', $url);   $url= $url[0];}
		return $url;
	}


    /**
     * get free from language component url and language component itself
     * @param $url
     * @return array|string
     */
    protected function getLanguageComponent($url)
    {
        //if string to explode then explode into array
        if(strripos($url, '/')!== false ) {
            $url = explode('/', $url); $lang= $url[0];
        }
        //if this is just a string
        if(is_string($url)){ $lang = $url;}

        $langs = HelperService::prozessLangArray();

        //check if the posible language is present in Language list
        if (array_key_exists($lang, $langs)){
            define('CURRENT_LANG',$lang);
        //make url cleaner
            if(is_string($url)) $url='';
            if(is_array($url)) {
                array_shift($url);
                if(count($url)==1) { $url= $url[0]; }
            }

        }
        else {
            define ('CURRENT_LANG', DEFAULT_LANG);
        }
        return $url;
    }


    /**
     *
     * fire of a controller
     * @param $controller
     * @return mixed
     */
    abstract function runController($controller);

    /**
     *
     * get Path to view layout
     * @param $view
     * @return mixed
     */
    abstract function getView($view);

 }
 
 
?>
