<?php
class Router
{
    public static function dispatch()
    {
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        if ($url[0] === 'api') {
            $controllerName = ucfirst($url[1]) . 'ApiController';
            $method = $url[2] ?? 'index';
            $params = array_slice($url, 3);
            $controllerFile = "../app/controllers/Api/{$controllerName}.php";
        } else {
            $controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
            $method = $url[1] ?? 'index';
            $params = array_slice($url, 2);
            $controllerFile = "../app/controllers/{$controllerName}.php";
        }


        if (!file_exists($controllerFile)) {
            die("Controller not found");
        }

        require_once $controllerFile;
        $controller = new $controllerName;

        if (!method_exists($controller, $method)) {
            die("Method not found");
        }

        call_user_func_array([$controller, $method], $params);
    }
}
