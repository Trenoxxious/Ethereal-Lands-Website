let topLogo = document.getElementById('toplogo');
let expandMenuButton = document.getElementById('menuexpand');
let expandedMenu = document.getElementById('expandedmenu');
let menuOpen = false;

if (topLogo) {
  topLogo.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

expandMenuButton.addEventListener('click', () => {
  if (menuOpen == false) {
    menuOpen = true;
    expandedMenu.style.display = 'flex';
    setTimeout(function () {
      expandedMenu.style.transform = "scale(100%)";
    }, 100)
  } else {
    menuOpen = false;
    expandedMenu.style.transform = "scale(0%)";
    setTimeout(function () {
      expandedMenu.style.display = 'none';
    }, 100)
  }
});