<?php



namespace app\core;

use PDO;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $classname = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $classname();
            echo 'Applying migration' . ' ' . $migration . PHP_EOL;
            $instance->up();
            echo 'Applied migration' . ' ' . $migration . PHP_EOL;
            $newMigrations[] = $migration;
            if (!empty($newMigrations)) {
                $this->saveMigrations();
            } else {
                echo 'all migrations are applied';
            }
        }
    }

    public function saveMigrations()
    {
        $stmt = $this->pdo->prepare('INSERT INTO migrations (migration) VALUES (:migration)');
        $migrations = ['m0001_initial.php', 'm0002_initial.php'];

        foreach ($migrations as $migration) {
            $stmt->bindParam(':migration', $migration);
            $stmt->execute();
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec('create table if not exists migrations (
            id int auto_increment primary key,
            migration varchar(255),
            created_at timestamp default current_timestamp
        )  engine=innodb');
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare('select migration from migrations');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}
