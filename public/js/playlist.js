
async function openPlaylistDialog(songId) {
  try {
    const response = await fetch('/MusicHub/index.php?route=playlist&action=list');
    const playlists = await response.json();

    
    const existing = document.querySelector('.playlist-dialog');
    if (existing) existing.remove();

    
    const dialog = document.createElement('div');
    dialog.className = 'playlist-dialog';
    dialog.innerHTML = `
      <div class="playlist-popup">
        <h3>Adaugă în playlist</h3>
        
        <label for="playlistSelect">Choose existing playlist:</label>
        <select id="playlistSelect">
          ${
            playlists.length
              ? playlists.map(p => `<option value="${p.id}">${p.title}</option>`).join('')
              : '<option disabled selected>No playlists yet</option>'
          }
        </select>

        <label for="newPlaylistName">Create new playlist:</label>
        <input type="text" id="newPlaylistName" placeholder="Ex: My songs">

        <div class="actions">
          <button class="btn-create" onclick="createPlaylistAndAdd(${songId})">Create</button>
          <button class="btn-add" onclick="addToPlaylist(${songId})">Add</button>
          <button class="btn-cancel" onclick="closePlaylistDialog()">Cancel</button>
        </div>
      </div>
    `;
    document.body.appendChild(dialog);
  } catch (err) {
    console.error('Error loading playlists:', err);
    showToast(' Could not load playlists.');
  }
}

async function createPlaylistAndAdd(songId) {
  const title = document.getElementById('newPlaylistName').value.trim();
  if (!title) return showToast('Enter a name for the playlist.');

  const res = await fetch('/MusicHub/index.php?route=playlist&action=create', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ title, song_id: songId })
  });

  const data = await res.json();
  if (data.success) {
    showToast(data.message || 'Playlist created and song added!');
    closePlaylistDialog();
  } else {
    showToast(data.error || 'Error creating playlist.');
  }
}

async function addToPlaylist(songId) {
  const playlistSelect = document.getElementById('playlistSelect');
  if (!playlistSelect || !playlistSelect.value) {
    showToast('Select an existing playlist or create a new one.');
    return;
  }

  const playlistId = playlistSelect.value;
  const res = await fetch(
    `/MusicHub/index.php?route=playlist&action=add&song_id=${songId}&playlist_id=${playlistId}`
  );
  const data = await res.json();

  if (data.success) {
    showToast('The song has been added to the playlist!');
    closePlaylistDialog();
  } else {
    showToast(data.error || 'Error');
  }
}


function closePlaylistDialog() {
  const dialog = document.querySelector('.playlist-dialog');
  if (dialog) dialog.remove();
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
