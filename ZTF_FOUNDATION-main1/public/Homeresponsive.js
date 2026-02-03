 // Script pour le menu hamburger
        document.getElementById('hamburgerMenu').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });

        // Script pour la barre de navigation fixe
        window.onscroll = function() {
            var navbar = document.getElementById("mainNavbar");
            if (window.pageYOffset > 0) {
                navbar.classList.add("sticky");
            } else {
                navbar.classList.remove("sticky");
            }
        };