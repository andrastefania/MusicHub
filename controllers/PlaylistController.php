<?php
require_once __DIR__ . '/../config/Database.php';
session_start();

class PlaylistController {
    public function handle() {
        $action = $_GET['action'] ?? '';
        $db = new Database();
        $conn = $db->connect();
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            echo json_encode(['error' => 'Unauthenticated user']);
            return;
        }

        switch ($action) {
            
            case 'list':
                $stmt = $conn->prepare("SELECT id, title FROM playlists WHERE user_id = :u ORDER BY title ASC");
                $stmt->execute([':u' => $userId]);
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                break;

            case 'create':
                $data = json_decode(file_get_contents('php://input'), true);
                $title = trim($data['title'] ?? '');
                $songId = $data['song_id'] ?? null;

                if ($title === '') {
                    echo json_encode(['error' => 'Invalid title']);
                    return;
                }

                $stmt = $conn->prepare("INSERT INTO playlists (user_id, title) VALUES (:u, :t)");
                $stmt->execute([':u' => $userId, ':t' => $title]);
                $playlistId = $conn->lastInsertId();

                if ($songId) {
                    $stmt = $conn->prepare("INSERT INTO playlist_songs (playlist_id, song_id) VALUES (:p, :s)");
                    $stmt->execute([':p' => $playlistId, ':s' => $songId]);
                }

                echo json_encode([
                    'success' => true,
                    'playlist_id' => $playlistId,
                    'message' => 'Playlist created and song added successfully!'
                ]);
                break;

            case 'add':
                $songId = $_GET['song_id'] ?? null;
                $playlistId = $_GET['playlist_id'] ?? null;

                if (!$songId || !$playlistId) {
                    echo json_encode(['error' => 'Insufficient data to add.']);
                    return;
                }

                $check = $conn->prepare("SELECT COUNT(*) FROM playlist_songs WHERE playlist_id = :p AND song_id = :s");
                $check->execute([':p' => $playlistId, ':s' => $songId]);

                if ($check->fetchColumn() > 0) {
                    echo json_encode(['error' => 'The song already exists in the playlist.']);
                    return;
                }

                $stmt = $conn->prepare("INSERT INTO playlist_songs (playlist_id, song_id) VALUES (:p, :s)");
                $stmt->execute([':p' => $playlistId, ':s' => $songId]);

                echo json_encode(['success' => true, 'message' => 'The song has been added to the playlist!']);
                break;

            default:
                echo json_encode(['error' => 'Unknown action.']);
                break;
        }
    }
}
