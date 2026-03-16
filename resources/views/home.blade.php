<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Home</title>
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{asset('authAction.css')}}">
    <link rel="stylesheet" href="{{asset('css/homeFeatures.css')}}">
    <link rel="stylesheet" href="{{asset('css/home-responsive.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
    
    <div class="top-bar">
        <div class="contact-info">
            <span style="border-right: 2px solid #fffdfd;"><i class="fas fa-phone-alt"></i> +237 683 067 844</span>
            <span style="margin-left: 5px;"><i class="fas fa-envelope"></i> info@ztffoundation.com</span>
        </div>
        <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>

    <nav class="navbar" id="mainNavbar">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/CMFI Logo.png') }}" alt="Site Logo">ZTF Foundation
        </a>
        <div class="hamburger" id="hamburgerMenu">
            <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('home') }}" class="active">Home</a></li>
            <li><a href="{{ route('about') }}" class="">About</a></li>
            <li><a href="{{route('indexDepts')}}">Departments</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="{{route('blog')}}">Blog</a></li>
            <li class="auth-buttons">
                <a href="{{ route('login') }}" class="auth-link login-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('identification.form') }}" class="auth-link"><i class="fas fa-user-plus"></i> Register</a>
            </li>
        </ul>
    </nav>

    <section class="home-section" id="home">
        <div class="content" style="margin-left:-10%">
            <h2>Welcome to the <span>Zacharias Tannee Fomum <br>Foundation</span> Staff Portal</h2>
            <p>Get information about all staff, resources, and management tools.</p>
            
        </div>
    </section>

    <h1>Key Features</h1>
    <div class="features-container">
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128100;</span> <h2 class="feature-title">Centralized Profiles</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Centralized Profiles</h2>
                    <p>Securely store and access comprehensive staff profiles, including personal details, contact information, and employment history.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128193;</span> <h2 class="feature-title">Document Management</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Document Management</h2>
                    <p>Effortlessly upload, organize, and retrieve important documents like contracts, certifications, and performance reviews.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128202;</span> <h2 class="feature-title">Performance Tracking</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Performance Tracking</h2>
                    <p>Monitor staff performance with customizable metrics, set goals, and conduct regular appraisals to foster growth.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128337;</span> <h2 class="feature-title">Leave & Attendance</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Leave & Attendance</h2>
                    <p>Simplify leave requests, approvals, and attendance tracking with an intuitive interface and automated calculations.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128200;</span> <h2 class="feature-title">Reporting & Analytics</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Reporting & Analytics</h2>
                    <p>Generate insightful reports and analytics on staff data, aiding in strategic decision-making and operational efficiency.</p>
                </div>
            </div>
        </div>
        <div class="flip-card" tabindex="0">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <span class="feature-icon">&#128274;</span> <h2 class="feature-title">Secure Access Control</h2>
                </div>
                <div class="flip-card-back">
                    <h2>Secure Access Control</h2>
                    <p>Control access to sensitive staff information with role-based permissions, ensuring data privacy and security.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <h3>ZTF Foundation</h3>
            <p>Get information about all staff, resources, and management tools.</p>
            <ul class="footer-links">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><a href="{{route('indexDepts')}}">Departments</a></li>
                <li><a href="{{route('contact')}}">Contact</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <p class="copyright">&copy; 2025 Zacharias Tannee Fomum Foundation. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal de Succès d'Enregistrement -->
    @if(session('registration_success'))
    <div id="registrationModal" class="modal-overlay" style="display: flex;">
        <div class="modal-content">
            <!-- Icône de succès -->
            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="modal-title">Bravo! 🎉</h1>
                <p class="modal-subtitle">Enregistrement réussi</p>
            </div>

            <!-- Message principal -->
            <div class="modal-message">
                <p class="modal-message-title">
                    <strong>Maintenant pour obtenir vos identifiants d'accès,</strong><br>
                    vous devez vous rendre à la cellule avec :
                </p>
                <ul class="modal-list">
                    <li>Le formulaire imprimé en couleur</li>
                    <li>Deux (2) exemplaires</li>
                    <li>Les documents requis</li>
                </ul>
            </div>

            <!-- Informations de l'enregistrement -->
            <div class="modal-info">
                <p class="modal-info-item">
                    <strong>Nom:</strong> <span>{{ session('ouvrier_name') }}</span>
                </p>
                <p class="modal-info-item">
                    <strong>Numéro d'enregistrement:</strong> <span>#{{ session('ouvrier_id') }}</span>
                </p>
            </div>

            <!-- Boutons d'action -->
            <div class="modal-buttons">
                <a href="{{ route('download.ouvrier.pdf', session('ouvrier_id')) }}" 
                   class="modal-btn modal-btn-primary">
                    <i class="fas fa-download"></i> <span>Télécharger le PDF</span>
                </a>
                <button onclick="closeRegistrationModal()" class="modal-btn modal-btn-secondary">
                    <span>Fermer</span>
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 15px;
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-out;
            width: 100%;
            max-width: 600px;
            padding: 40px;
        }

        /* Modal Header */
        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-icon {
            width: 80px;
            height: 80px;
            background: #10b981;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
        }

        .modal-title {
            color: #1f2937;
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: bold;
        }

        .modal-subtitle {
            color: #6b7280;
            font-size: 16px;
            margin: 0;
        }

        /* Message */
        .modal-message {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .modal-message-title {
            color: #1f2937;
            margin: 0 0 15px 0;
            line-height: 1.6;
            font-size: 14px;
        }

        .modal-list {
            color: #374151;
            margin: 0;
            padding-left: 20px;
            font-size: 14px;
        }

        .modal-list li {
            margin-bottom: 8px;
        }

        /* Info Section */
        .modal-info {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .modal-info-item {
            color: #6b7280;
            margin: 0 0 8px 0;
            font-size: 14px;
        }

        .modal-info-item:last-child {
            margin-bottom: 0;
        }

        .modal-info-item strong {
            color: #1f2937;
            margin-right: 8px;
        }

        .modal-info-item span {
            color: #1f2937;
            font-weight: 500;
        }

        /* Buttons */
        .modal-buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .modal-btn {
            flex: 1;
            min-width: 140px;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
        }

        .modal-btn:active {
            transform: scale(0.98);
        }

        .modal-btn-primary {
            background: #10b981;
            color: white;
        }

        .modal-btn-primary:hover {
            background: #059669;
        }

        .modal-btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .modal-btn-secondary:hover {
            background: #d1d5db;
        }

        /* Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tablette (640px - 1024px) */
        @media (max-width: 1024px) {
            .modal-content {
                padding: 35px;
                max-width: 550px;
            }

            .modal-title {
                font-size: 26px;
            }

            .modal-subtitle {
                font-size: 15px;
            }

            .modal-message {
                padding: 18px;
                margin-bottom: 20px;
            }

            .modal-buttons {
                gap: 10px;
                margin-top: 25px;
            }

            .modal-btn {
                padding: 11px 18px;
                font-size: 13px;
            }
        }

        /* Mobile (< 640px) */
        @media (max-width: 640px) {
            .modal-overlay {
                padding: 10px;
            }

            .modal-content {
                padding: 25px 20px;
                border-radius: 8px;
                max-width: 100%;
            }

            .modal-icon {
                width: 70px;
                height: 70px;
                margin: 0 auto 15px;
                font-size: 35px;
            }

            .modal-title {
                font-size: 22px;
                margin-bottom: 8px;
            }

            .modal-subtitle {
                font-size: 14px;
            }

            .modal-header {
                margin-bottom: 20px;
            }

            .modal-message {
                padding: 15px;
                margin-bottom: 18px;
            }

            .modal-message-title {
                font-size: 13px;
                margin-bottom: 12px;
                line-height: 1.5;
            }

            .modal-list {
                font-size: 13px;
                padding-left: 18px;
            }

            .modal-list li {
                margin-bottom: 6px;
            }

            .modal-info {
                padding: 12px;
                margin-bottom: 20px;
            }

            .modal-info-item {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .modal-buttons {
                flex-direction: column;
                gap: 10px;
                margin-top: 20px;
            }

            .modal-btn {
                width: 100%;
                min-width: unset;
                padding: 12px 15px;
                font-size: 13px;
                gap: 6px;
            }

            .modal-btn span {
                flex: 1;
                text-align: center;
            }

            .modal-btn i {
                min-width: 16px;
            }
        }

        /* Très petits mobiles (< 380px) */
        @media (max-width: 380px) {
            .modal-content {
                padding: 20px 15px;
            }

            .modal-title {
                font-size: 20px;
            }

            .modal-subtitle {
                font-size: 13px;
            }

            .modal-message-title {
                font-size: 12px;
            }

            .modal-list {
                font-size: 12px;
                padding-left: 16px;
            }

            .modal-info-item {
                font-size: 12px;
            }

            .modal-btn {
                padding: 10px 12px;
                font-size: 12px;
            }
        }
    </style>

    <script>
        function closeRegistrationModal() {
            const modal = document.getElementById('registrationModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Fermer la modal en cliquant en dehors
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('registrationModal');
            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        closeRegistrationModal();
                    }
                });
            }
        });
    </script>
    @endif

    <script src="{{ asset('js/home.js') }}" defer></script>
    <script src="{{asset('js/homeFeatures.js')}}" defer></script>
</body>
</html>
