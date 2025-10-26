<?php
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'home':
        require_once 'controllers/HomeController.php';
        (new HomeController())->index();
        break;

    case 'filter':
        require_once 'controllers/HomeController.php';
        (new HomeController())->filterSongs();
        break;

    case 'login':
        require_once 'controllers/LoginController.php';
        (new LoginController())->handle();
        break;

    case 'signup':
        require_once 'controllers/SignupController.php';
        (new SignupController())->handle();
        break;

    case 'favorite':
        require_once 'controllers/FavoriteController.php';
        (new FavoriteController())->toggle();
        break;

    case 'playlist':
        require_once 'controllers/PlaylistController.php';
        (new PlaylistController())->handle();
        break;
    case 'recent':
        require_once 'controllers/RecentController.php';
        (new RecentController())->add();
        break;
    case 'logout':
        require_once 'controllers/LogoutController.php';
        (new LogoutController())->handle();
        break;

    default:
        http_response_code(404);
        echo "404 - The page does not exist.";
        break;
}


// http://localhost/phpmyadmin
// http://localhost/MusicHub/index.php
