import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {
    const hamburgerButton = document.querySelector('[data-collapse-toggle="navbar-hamburger"]');
    const mobileMenu = document.getElementById('navbar-hamburger');

    if (hamburgerButton && mobileMenu) {
        hamburgerButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});