<?php
require_once __DIR__ . '/../config/Database.php';

class Recent {
    private $conn;
    private $table = 'recent_views';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

   
    public function add($userId, $songId) {
        $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE user_id = :u AND song_id = :s");
        $stmt->execute([':u' => $userId, ':s' => $songId]);

        if ($stmt->fetch()) {
            
            $update = $this->conn->prepare("UPDATE {$this->table} SET viewed_at = CURRENT_TIMESTAMP WHERE user_id = :u AND song_id = :s");
            $update->execute([':u' => $userId, ':s' => $songId]);
        } else {
            
            $insert = $this->conn->prepare("INSERT INTO {$this->table} (user_id, song_id) VALUES (:u, :s)");
            $insert->execute([':u' => $userId, ':s' => $songId]);
        }

        $countStmt = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table} WHERE user_id = :u");
        $countStmt->execute([':u' => $userId]);
        $count = $countStmt->fetchColumn();

        if ($count > 6) {
            $delete = $this->conn->prepare("
                DELETE FROM {$this->table}
                WHERE user_id = :u
                ORDER BY viewed_at ASC
                LIMIT 1
            ");
            $delete->execute([':u' => $userId]);
        }
    }
}
