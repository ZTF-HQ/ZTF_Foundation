// Mobile menu toggle
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

            // Initialize map
            const map = L.map('map').setView([4.5755, 13.6847], 14); // Coordinates for Bertoua, Koumé

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add marker for ZTF Foundation location in Koumé, Bertoua
            L.marker([4.5755, 13.6847]).addTo(map)
                .bindPopup('ZTF Foundation - Koumé, Bertoua')
                .openPopup();
        });