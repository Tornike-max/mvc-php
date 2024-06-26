<?php


namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;
    protected $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($route, $callback)
    {
        $this->routes['get'][$route] = $callback;
    }

    public function post($route, $callback)
    {
        $this->routes['post'][$route] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            return $this->renderView($callback, []);
        }

        if (is_array($callback)) {
            //** @var \app\core\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            foreach ($controller->getMiddleware() as $middleware) {
                $middleware->execute();
            }
            $callback[0] = $controller;
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        };

        ob_start();
        include_once Application::$ROOT_DIR . "views/$view.php";
        return ob_get_clean();
    }
}
