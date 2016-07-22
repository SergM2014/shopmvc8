<?php

use App\Core\Application;

require_once "./../config.php";

$router = new Application();

$controller=$router->getController();

require_once PATH_SITE."/resources/languages/".CURRENT_LANG.".php";

$data_and_view = $router->runController($controller);

if(isset($data_and_view)){ extract($data_and_view, EXTR_OVERWRITE);}


$template_folder = $router->findAppropriateTemplate($view);


require_once PATH_SITE."/resources/".$template_folder."/index.php";
