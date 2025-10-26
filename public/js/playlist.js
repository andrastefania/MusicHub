// ======== Deschide popup-ul de selecție playlist ========
async function openPlaylistDialog(songId) {
  try {
    const response = await fetch('/MusicHub/index.php?route=playlist&action=list');
    const playlists = await response.json();

    // Elimină orice popup existent
    const existing = document.querySelector('.playlist-dialog');
    if (existing) existing.remove();

    // Creează structura popup-ului
    const dialog = document.createElement('div');
    dialog.className = 'playlist-dialog';
    dialog.innerHTML = `
      <div class="playlist-popup">
        <h3>Adaugă în playlist</h3>
        
        <label for="playlistSelect">Alege playlist existent:</label>
        <select id="playlistSelect">
          ${
            playlists.length
              ? playlists.map(p => `<option value="${p.id}">${p.title}</option>`).join('')
              : '<option disabled selected>Niciun playlist încă</option>'
          }
        </select>

        <label for="newPlaylistName">Creează playlist nou:</label>
        <input type="text" id="newPlaylistName" placeholder="Ex: Melodiile mele preferate">

        <div class="actions">
          <button class="btn-create" onclick="createPlaylistAndAdd(${songId})">Creează</button>
          <button class="btn-add" onclick="addToPlaylist(${songId})">Adaugă</button>
          <button class="btn-cancel" onclick="closePlaylistDialog()">Anulează</button>
        </div>
      </div>
    `;
    document.body.appendChild(dialog);
  } catch (err) {
    console.error('Eroare la încărcarea playlisturilor:', err);
    showToast('❌ Nu s-au putut încărca playlisturile.');
  }
}

// ======== Creează un playlist nou și adaugă melodia ========
async function createPlaylistAndAdd(songId) {
  const title = document.getElementById('newPlaylistName').value.trim();
  if (!title) return showToast('⚠ Introdu un nume pentru playlist.');

  const res = await fetch('/MusicHub/index.php?route=playlist&action=create', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ title, song_id: songId })
  });

  const data = await res.json();
  if (data.success) {
    showToast(data.message || '✅ Playlist creat și melodia adăugată!');
    closePlaylistDialog();
  } else {
    showToast(data.error || '❌ Eroare la creare playlist.');
  }
}

// ======== Adaugă melodia într-un playlist existent ========
async function addToPlaylist(songId) {
  const playlistSelect = document.getElementById('playlistSelect');
  if (!playlistSelect || !playlistSelect.value) {
    showToast('⚠ Selectează un playlist existent sau creează unul nou.');
    return;
  }

  const playlistId = playlistSelect.value;
  const res = await fetch(
    `/MusicHub/index.php?route=playlist&action=add&song_id=${songId}&playlist_id=${playlistId}`
  );
  const data = await res.json();

  if (data.success) {
    showToast('✅ Melodia a fost adăugată în playlist!');
    closePlaylistDialog();
  } else {
    showToast(data.error || '❌ Eroare la adăugare.');
  }
}

// ======== Închide popup-ul ========
function closePlaylistDialog() {
  const dialog = document.querySelector('.playlist-dialog');
  if (dialog) dialog.remove();
}

// ======== Mic sistem Toast (înlocuiește alert) ========
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
