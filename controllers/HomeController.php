<?php
require_once __DIR__ . '/../models/Song.php';
require_once __DIR__ . '/../models/Playlist.php';

class HomeController { 
    public function index() {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }

        $songModel = new Song();
        $playlistModel = new Playlist();

        $songs = $songModel->getRandom(6);
        $artists = $songModel->getArtists();
        $genres = $songModel->getGenres();
        $playlists = $playlistModel->getAllByUser($_SESSION['user']['id']);

        if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode($songs);
        return;
    }
        include __DIR__ . '/../views/layout/mainpage.php';

    }

    public function filterSongs() {
        session_start();
        header('Content-Type: application/json');

        $type = $_GET['type'] ?? null;
        $value = $_GET['value'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;

        if ($type === 'home') {
        echo json_encode($songModel->getRandom(6));
        return;
         }
        if (!$type) {
            echo json_encode([]);
            return;
        }

        $songModel = new Song();
        $songs = $songModel->filterBy($type, $value, $userId);

        echo json_encode($songs);
    }
}
