
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle mobile menu
            const menuButton = document.createElement('button');
            menuButton.innerHTML = '<i class="fas fa-bars"></i>';
            menuButton.style.cssText = `
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1000;
                display: none;
                padding: 0.5rem;
                background: white;
                border: none;
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                cursor: pointer;
            `;
            document.body.appendChild(menuButton);
            menuButton.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });

            function checkScreenSize() {
                if (window.innerWidth <= 1024) {
                    menuButton.style.display = 'block';
                } else {
                    menuButton.style.display = 'none';
                    document.querySelector('.sidebar').classList.remove('active');
                }
            }
            window.addEventListener('resize', checkScreenSize);
            checkScreenSize();

            // Section navigation
            window.showSection = function(section) {
                // Masquer toutes les sections
                const allSections = document.querySelectorAll('main.main-content > section');
                allSections.forEach(function(section) {
                    section.style.display = 'none';
                });

                // Afficher la section sélectionnée
                const selectedSection = document.getElementById('section-' + section);
                if (selectedSection) {
                    selectedSection.style.display = 'block';
                }

                // Mettre à jour les liens actifs dans le menu
                const menuLinks = document.querySelectorAll('.nav-menu .nav-link');
                menuLinks.forEach(function(link) {
                    link.classList.remove('active');
                    if (link.getAttribute('onclick')?.includes(section)) {
                        link.classList.add('active');
                    }
                });
            }

            // Initialiser la première section (dashboard)
            showSection('dashboard');
        });