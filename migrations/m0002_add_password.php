<?php

use app\core\Application;

class m0002_add_password
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = 'alter table users add column password varchar(512) not null';
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = 'alter table users drop column password';
        $db->pdo->exec($SQL);
    }
}
