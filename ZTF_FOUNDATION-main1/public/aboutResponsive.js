// JavaScript pour le menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const iconOpen = mobileMenuButton.querySelector('.icon-open'); // Icône du menu hamburger
            const iconClose = mobileMenuButton.querySelector('.icon-close'); // Icône X

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('is-open'); // Toggle custom class
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
        });