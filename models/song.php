<?php
require_once __DIR__ . '/../config/Database.php';

class Song {
    private $conn;
    private $table = 'songs';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getRandom($limit = 6) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY RAND() LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArtists() {
        $stmt = $this->conn->query("SELECT DISTINCT artist FROM {$this->table} WHERE artist <> '' ORDER BY artist ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getGenres() {
        $stmt = $this->conn->query("SELECT DISTINCT genre FROM {$this->table} WHERE genre <> '' ORDER BY genre ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function filterBy($type, $value, $userId = null) {
        switch ($type) {
            case 'artist':
                $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE artist = :v");
                $stmt->execute([':v' => $value]);
                break;

            case 'genre':
                $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE genre = :v");
                $stmt->execute([':v' => $value]);
                break;

            case 'playlist':
                $stmt = $this->conn->prepare("
                    SELECT s.* FROM songs s
                    JOIN playlist_songs ps ON s.id = ps.song_id
                    JOIN playlists p ON p.id = ps.playlist_id
                    WHERE p.title = :v
                ");
                $stmt->execute([':v' => $value]);
                break;

            case 'favorites':
                $stmt = $this->conn->prepare("
                    SELECT s.* FROM songs s
                    JOIN favorites f ON s.id = f.song_id
                    WHERE f.user_id = :u
                ");
                $stmt->execute([':u' => $userId]);
                break;

            case 'recent':
                $stmt = $this->conn->prepare("
                    SELECT s.* FROM songs s
                    JOIN recent_views r ON s.id = r.song_id
                    WHERE r.user_id = :u
                    ORDER BY r.viewed_at DESC
                ");
                $stmt->execute([':u' => $userId]);
                break;

            default:
                return [];
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
