// Handle hamburger menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const navLinks = document.getElementById('navLinks');
    const mainNavbar = document.getElementById('mainNavbar');

    // Toggle mobile menu
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            hamburgerMenu.classList.toggle('active');
        });
    }

    // Close menu when a link is clicked
    if (navLinks) {
        const links = navLinks.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                if (hamburgerMenu) {
                    hamburgerMenu.classList.remove('active');
                }
            });
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (hamburgerMenu && navLinks) {
            if (!hamburgerMenu.contains(event.target) && !navLinks.contains(event.target)) {
                navLinks.classList.remove('active');
                hamburgerMenu.classList.remove('active');
            }
        }
    });

    // Scroll effect on navbar
    window.addEventListener('scroll', function() {
        if (mainNavbar) {
            if (window.scrollY > 50) {
                mainNavbar.classList.add('scrolled');
            } else {
                mainNavbar.classList.remove('scrolled');
            }
        }
    });

    // Handle window resize to close menu on desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            navLinks.classList.remove('active');
            if (hamburgerMenu) {
                hamburgerMenu.classList.remove('active');
            }
        }
    });
});

const hamburger = document.getElementById('hamburgerMenu');
    const navLinks  = document.getElementById('navLinks');

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('open');

            // change l'icône selon l'état
            const icon = hamburger.querySelector('i');
            if (navLinks.classList.contains('open')) {
                icon.classList.replace('fa-bars', 'fa-times');
            } else {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        });

        // ferme le menu quand on clique sur un lien
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('open');
                const icon = hamburger.querySelector('i');
                icon.classList.replace('fa-times', 'fa-bars');
            });
        });
    }