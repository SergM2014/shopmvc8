<?php

namespace  App\Core;

use App\Core\Upper\MainDispatcher;


class Application extends MainDispatcher {

    /**
     *
     * fire off appointed controller
     * @param $controller
     * @return mixed
     */
    public function runController($controller){

        $name_contr = 'App\\Controllers\\'.ucfirst($controller[0]);


        $action = $controller[1];

        $contr = new $name_contr($controller);

        $data=call_user_func(array($contr, $action));

        return $data;

    }


    /**
     *
     * get the way of the view
     * @param $view
     * @return string
     */
    public function getView ($view)//получить представление для контролера $view
    {
             $view_path = '/resources/'.$view;

        return PATH_SITE.$view_path;
    }

    public function findAppropriateTemplate($view)
    {
        $result = preg_match('/^admin/',$view);

        if($result) return 'admintemplate';
        return 'template';
    }



}