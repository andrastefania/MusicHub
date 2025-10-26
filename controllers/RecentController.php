<?php
require_once __DIR__ . '/../models/Recent.php';

class RecentController {
    public function add() {
        session_start();
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['id'] ?? null;
        $songId = $_GET['song_id'] ?? null;

        if (!$userId || !$songId) {
            echo json_encode(['error' => 'Invalid data.']);
            return;
        }

        $recentModel = new Recent();
        $recentModel->add($userId, $songId);

        echo json_encode(['success' => true]);
    }
}
