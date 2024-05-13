<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'mainLayout';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;
    public Session $session;
    public Database $db;
    public ?DbModel $user;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];

        self::$ROOT_DIR = $rootPath . "/";
        $this->request = new Request();
        self::$app = $this;
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = 'id';
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->router->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return self::$app->user;
    }

    public function getUserInfo()
    {
        echo $this->user['firstname'] . ' ' . $this->user['lastname'];
    }
}
