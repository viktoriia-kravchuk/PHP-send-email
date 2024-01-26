<?php

require_once 'config.php';

class DB {
    private $host;
    private $db;
    private $username;
    private $password;

    private $conn;

    public function __construct() {
        $this->host = DB_HOST;
        $this->db = DB_NAME;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
    }

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->username, $this->password);
                $this->conn->exec("set names utf8");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                echo "Database not connected: " . $exception->getMessage();
            }
        }
        return $this->conn;
    }
}

?>
