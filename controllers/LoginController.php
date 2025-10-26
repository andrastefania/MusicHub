<?php
require_once __DIR__ . '/../models/User.php'; //incarca fisierul

class LoginController
{
    public function handle()
    {
        session_start();

        
        if (isset($_GET['logout'])) {
            session_destroy(); 
            header('Location: index.php?route=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $userModel = new User(); // accesare baza de date
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: index.php?route=home');
                exit;

            } else {
                $error = "Wrong username or password.";
            }
        }

        include __DIR__ . '/../views/users/login.php';
    }
}
