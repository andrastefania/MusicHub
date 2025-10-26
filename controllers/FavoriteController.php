<?php
require_once __DIR__ . '/../models/Favorite.php';

class FavoriteController {
    public function toggle() { // putem lăsa numele toggle pentru compatibilitate cu JS
        session_start();
        header('Content-Type: application/json');

        $userId = $_SESSION['user']['id'] ?? null;
        $songId = $_GET['song_id'] ?? null;

        if (!$userId || !$songId) {
            echo json_encode(['error' => 'Date invalide.']);
            return;
        }

        $favoriteModel = new Favorite();

        // dacă melodia nu există, o adaugă; altfel, o ignoră
        if (!$favoriteModel->exists($userId, $songId)) {
            $favoriteModel->add($userId, $songId);
            echo json_encode(['success' => true, 'message' => 'Melodia a fost adăugată la favorite!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Melodia este deja în favorite.']);
        }
    }
}
