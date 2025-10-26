
function updateSongsTitle(filterType, filterValue) {
    const titleEl = document.getElementById("songs-title");

    switch (filterType) {
        case "favorites":
            titleEl.textContent = "🎧 Your favourites";
            break;
        case "recent":
            titleEl.textContent = "🕒 Recent songs";
            break;
        case "playlist":
            titleEl.textContent = `🎶 Playlist: ${filterValue}`;
            break;
        case "artist":
            titleEl.textContent = `🎤 Artist: ${filterValue}`;
            break;
        case "genre":
            titleEl.textContent = `🎼 Genre: ${filterValue}`;
            break;
            
        default:
            titleEl.textContent = "🎵 Recommended songs";
            break;
    }

    titleEl.style.opacity = 0;
    setTimeout(() => {
        titleEl.style.transition = "opacity 0.4s";
        titleEl.style.opacity = 1;
    }, 50);
}


function filterBy(type, value = null) {
    const url = `/MusicHub/index.php?route=filter&type=${encodeURIComponent(type)}${value ? `&value=${encodeURIComponent(value)}` : ''}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const grid = document.querySelector('.grid');
            grid.innerHTML = ''; 

            i
            if (!data || data.length === 0) {
                grid.innerHTML = `<p style="text-align:center; color:#333;">Nicio melodie găsită pentru ${value || type}.</p>`;
                updateSongsTitle(); 
                return;
            }

            
            updateSongsTitle(type, value);

            data.forEach(song => {
                const card = document.createElement('div');
                card.classList.add('song-card');

                
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

            grid.style.opacity = 0;
            setTimeout(() => {
                grid.style.transition = 'opacity 0.4s';
                grid.style.opacity = 1;
            }, 50);
        })
        .catch(err => console.error('Filtering error:', err));
}
function goHome() {
  const titleEl = document.getElementById("songs-title");
  titleEl.textContent = "🎵 Recommended songs";

  
  fetch("/MusicHub/index.php?route=home&ajax=1")
    .then(response => response.json())
    .then(data => {
      const grid = document.querySelector(".grid");
      grid.innerHTML = "";

      if (!data || data.length === 0) {
        grid.innerHTML = `<p style="text-align:center; color:#333;">No songs found.</p>`;
        return;
      }

      
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
    .catch(err => console.error("Error reloading songs:", err));
}

function logout() {
  const confirmLogout = confirm("Are you sure you want to log out?");
  if (confirmLogout) {
    window.location.href = "/MusicHub/index.php?route=logout";
  }
}



