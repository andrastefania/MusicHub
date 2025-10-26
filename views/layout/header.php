<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>MusicHub - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/MusicHub/public/css/header.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/MusicHub/public/css/mainpage.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/MusicHub/public/css/songcard-expanded.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/MusicHub/public/css/playlist-popup.css?v=<?php echo time(); ?>">

</head>

<body>



<!-- ======== MENIU SUPERIOR CU FILTRE ======== -->
<?php if (isset($playlists, $artists, $genres)): ?>
<section class="menu-section">
    <div class="menu-bar">
        <!-- Favorite -->
        <button class="menu-btn" onclick="filterBy('favorites')">🎧 Favorite</button>

        <!-- Recente -->
        <button class="menu-btn" onclick="filterBy('recent')">🕒 Recente</button>

        <!-- Playlisturi -->
        <div class="dropdown">
            <button class="menu-btn">🎶 Playlisturi ⮟</button>
            <div class="dropdown-content">
                <?php foreach ($playlists as $p): ?>
                    <a href="#" onclick="filterBy('playlist', '<?= htmlspecialchars($p) ?>')">
                        <?= htmlspecialchars($p) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Artiști -->
        <div class="dropdown">
            <button class="menu-btn">🎤 Artiști ⮟</button>
            <div class="dropdown-content">
                <?php foreach ($artists as $a): ?>
                    <a href="#" onclick="filterBy('artist', '<?= htmlspecialchars($a) ?>')">
                        <?= htmlspecialchars($a) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Genuri -->
        <div class="dropdown">
            <button class="menu-btn">🎼 Genuri ⮟</button>
            <div class="dropdown-content">
                <?php foreach ($genres as $g): ?>
                    <a href="#" onclick="filterBy('genre', '<?= htmlspecialchars($g) ?>')">
                        <?= htmlspecialchars($g) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>     
    </div>
</section>
<button class="home-floating" onclick="goHome()">🏠</button>
<?php endif; ?>
