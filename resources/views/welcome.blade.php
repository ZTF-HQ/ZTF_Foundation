<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Bienvenue</title>
    <meta name="description" content="ZTF Foundation s'engage à transformer des vies à travers l'éducation, la santé et le développement communautaire.">
    <meta name="keywords" content="fondation, éducation, santé, communauté, développement durable">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <!-- Hero Section -->
    <header class="hero">
        <nav class="navbar">
            <div class="logo">
                <img src="{{ asset('images/CMFI Logo.png') }}" alt="ZTF Foundation Logo" class="logo-img">
                <span class="logo-text">ZTF Foundation</span>
            </div>
            <div class="nav-links">
                <a href="#about">À propos</a>
                <a href="#mission">Notre Mission</a>
                <a href="#contact">Contact</a>
            </div>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </nav>

        <div class="hero-content">
            <h1 class="hero-title">Bienvenue à la<br>ZTF Foundation</h1>
            <p class="hero-subtitle">Ensemble, construisons un avenir meilleur</p>
            <a href="{{ route('home') }}" target="_blank" class="cta-button">
                Découvrir
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <h2 class="section-title">À propos de nous</h2>
            <div class="about-grid">
                <div class="about-image">
                    <img src="{{ asset('images/ztf/building1.jpg') }}" 
                         alt="Notre Centre de Formation" 
                         class="rounded-image"
                         loading="lazy">
                </div>
                <div class="about-content">
                    <h3>Notre Histoire</h3>
                    <p>La Fondation ZTF s'engage à transformer des vies à travers l'éducation, la santé et le développement communautaire. Notre vision est de créer un impact positif et durable dans la société.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="mission" class="mission-section">
        <div class="container">
            <h2 class="section-title">Notre Mission</h2>
            <div class="mission-grid">
                <div class="mission-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Éducation</h3>
                    <p>Faciliter l'accès à une éducation de qualité pour tous</p>
                </div>
                <div class="mission-card">
                    <i class="fas fa-heart"></i>
                    <h3>Santé</h3>
                    <p>Améliorer l'accès aux soins de santé dans les communautés</p>
                </div>
                <div class="mission-card">
                    <i class="fas fa-hands-helping"></i>
                    <h3>Communauté</h3>
                    <p>Renforcer les liens communautaires et le développement local</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <h2 class="section-title">Notre Impact</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Événement communautaire ZTF Foundation"
                         loading="lazy">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1560252829-804f1aedf1be?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Formation éducative ZTF Foundation"
                         loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="section-title">Contactez-nous</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>123 Rue Example, Ville, Pays</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <p>contact@ztffoundation.org</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <p>+123 456 789</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="https://placehold.co/100x50" alt="ZTF Foundation Logo" class="logo-img">
                    <span class="logo-text">ZTF Foundation</span>
                </div>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} ZTF Foundation. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Custom JS -->
    <script src="{{ asset('js/welcome.js') }}" defer>
</body>
</html>
