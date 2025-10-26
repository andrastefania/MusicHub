<?php
require_once __DIR__ . '/../models/Favorite.php';

class FavoriteController {
    public function toggle() { 
        session_start();
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['id'] ?? null;
        $songId = $_GET['song_id'] ?? null;

        if (!$userId || !$songId) {
            echo json_encode(['error' => 'Date invalide.']);
            return;
        }

        $favoriteModel = new Favorite();

        if (!$favoriteModel->exists($userId, $songId)) {
            $favoriteModel->add($userId, $songId);
            echo json_encode(['success' => true, 'message' => 'The song has been added to favorites!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'The song is already in favorites.']);
        }
    }
}
