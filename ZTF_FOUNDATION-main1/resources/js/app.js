import './bootstrap';

// JavaScript for mobile menu toggle (About page)
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-toggle');
    if (mobileMenuButton) { // Only run this code if we're on the about page
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = mobileMenuButton.querySelector('.icon-open'); // Hamburger icon
        const iconClose = mobileMenuButton.querySelector('.icon-close'); // X icon

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('is-open'); // Toggle custom class
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
    }
});