<?php


namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';


    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addSingleError('email', 'User does not exists with this email');
            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            $this->addSingleError('password', 'Password is incorrect');
            return false;
        }

        echo '<pre>';
        var_dump($user);
        echo '</pre>';
        return Application::$app->login($user);
    }
}
