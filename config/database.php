<?php
class Database {
    private $host = "localhost";     // adresa serverului MySQL
    private $port = "3306";          // portul MySQL (implicit)
    private $db_name = "musichub";  // numele bazei de date
    private $username = "root";      // utilizatorul MySQL
    private $password = "";          // parola (goală în XAMPP local)
    public $conn;                    // obiectul conexiunii PDO

    public function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
