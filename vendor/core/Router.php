<?php


class Router
{
    // Текюший маршрут
    protected static $route = [];
    // Будет содержать весь список наших маршрутов
    protected static $routes = [];

    // 1 парам - регулярное выражение ( адресс )
    // 2 парам - маршрут который должен соотвествовать указанному URL адресу
    // Это должен быть массив - поскольку в нем указываеться Controller и Action ['controller' => 'Posts', 'action' => 'add']
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    // Ищет совпадение с запросом в таблице маршрутов и при совападениие записывает в $route
    public static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route)
        {
            if($url == $pattern) {
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
}