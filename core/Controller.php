<?php

namespace app\core;

class Controller
{
    public string $layout = 'mainLayout';
    public function setLayout($layout)
    {
        return $this->layout = $layout;
    }

    public function render($view, $params)
    {
        return Application::$app->router->renderView($view, $params);
    }
}
