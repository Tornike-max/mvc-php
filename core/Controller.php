<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    protected array $middlewares = [];
    public string $action = '';
    public string $layout = 'mainLayout';
    public function setLayout($layout)
    {
        return $this->layout = $layout;
    }

    public function render($view, $params)
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddleware()
    {
        return $this->middlewares;
    }
}
