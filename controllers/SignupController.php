<?php
require_once __DIR__ . '/../models/User.php';

class SignupController
{
    public function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm  = trim($_POST['confirm'] ?? '');

            if ($password !== $confirm) {
                $error = "Passwords not identical!!!";
            } else {
                $userModel = new User();
                $result = $userModel->register($username, $password);

                if ($result === true) {
                    // Redirect corect prin router
                    header('Location: index.php?route=login&signup=success');
                    exit;
                } else {
                    $error = $result;
                }
            }
        }

        include __DIR__ . '/../views/users/signup.php';
    }
}
