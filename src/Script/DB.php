<?php
namespace App\Script;

class DB {
    private string $host = 'mysql';
    private string $port = '3306';
    private string $user = 'root';
    private string $pwd = 'rootpassword';
    private string $dbname = 'db_tournament';
    private ?\PDO $connection;
    private static $instance = null;

    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8";
            $this->connection = new \PDO(
                $dsn,
                $this->user,
                $this->pwd
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

            
        } catch(\PDOException $e) {
            die("Error -- connection failed: {$e->getMessage()}");
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params=[]) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll($sql, $params=[]) {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetchOne($sql, $params=[]) {
        return $this->query($sql, $params)->fetch();
    }

    public function rowsCount($sql, $params=[]) {
        return $this->query($sql, $params)->rowCount();
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $where, $whereParams=[]) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "{$key} = :{$key}";
        }
        $set = implode(', ', $set);
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        return $this->query($sql, $params)->rowCount();
    }

    public function delete($table, $where, $params=[]) {
        $sql = "DELETE FROM {$talbe} WHERE {$where}";
        return $this->query($sql, $params)->rowCount();
    }

}
?>