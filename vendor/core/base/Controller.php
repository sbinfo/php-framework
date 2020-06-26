<?php


namespace vendor\core\base;


abstract class Controller
{
    public $route = [];

    public function __construct($route)
    {
        $this->route = $route;
//        $this->view = $route['action'];
//        include APP . "/views/{$route['controller']}/{$this->view}.php";
    }

}