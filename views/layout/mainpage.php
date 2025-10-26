<?php include __DIR__ . '/header.php'; ?>

<main class="home-container">
    <!-- ======== GRID MELODII RECOMANDATE ======== -->
    <section class="songs-grid">
        <h3 id="songs-title">🎵 Melodii recomandate</h3>
        <div class="grid" id="songs-grid">
            <?php foreach ($songs as $song): ?>
                <div class="song-card"
                     data-id="<?= $song['id'] ?>"
                     data-title="<?= htmlspecialchars($song['title']) ?>"
                     data-artist="<?= htmlspecialchars($song['artist']) ?>"
                     data-img="/MusicHub/<?= htmlspecialchars($song['image_path']); ?>"
                     data-yt="<?= htmlspecialchars($song['yt_link']); ?>"
                     onclick="openSongModal(this)">
                    <img src="/MusicHub/<?= htmlspecialchars($song['image_path']); ?>" 
                         alt="<?= htmlspecialchars($song['title']); ?>">
                    <div class="song-info">
                        <span class="song-title"><?= htmlspecialchars($song['title']); ?></span>
                        <span class="song-artist"><?= htmlspecialchars($song['artist']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<!-- ======== MODAL MELODIE (Popup) ======== -->
<div id="songModal" class="song-modal hidden">
    <div class="song-modal-content">
        <button class="modal-close" onclick="closeSongModal()">✖</button>

        <div class="modal-media">
            <img id="modalImage" src="" alt="Song image">
            <iframe id="modalYT" class="hidden" width="560" height="315" allowfullscreen></iframe>
        </div>

        <h2 id="modalTitle"></h2>
        <p id="modalArtist"></p>

        <div class="modal-actions">
            <button onclick="toggleModalYT()">▶ Play</button>
            <button onclick="addToFavorite(event, modalSongId)">❤️ Favorite</button>
            <button onclick="openPlaylistDialog(modalSongId)">➕ Playlist</button>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>

