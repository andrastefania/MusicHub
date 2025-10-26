let currentAvatar = 0;
const avatars = document.querySelectorAll(".avatar");
const avatarContainer = document.querySelector(".avatar-container");
const hiddenInput = document.getElementById("selectedAvatar");

function showAvatar(index) {
  
  const offset = -index * 220; 
  avatarContainer.style.transform = `translateX(${offset}px)`;

  avatars.forEach((img, i) => img.classList.toggle("active", i === index));
  hiddenInput.value = avatars[index].dataset.path;
}

document.querySelector(".avatar-prev").addEventListener("click", () => {
  currentAvatar = (currentAvatar - 1 + avatars.length) % avatars.length;
  showAvatar(currentAvatar);
});

document.querySelector(".avatar-next").addEventListener("click", () => {
  currentAvatar = (currentAvatar + 1) % avatars.length;
  showAvatar(currentAvatar);
});

showAvatar(0);
