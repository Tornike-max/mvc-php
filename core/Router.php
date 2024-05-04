<?php


namespace app\core;


class Router
{
    public Request $request;
    protected $routes = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($route, $callback)
    {
        $this->routes['get'][$route] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            echo 'Not Found';
        }

        echo call_user_func($callback);
    }
}
