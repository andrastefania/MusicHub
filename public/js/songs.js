let modalSongId = null;

function openSongModal(card) {
    const modal = document.getElementById('songModal');
    const ytFrame = document.getElementById('modalYT');
    const img = document.getElementById('modalImage');

    modalSongId = card.dataset.id;
    document.getElementById('modalTitle').textContent = card.dataset.title;
    document.getElementById('modalArtist').textContent = card.dataset.artist;
    img.src = card.dataset.img;

    let ytLink = card.dataset.yt || "";

    
    ytLink = ytLink.replace("music.youtube.com", "www.youtube.com");
    if (ytLink.includes("watch?v=")) {
        ytLink = ytLink.replace("watch?v=", "embed/");
    } else if (ytLink.includes("youtu.be/")) {
        ytLink = ytLink.replace("youtu.be/", "youtube.com/embed/");
    }

    ytFrame.src = ytLink;

    ytFrame.classList.add('hidden');
    img.classList.remove('hidden');
    modal.classList.remove('hidden');
}

function closeSongModal() {
    const modal = document.getElementById('songModal');
    const ytFrame = document.getElementById('modalYT');
    const img = document.getElementById('modalImage');

    ytFrame.src = ""; 
    ytFrame.classList.add('hidden');
    img.classList.remove('hidden');
    modal.classList.add('hidden');
}

function toggleModalYT() {
    const yt = document.getElementById('modalYT');
    const img = document.getElementById('modalImage');

    yt.classList.toggle('hidden');
    img.classList.toggle('hidden');

    if (!yt.classList.contains('hidden')) {
        fetch(`/MusicHub/index.php?route=recent&song_id=${modalSongId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) console.log("Song added to Recent");
                else console.warn("Could not save to Recents");
            })
            .catch(err => console.error("Error saving Recent:", err));
    }
}


function addToFavorite(event, songId) {
    event.stopPropagation();
    const btn = event.currentTarget;

    fetch(`/MusicHub/index.php?route=favorite&action=add&song_id=${songId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.classList.add('favorited');
                btn.textContent = '💖 In favorites';
                showToast('The song has been added to favorites!');
            } else {
                showToast('The song is already in favorites.');
            }
        })
        .catch(err => {
            console.error('Error', err);
            showToast('Server Error');
        });
}


function openPlaylistDialog(songId) {
    const dialog = document.getElementById('playlistDialog');
    if (dialog) {
        dialog.classList.remove('hidden');
        dialog.dataset.songId = songId;
    }
}


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
