let modalSongId = null;

// ======== Deschide fereastra modal ========
function openSongModal(card) {
    const modal = document.getElementById('songModal');
    const ytFrame = document.getElementById('modalYT');
    const img = document.getElementById('modalImage');

    modalSongId = card.dataset.id;
    document.getElementById('modalTitle').textContent = card.dataset.title;
    document.getElementById('modalArtist').textContent = card.dataset.artist;
    img.src = card.dataset.img;

    // ===== Transformăm linkul YouTube într-un link embed =====
    let ytLink = card.dataset.yt || "";

    // Înlocuiește orice variantă de link (youtu.be / youtube.com / music.youtube.com)
    ytLink = ytLink.replace("music.youtube.com", "www.youtube.com");
    if (ytLink.includes("watch?v=")) {
        ytLink = ytLink.replace("watch?v=", "embed/");
    } else if (ytLink.includes("youtu.be/")) {
        ytLink = ytLink.replace("youtu.be/", "youtube.com/embed/");
    }

    ytFrame.src = ytLink;

    // La început arătăm doar imaginea
    ytFrame.classList.add('hidden');
    img.classList.remove('hidden');
    modal.classList.remove('hidden');
}

// ======== Închide modalul ========
function closeSongModal() {
    const modal = document.getElementById('songModal');
    const ytFrame = document.getElementById('modalYT');
    const img = document.getElementById('modalImage');

    ytFrame.src = ""; // oprește video
    ytFrame.classList.add('hidden');
    img.classList.remove('hidden');
    modal.classList.add('hidden');
}

// ======== Comută între imagine și video ========
function toggleModalYT() {
    const yt = document.getElementById('modalYT');
    const img = document.getElementById('modalImage');

    yt.classList.toggle('hidden');
    img.classList.toggle('hidden');

    // ===== Adaugă imediat melodia la Recente =====
    if (!yt.classList.contains('hidden')) {
        fetch(`/MusicHub/index.php?route=recent&song_id=${modalSongId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) console.log("✅ Melodia adăugată la Recente");
                else console.warn("⚠️ Nu s-a putut salva la Recente");
            })
            .catch(err => console.error("❌ Eroare la salvare Recente:", err));
    }
}

// ======== Favorite: adaugă ========
function addToFavorite(event, songId) {
    event.stopPropagation();
    const btn = event.currentTarget;

    fetch(`/MusicHub/index.php?route=favorite&action=add&song_id=${songId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.classList.add('favorited');
                btn.textContent = '💖 În favorite';
                showToast('✅ Melodia a fost adăugată la favorite!');
            } else {
                showToast('⚠ Melodia este deja în favorite.');
            }
        })
        .catch(err => {
            console.error('Eroare la favorite:', err);
            showToast('❌ Eroare la comunicarea cu serverul.');
        });
}

// ======== Adaugă la playlist ========
function openPlaylistDialog(songId) {
    const dialog = document.getElementById('playlistDialog');
    if (dialog) {
        dialog.classList.remove('hidden');
        dialog.dataset.songId = songId;
    }
}

// ======== Mic sistem Toast ========
function showToast(message) {
    let toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}
