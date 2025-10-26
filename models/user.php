<?php
require_once __DIR__ . '/../config/Database.php';

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
                'username' => $user['username'],
                'profile_image' => $user['profile_image'] ?? null
            ];
        }
        return false;
    }

    public function register($username, $password, $profileImage = null) {
        $check = $this->conn->prepare("SELECT * FROM {$this->table} WHERE username = :username");
        $check->execute([':username' => $username]);
        if ($check->rowCount() > 0) {
            return "Username unavailable.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = $this->conn->prepare("
            INSERT INTO {$this->table} (username, password, profile_image)
            VALUES (:username, :password, :profile_image)
        ");
        $ok = $insert->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':profile_image' => $profileImage
        ]);

        return $ok ? true : "Registration error.";
    }
}
