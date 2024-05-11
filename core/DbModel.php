<?php

namespace app\core;


abstract class DbModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;

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
}
