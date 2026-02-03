document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const iconOpen = document.querySelector('.icon-open');
            const iconClose = document.querySelector('.icon-close');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('is-open');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
        });