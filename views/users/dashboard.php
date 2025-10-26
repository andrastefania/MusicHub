<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="center">
    <div class="card">
        <h2>Welcome, <?= htmlspecialchars($user['username']) ?>!</h2>
        <p>You have succesfully created your account.</p>
        <a class="link" href="/MusicHub/index.php?logout=1">Logout</a>
    </div>
</body>
</html>
