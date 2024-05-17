let topLogo = document.getElementById('toplogo');
let expandMenuButton = document.getElementById('menuexpand');
let expandedMenu = document.getElementById('expandedmenu');
let menuOpen = false;

topLogo.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

expandMenuButton.addEventListener('click', () => {
  if (menuOpen == false) {
    menuOpen = true;
    expandedMenu.style.display = 'flex';
    document.getElementById('menuexpand').style.display = 'none';
    document.getElementById('menuclose').style.display = 'block';
    setTimeout(function () {
    expandedMenu.style.transform = "scale(100%)";
    }, 100)
  } else {
    menuOpen = false;
    document.getElementById('menuexpand').style.display = 'block';
    document.getElementById('menuclose').style.display = 'none';
    expandedMenu.style.transform = "scale(0%)";
    setTimeout(function () {
      expandedMenu.style.display = 'none';
    }, 100)
  }
});