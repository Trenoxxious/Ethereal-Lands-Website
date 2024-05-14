let topLogo = document.getElementById('toplogo');

topLogo.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});
