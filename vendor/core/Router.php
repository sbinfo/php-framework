<?php

namespace vendor\core;

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

    /**
     * Ищет совпадение с запросом в таблице маршрутов и при совападениие записывает в $route
     * @param $url
     * @return bool
     */
    protected static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route)
        {
            if( preg_match("#$pattern#i", $url, $matches) )
            {
                foreach ($matches as $k => $v)
                {
                    if(is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                if(!isset($route['action']))
                {
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * перенаправляет URL по корректному маршруту
     * @param string $url входящий URL
     * @return void
     */
    public static function dispatch( $url )
    {
        $url = self::removeQueryString($url);
        debug_var($url);

        if( self::matchRoute($url) )
        {
            $controller = 'app\controllers\\' . self::upperCamelCase( self::$route['controller'] );
            if(class_exists($controller))
            {
                $cObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';

                if(method_exists($cObj, $action)) {
                    $cObj->$action();
                } else {
                    echo "Метод <b>$controller::$action</b> не найден";
                }

            } else {
                echo "Контроллер <b>$controller</b> не найден";
            }

        } else {
            http_response_code( 404 );
            include '404.html';
        }
    }

    protected static function upperCamelCase($name) {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase($name) {
        return lcfirst(self::upperCamelCase($name));
    }

    protected static function removeQueryString($url)
    {
        if($url) {
            $params = explode('&', $url, 2);

            if(strpos($params[0], '=') === false) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
    }

}