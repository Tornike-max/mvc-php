<?php

namespace app\core;

class Session
{
    const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            $flashMessage['remove'] = true;
            $_SESSION[self::FLASH_KEY] = $flashMessage;
        }

        echo '<pre>';
        var_dump($_SERVER());
        echo '</pre>';
    }


    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message,
        ];
    }

    public function getFlash()
    {
    }
}
