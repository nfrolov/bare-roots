'use strict';

var menu = document.querySelector('.menu');

if (menu && menu.classList) {
  var toggle = document.createElement('button');

  toggle.type = 'button';
  toggle.className = 'menu__toggle';
  toggle.textContent = menu.getAttribute('aria-label');

  toggle.addEventListener('click', function () {
    menu.classList.toggle('menu_active');
  });

  menu.insertBefore(toggle, menu.firstChild);
}
