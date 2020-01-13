<?php
session_start();

require __DIR__.'/../vendor/autoload.php';

use App\Helper\View;

$url            = $_SERVER['REQUEST_URI'];
$url            = trim($url, '/');
$url            = explode('/', $url);
$controllerName = (!empty($url[0])) ? $url[0].'Controller' : 'taskController';
$method         = (isset($url[1]) && $url[1][0] != '?') ? $url[1] : 'all';

if (!realpath('../app/controller/'.$controllerName.'.php')) {
    http_response_code(404);
    die;
}

$controllerNameSpace = 'App\\Controller\\'.$controllerName;
$controller          = new $controllerNameSpace;

//$data = $controller->allTasksAction();
//var_dump($method);exit;
//$data = 'test data';

$view = new View();

$view->setData([
    'action'    => $controller,
    'method'    => $method
]);
$view->render('base');