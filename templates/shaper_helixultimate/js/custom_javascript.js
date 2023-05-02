const mainHeader = document.querySelector('.main-header');
const scrollHeader = document.querySelector('.scroll-header');
let prevScrollPos = window.pageYOffset;

window.onscroll = function() {
  let currentScrollPos = window.pageYOffset;
  if (prevScrollPos > currentScrollPos) {
    mainHeader.style.top = '0';
    scrollHeader.style.display = 'none';
  } else {
    mainHeader.style.top = '-100px';
    scrollHeader.style.display = 'block';
  }
  prevScrollPos = currentScrollPos;
}
