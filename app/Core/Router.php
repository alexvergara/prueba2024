<?php

namespace App\Core;

class Router
{
    /**
     *
     */
    public static function handle($method = 'GET', $path = '/', $controller = '', $action = null, $prefix = '')
    {
        if ($path === '_404') self::abort();

        $path = explode('/', str_replace($prefix, '', $path));
        $req_method = Request::method();
        $uri = parse_url(Request::uri(), PHP_URL_PATH);
        $uri = explode('/', uri_path($uri, $prefix));

        if ($method === $req_method) {
            array_shift($uri);
            array_shift($path);

            $pattern = '#^' . $uri[0] . '$#siD';

            if (preg_match($pattern, $path[0])) {
                if (count($path) === count($uri)) {
                    if (count($path)) array_shift($uri);

                    if (is_callable($controller)) {
                        $controller();
                        exit;
                    } else {
                        $class = "\\App\\Controllers\\$prefix" . $controller;
                        if (class_exists($class)) {
                            $controller = new $class();
                            $controller->$action(...$uri);
                            exit;
                        }
                    }
                }
            }
        }

        return false;
    }

    public static function abort($code = 404)
    {
        http_response_code($code);
        die();
    }

    public static function get($path = '/', $controller = '', $action = null, $prefix = '')
    {
        self::handle('GET', $path, $controller, $action, $prefix);
    }

    public static function post($path = '/', $controller = '', $action = null, $prefix = '')
    {
        self::handle('POST', $path, $controller, $action, $prefix);
    }

    public static function put($path = '/', $controller = '', $action = null, $prefix = '')
    {
        self::handle('PUT', $path, $controller, $action, $prefix);
    }

    public static function delete($path = '/', $controller = '', $action = null, $prefix = '')
    {
        self::handle('DELETE', $path, $controller, $action, $prefix);
    }

    public static function patch($path = '/', $controller = '', $action = null, $prefix = '')
    {
        self::handle('PATCH', $path, $controller, $action, $prefix);
    }
}
