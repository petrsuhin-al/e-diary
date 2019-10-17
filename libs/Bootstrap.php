<?php
class Bootstrap {
    public $controller;

    public function __construct() {
        if(isset($_GET['url'])){
            $url = $_GET['url'];
            $url = rtrim($url, '/');
            $url = explode('/', $url);
            if(count($url)>=1) $con = $url[0]; else $con = "";
            if(count($url)>=2) $method = $url[1];
            if(count($url)>=3) $args = $url[2];
            $file = 'controllers/'.$con.'.php';
        }
        if(empty($con)) {
            require 'controllers/index.php';
            $controller = new Index();
            $controller->index();
            return false;
        }
        else if(file_exists($file)) {
            require $file;
            }
        else {
            require 'controllers/error.php';
            $controller = new Error_();
            $controller->index();
            return false;
        }

            if(empty($con)) $con = "index";

            $controller = new $con;
            $controller->loadModel($con);
            $controller->getVars();
            if(isset($args)) {
                $controller->$method($args);
            } else {
                if(isset($method)) {
                    $controller->$method();
                }
                else{
                    $controller->index();
                }
            }

    }
}