<?php
require_once __DIR__ . '/../models/User.php';

class SignupController {
    public function handle() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $confirm  = $_POST['confirm'];
            $profileImage = $_POST['profile_image'] ?? null;

            if ($password !== $confirm) {
                $error = "Passwords not identical !!!";
            } else {
                $userModel = new User();
                $result = $userModel->register($username, $password, $profileImage);

                if ($result === true) {
                    header("Location: index.php?route=login");
                    exit;
                } else {
                    $error = $result;
                }
            }
        }

        include __DIR__ . '/../views/users/signup.php';
    }
}
