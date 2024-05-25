let topLogo = document.getElementById('toplogo');
let expandMenuButton = document.getElementById('menuexpand');
let closeMenuButton = document.getElementById('menuclose');
let expandedMenu = document.getElementById('expandedmenu');
let expandMenuButtonAccount = document.getElementById('menuexpandaccount');
let expandedMenuAccount = document.getElementById('expandedmenuaccount');
let menuOpen = false;

if (topLogo) {
  topLogo.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

if (expandMenuButton) {
  expandMenuButton.addEventListener('click', () => {
    if (menuOpen == false) {
      menuOpen = true;
      expandedMenu.style.transform = "translateX(0px)";
    }
  });
}

if (closeMenuButton) {
  closeMenuButton.addEventListener('click', () => {
    if (menuOpen == true) {
      menuOpen = false;
      expandedMenu.style.transform = "translateX(300px)";
    }
  });
}