<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 *
 * @author kivde
 */


class Router {

    public $routes;

    public function __construct() {

        $routesPath = 'config/routes.php';
        $this->routes = include $routesPath;
    }

    /**
     * 
     * @return string
     */
    private function getUri() {
        if (!empty($_SERVER['REQUEST_URI'])) {

            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() {

        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri)) {
                
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $seg = explode("/", $internalRoute);
               
                $controllerName = array_shift($seg) . "Controller";
                $controllerName = ucfirst($controllerName);

                $actionName = "action" . ucfirst(array_shift($seg));
                
                $controllerFile = 'controllers/' . $controllerName . '.php';
                 
                $parameters =$seg;
               
                if (file_exists($controllerFile)) {
                    include_once $controllerFile;
                }
             
                $controllerObject = new $controllerName;
                $result= call_user_func_array( array($controllerObject,$actionName), $parameters);
                if ($result != NULL) {
                    break;
                    
                }
            }
        }
    }

}
