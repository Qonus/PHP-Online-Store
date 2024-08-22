<?php

class Database
{
    use QueryTrait, AdditionalTrait, TransactionTrait;

    private static $instance;
    private $connection;

    private function __construct($config) {
        // Инициализация соединения с базой данных
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $username = $config['username'];
        $password = $config['password'];

        try {
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Логирование ошибки или вывод сообщения
            error_log('Database connection error: ' . $e->getMessage());
            throw new Exception('Database connection error.');
        }
    }

    public static function getInstance(): self {
        if (!self::$instance) {
            $config = require '../config/database.php';
            self::$instance = new self($config['default']);
        }
        return self::$instance;
    }

    protected function getConnection(): PDO {
        return $this->connection;
    }
}

trait QueryTrait {
    public function getAll(string $sql, array $args = []): array {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getRow(string $sql, array $args = []): ?stdClass {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($args);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function rowCount(string $sql, array $args = []): int {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($args);
        return $stmt->rowCount();
    }

    public function insert(string $sql, array $args = []): int {
        $stmt = $this->getConnection()->prepare($sql);
        return ($stmt->execute($args)) ? (int) $this->getConnection()->lastInsertId() : 0;
    }

    public function execute(string $sql, array $args = []): bool {
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($args);
    }
}

trait AdditionalTrait {
    public function prepareAndExecute(string $sql, array $params = []): PDOStatement {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getLastInsertId(): int {
        return (int) $this->getConnection()->lastInsertId();
    }

    public function getCurrentUser(): ?string {
        $stmt = $this->getConnection()->query("SELECT USER()");
        return $stmt->fetchColumn();
    }

    public function truncateTable(string $tableName): bool {
        $sql = "TRUNCATE TABLE " . $tableName;
        return $this->execute($sql);
    }

    public function getPaginated(string $sql, array $args = [], int $limit, int $offset): array {
        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->getConnection()->prepare($sql);
        $args[':limit'] = $limit;
        $args[':offset'] = $offset;
        $stmt->execute($args);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

trait TransactionTrait {
    public function beginTransaction(): bool {
        return $this->getConnection()->beginTransaction();
    }

    public function commit(): bool {
        return $this->getConnection()->commit();
    }

    public function rollBack(): bool {
        return $this->getConnection()->rollBack();
    }
}