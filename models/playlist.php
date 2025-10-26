<?php
require_once __DIR__ . '/../config/Database.php';

class Playlist {
    private $conn;
    private $table = 'playlists';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    
    public function getAllByUser($userId) {
        $stmt = $this->conn->prepare("SELECT title FROM {$this->table} WHERE user_id = :u ORDER BY title ASC");
        $stmt->execute([':u' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
