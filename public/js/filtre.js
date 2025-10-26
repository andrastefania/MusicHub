// ======== Actualizează titlul dinamic ========
function updateSongsTitle(filterType, filterValue) {
    const titleEl = document.getElementById("songs-title");

    switch (filterType) {
        case "favorites":
            titleEl.textContent = "🎧 Favoritele tale";
            break;
        case "recent":
            titleEl.textContent = "🕒 Melodiile recente";
            break;
        case "playlist":
            titleEl.textContent = `🎶 Playlist: ${filterValue}`;
            break;
        case "artist":
            titleEl.textContent = `🎤 Artist: ${filterValue}`;
            break;
        case "genre":
            titleEl.textContent = `🎼 Gen: ${filterValue}`;
            break;
            
        default:
            titleEl.textContent = "🎵 Melodii recomandate";
            break;
    }

    // Efect mic de tranziție vizuală (fade)
    titleEl.style.opacity = 0;
    setTimeout(() => {
        titleEl.style.transition = "opacity 0.4s";
        titleEl.style.opacity = 1;
    }, 50);
}


// ======== Filtrare melodii dinamică ========
function filterBy(type, value = null) {
    const url = `/MusicHub/index.php?route=filter&type=${encodeURIComponent(type)}${value ? `&value=${encodeURIComponent(value)}` : ''}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const grid = document.querySelector('.grid');
            grid.innerHTML = ''; // curățăm grila anterioară

            // Dacă nu există melodii
            if (!data || data.length === 0) {
                grid.innerHTML = `<p style="text-align:center; color:#333;">Nicio melodie găsită pentru ${value || type}.</p>`;
                updateSongsTitle(); // revine la titlu implicit
                return;
            }

            // Actualizăm titlul dinamic
            updateSongsTitle(type, value);

            // Reafișăm fiecare melodie filtrată
            data.forEach(song => {
                const card = document.createElement('div');
                card.classList.add('song-card');

                // Setăm datele pentru modal
                card.dataset.id = song.id;
                card.dataset.title = song.title;
                card.dataset.artist = song.artist;
                card.dataset.img = `/MusicHub/${song.image_path}`;
                card.dataset.yt = song.yt_link;

                // eveniment click → deschide modal
                card.onclick = () => openSongModal(card);

                card.innerHTML = `
                    <img src="/MusicHub/${song.image_path}" alt="${song.title}">
                    <div class="song-info">
                        <span class="song-title">${song.title}</span>
                        <span class="song-artist">${song.artist}</span>
                    </div>
                `;
                grid.appendChild(card);
            });

            // efect de apariție smooth
            grid.style.opacity = 0;
            setTimeout(() => {
                grid.style.transition = 'opacity 0.4s';
                grid.style.opacity = 1;
            }, 50);
        })
        .catch(err => console.error('Eroare la filtrare:', err));
}
function goHome() {
  const titleEl = document.getElementById("songs-title");
  titleEl.textContent = "🎵 Melodii recomandate";

  // Cerere către backend (apelăm direct ruta 'home')
  fetch("/MusicHub/index.php?route=home&ajax=1")
    .then(response => response.json())
    .then(data => {
      const grid = document.querySelector(".grid");
      grid.innerHTML = "";

      if (!data || data.length === 0) {
        grid.innerHTML = `<p style="text-align:center; color:#333;">Nu s-au găsit melodii.</p>`;
        return;
      }

      // Reafișăm cardurile cu melodii random
      data.forEach(song => {
        const card = document.createElement("div");
        card.classList.add("song-card");

        card.dataset.id = song.id;
        card.dataset.title = song.title;
        card.dataset.artist = song.artist;
        card.dataset.img = `/MusicHub/${song.image_path}`;
        card.dataset.yt = song.yt_link;

        card.onclick = () => openSongModal(card);

        card.innerHTML = `
          <img src="/MusicHub/${song.image_path}" alt="${song.title}">
          <div class="song-info">
            <span class="song-title">${song.title}</span>
            <span class="song-artist">${song.artist}</span>
          </div>
        `;
        grid.appendChild(card);
      });
    })
    .catch(err => console.error("Eroare la reîncărcarea melodiilor:", err));
}


