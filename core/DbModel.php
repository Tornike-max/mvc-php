<?php

namespace app\core;


abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;

    public function save()
    {
        $attributes = $this->attributes();
        $tableName = $this->tableName();
        $values = array_map(fn ($attr) => ":$attr", $attributes);

        $statement = Application::$app->db->pdo->prepare("insert into $tableName (" . implode(',', $attributes) . ") values(" . implode(',', $values) . ")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        };
        $statement->execute();
    }

    public static function findOne($where)
    {
        $attributes = array_keys($where);

        $sql = implode('and', array_map(fn ($attr) => "$attr = :$attr", $attributes));

        $statement = Application::$app->db->prepare("select * from users where $sql");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}
