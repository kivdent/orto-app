<?php


include('mysql_fuction.php');
$ThisVU = "all";
$this->title = "";
$this->context->layout='@frontend/views/layouts/print.php';
include("tables.php");
//"Это должен делать роутер
//
//controller=Контроллер,action=,print='true|false',params
if (!empty($_SERVER['REQUEST_URI'])) {

    $uri = trim($_SERVER['REQUEST_URI'], '/');
}
foreach ($_GET as $key => $value) {
    if ($key =='controller') {
        $controller = $_GET['controller'].'Controller';
    } elseif ($key == 'action') {
        $action = $_GET['action'];
    } else {
        $params['$key'] = $value;
    }
}

require_once 'components/Db.php';
require_once 'controllers/'.$controller.'.php';
$controllerObject=new $controller;
$controllerObject->viewPath='print/';
call_user_func_array(array($controllerObject,$action), $params);

if ($_GET['print']) {
    echo "<script language=\"JavaScript\" type=\"text/javascript\">window.print();</script>";
}
//include("footer2.php");
?>

