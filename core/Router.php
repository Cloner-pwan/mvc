<?php
class Router
{
    public static function route()
    {

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = preg_replace("#^/public/?#", '', $url);

        $parts = explode("/", trim($url));

        $controllerName = ucfirst($parts[0]) . "Controller";
        $method = $parts[1] ?? "index";

        if (!class_exists($controllerName)) {
            die("Controller doesn't exists !");
        }

        $controller = new $controllerName;

        if (!method_exists($controllerName, $method)) {
            die("The method doesnt exists !");
        }
        
        
        $params = array_slice($parts, 2);

        $controller->$method(...$params);

    }
}