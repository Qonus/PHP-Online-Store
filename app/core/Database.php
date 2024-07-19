<?php

declare(strict_types=1);

class Database {

    use QueryTrait, AdditionalTrait;
    private static ?Database $instance = null;
    private ?PDO $connection = null;

    private function __construct() {
        $config = require "app/config/database.php";
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $username = $config['username'];
        $password = $config['password'];

        try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Database connection error: {$e->getMessage()}");
            throw new Exception("Database connection error.");
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function getConnection(): PDO {
        return $this->connection;
    }
}

trait QueryTrait {
    public function getAll(string $sql, array $args = []): array {
        $smth = $this->getConnection()->prepare($sql);
        $smth->execute($args);
        return $smth->fetchAll(PDO::FETCH_OBJ);
    }

    public function getRow(string $sql, array $args = []): ?stdClass {
        $smth = $this->getConnection()->prepare($sql);
        $smth->execute($args);
        return $smth->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function insert(string $sql, array $args = []): int {
        $smth = $this->getConnection()->prepare($sql);
        return ($smth->execute($args)) ? (int) $this->getConnection()->lastInsertId() : 0;
    }

    public function rowCount(string $sql, array $args = []): int {
        $smth = $this->getConnection()->prepare($sql);
        $smth->execute($args);
        return $smth->rowCount();
    }

    public function execute(string $sql, array $args = []): bool {
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($args);
    }
}

trait AdditionalTrait {
    public function getLastInsertId(): int {
        return (int) $this->getConnection()->lastInsertId();
    }
}