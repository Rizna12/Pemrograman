<?php 
// config/database.php

class Database {
    private $host = "localhost";
    private $db_name = "db_kelurahan";
    private $username = "root";
    private $password = "";
    private $conn;
    
    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                    $this->username,
                    $this->password,
                    array(
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_PERSISTENT => true
                    )
                );
            } catch(PDOException $e) {
                // Log error instead of echoing
                error_log("Connection error: " . $e->getMessage());
                throw new Exception("Database connection error");
            }
        }
        return $this->conn;
    }
    
    // Tambahkan method untuk menutup koneksi
    public function closeConnection() {
        $this->conn = null;
    }
}
?>