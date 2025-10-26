<?php
require_once __DIR__ . '/../config/Database.php';

class Favorite {
    private $conn;
    private $table = 'favorites';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function exists($userId, $songId) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table} WHERE user_id = :u AND song_id = :s");
        $stmt->execute([':u' => $userId, ':s' => $songId]);
        return $stmt->fetchColumn() > 0;
    }

    
    public function add($userId, $songId) {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (user_id, song_id) VALUES (:u, :s)");
        return $stmt->execute([':u' => $userId, ':s' => $songId]);
    }

    
    public function remove($userId, $songId) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE user_id = :u AND song_id = :s");
        return $stmt->execute([':u' => $userId, ':s' => $songId]);
    }

    
    public function getFavorites($userId) {
        $stmt = $this->conn->prepare("
            SELECT s.* FROM songs s
            JOIN {$this->table} f ON s.id = f.song_id
            WHERE f.user_id = :u
        ");
        $stmt->execute([':u' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
