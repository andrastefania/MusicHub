<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;       
    private $table = 'users'; 

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return [
                'id' => $user['id'],
                'username' => $user['username']
            ];
        }
        return false;
    }
    public function register($username, $password)
{
    // verificăm dacă userul există deja
    $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return "Username unavailable.";
    }

    // criptează parola
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // inserează în baza de date
    $insert = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";
    $stmt = $this->conn->prepare($insert);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashedPassword);

    if ($stmt->execute()) {
        return true;
    } else {
        return "Error.";
    }
}

}
