     // Navbar Responsiveness and Sticky Effect
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburgerMenu');
            const navLinks = document.getElementById('navLinks');
            const mainNavbar = document.getElementById('mainNavbar');
            const navItems = navLinks.querySelectorAll('a');
            const hamburgerIcon = hamburger.querySelector('i'); // Get the icon element

            // Toggle mobile menu and icon
            hamburger.addEventListener('click', function() {
                navLinks.classList.toggle('active');
                // Toggle between bars and times icon
                if (navLinks.classList.contains('active')) {
                    hamburgerIcon.classList.remove('fa-bars');
                    hamburgerIcon.classList.add('fa-times'); // Use fa-times for close icon
                } else {
                    hamburgerIcon.classList.remove('fa-times');
                    hamburgerIcon.classList.add('fa-bars');
                }
            });

            // Close mobile menu when a link is clicked
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navLinks.classList.remove('active');
                    // Reset icon to bars when menu is closed
                    hamburgerIcon.classList.remove('fa-times');
                    hamburgerIcon.classList.add('fa-bars');

                    // Remove active class from all links
                    navItems.forEach(link => link.classList.remove('active'));
                    // Add active class to the clicked link
                    this.classList.add('active');
                });
            });

            // Sticky Navbar effect
            window.addEventListener('scroll', function() {
                if (window.scrollY > 0) {
                    mainNavbar.classList.add('scrolled');
                } else {
                    mainNavbar.classList.remove('scrolled');
                }

                // Update active link on scroll
                const sections = document.querySelectorAll('section[id]');
                let currentActive = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - mainNavbar.offsetHeight - 20; // Adjust for navbar height
                    const sectionHeight = section.clientHeight;
                    if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
                        currentActive = section.getAttribute('id');
                    }
                });

                navItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.getAttribute('href').includes(currentActive)) {
                        item.classList.add('active');
                    }
                });
            });

            // Set initial active link based on URL hash if any
            if (window.location.hash) {
                const initialHash = window.location.hash.substring(1);
                navItems.forEach(item => {
                    if (item.getAttribute('href').includes(initialHash)) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            } else {
                // Default to 'Home' if no hash
                document.querySelector('.nav-links a[href="#home"]').classList.add('active');
            }
        });

        document.querySelectorAll('.flip-card').forEach(card => {
    const cardInner = card.querySelector('.flip-card-inner');

    // Flip on mouse enter (hover)
    card.addEventListener('mouseenter', () => {
        cardInner.classList.add('flipped');
    });

    // Flip back on mouse leave (hover out)
    card.addEventListener('mouseleave', () => {
        cardInner.classList.remove('flipped');
    });

    // Keep existing keyboard functionality for accessibility
    card.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            cardInner.classList.toggle('flipped');
        }
    });
});