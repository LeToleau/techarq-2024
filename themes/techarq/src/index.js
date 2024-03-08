document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainMenu = document.querySelector('.main-menu');

    if (menuToggle) {
        menuToggle.addEventListener('click', function () {
            mainMenu.classList.toggle('menu-open');
        });
    }
});