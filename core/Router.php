<?php
// the router considers the public folder as the Root directory of project !!!!!
class Router
{
    public static function route()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $parts = explode("/", trim($url, "/"));

        $controllerName = ucfirst($parts[0] ?: "home") . "Controller";
        $method = $parts[1] ?? "index";

        if (!class_exists($controllerName)) {
            self::notFound();
        }

        $controller = new $controllerName;

        if (!method_exists($controller, $method)) {
            self::notFound();
        }

        $params = array_slice($parts, 2);

        $controller->$method(...$params);
    }

    private static function notFound()
    {
        http_response_code(404);
        require_once "../app/views/Error/404.php";
        exit;
    }

}
