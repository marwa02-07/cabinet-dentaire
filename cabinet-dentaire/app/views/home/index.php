<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #2c5aa0 0%, #4CAF50 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-custom .nav-link {
            color: #555 !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-custom .nav-link:hover {
            color: #2c5aa0 !important;
        }

        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(135deg, #2c5aa0 0%, #4CAF50 100%);
            transition: width 0.3s ease;
        }

        .navbar-custom .nav-link:hover::after {
            width: 100%;
        }

        .btn-login-nav {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a5a 100%);
            color: white;
            border: none;
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-left: 10px;
        }

        .btn-login-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 90, 160, 0.3);
            color: white;
        }

        /* ===== HERO SECTION ===== */
        #accueil {
            background: linear-gradient(135deg, #f0f8ff 0%, #e8f5e9 100%);
            padding: 100px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 56px;
            font-weight: 700;
            background: linear-gradient(135deg, #2c5aa0 0%, #4CAF50 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            margin-bottom: 25px;
        }

        .hero-content p {
            font-size: 18px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 35px;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-primary-hero {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a5a 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-primary-hero:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(44, 90, 160, 0.4);
            color: white;
        }

        .btn-secondary-hero {
            background: white;
            color: #2c5aa0;
            border: 2px solid #2c5aa0;
            padding: 13px 38px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-secondary-hero:hover {
            background: #2c5aa0;
            color: white;
            transform: translateY(-4px);
        }

        .hero-image {
            text-align: center;
        }

        .hero-icon {
            font-size: 200px;
            color: #4CAF50;
            opacity: 0.8;
        }

        /* ===== SERVICES SECTION ===== */
        #services {
            padding: 100px 0;
            background-color: white;
        }

        .section-title {
            font-size: 48px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 60px;
            background: linear-gradient(135deg, #2c5aa0 0%, #4CAF50 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .service-card {
            background: white;
            border: none;
            border-radius: 15px;
            padding: 40px 30px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(44, 90, 160, 0.15);
        }

        .service-icon {
            font-size: 60px;
            color: #2c5aa0;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70px;
        }

        .service-card:hover .service-icon {
            color: #4CAF50;
            transform: scale(1.1);
        }

        .service-card h3 {
            font-size: 22px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-card p {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
            flex-grow: 1;
            margin-bottom: 0;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== ABOUT SECTION ===== */
        #apropos {
            padding: 100px 0;
            background: linear-gradient(135deg, #f0f8ff 0%, #e8f5e9 100%);
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 60px;
        }

        .about-text h2 {
            font-size: 42px;
            font-weight: 700;
            color: #2c5aa0;
            margin-bottom: 25px;
        }

        .about-text p {
            font-size: 16px;
            color: #666;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .about-features {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .feature-icon {
            font-size: 28px;
            color: #4CAF50;
            flex-shrink: 0;
        }

        .feature-item span {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        .about-image {
            text-align: center;
        }

        .about-illustration {
            font-size: 150px;
            color: #2c5aa0;
            opacity: 0.9;
        }

        /* ===== STATISTICS SECTION ===== */
        #statistiques {
            padding: 100px 0;
            background: white;
        }

        .stat-card {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a5a 100%);
            color: white;
            border-radius: 15px;
            padding: 40px 25px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(44, 90, 160, 0.15);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(44, 90, 160, 0.25);
        }

        .stat-number {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 18px;
            font-weight: 500;
            opacity: 0.9;
        }

        /* ===== CONTACT SECTION ===== */
        #contact {
            padding: 100px 0;
            background: linear-gradient(135deg, #f0f8ff 0%, #e8f5e9 100%);
        }

        .contact-card {
            background: white;
            border-radius: 15px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(44, 90, 160, 0.15);
        }

        .contact-icon {
            font-size: 48px;
            color: #2c5aa0;
            margin-bottom: 20px;
        }

        .contact-card h4 {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .contact-card p {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
            margin: 0;
        }

        /* ===== FOOTER ===== */
        footer {
            background: #1a2a3a;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-brand {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #4CAF50 0%, #2c5aa0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-links {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #4CAF50;
        }

        .footer-socials {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(76, 175, 80, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4CAF50;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .social-icon:hover {
            background: #4CAF50;
            color: white;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            color: #999;
            font-size: 14px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 36px;
            }

            .hero-content p {
                font-size: 16px;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn-primary-hero,
            .btn-secondary-hero {
                width: 100%;
            }

            .hero-icon {
                font-size: 120px;
            }

            .section-title {
                font-size: 36px;
            }

            .about-content {
                flex-direction: column;
                gap: 40px;
            }

            .about-illustration {
                font-size: 100px;
            }

            .stat-number {
                font-size: 36px;
            }

            .navbar-custom .nav-link {
                margin: 5px 0;
            }

            .footer-content {
                flex-direction: column;
                gap: 20px;
            }
        }

        /* ===== SCROLL BEHAVIOR ===== */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#accueil">
                <i class="fas fa-hospital-alt"></i> Gestion Hôpital
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#apropos">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <a href="index.php?route=/login" class="btn btn-login-nav">Se connecter</a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section id="accueil">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Bienvenue à l'Hôpital SantéPlus</h1>
                    <p>
                        Un établissement moderne dédié à la qualité des soins et à votre bien-être.
                        Découvrez notre système de gestion innovant, conçu pour faciliter votre accès aux services médicaux.
                    </p>
                    <div class="hero-buttons">
                        <a href="index.php?route=/login" class="btn btn-primary-hero">Se connecter</a>
                        <div class="dropdown d-inline">
                            <button class="btn btn-secondary-hero dropdown-toggle" type="button" id="dropdownRegister" data-bs-toggle="dropdown" aria-expanded="false">
                                S'inscrire
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownRegister">
                                <li><a class="dropdown-item" href="index.php?route=/register"><i class="fas fa-user"></i> Patient</a></li>
                                <li><a class="dropdown-item" href="index.php?route=/register-medecin"><i class="fas fa-stethoscope"></i> Médecin</a></li>
                                <li><a class="dropdown-item" href="index.php?route=/register-secretaire"><i class="fas fa-headset"></i> Secrétaire</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <div class="hero-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SERVICES SECTION ===== -->
    <section id="services">
        <div class="container">
            <h2 class="section-title">Nos Services</h2>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>Consultation médicale</h3>
                        <p>Des consultations dans plusieurs spécialités avec des médecins qualifiés et expérimentés.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>Gestion des rendez-vous</h3>
                        <p>Prenez et gérez facilement vos rendez-vous en ligne, 24h/24, 7j/7.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Suivi des patients</h3>
                        <p>Accédez à un suivi clair et structuré de vos consultations et votre historique médical.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Assistance administrative</h3>
                        <p>Une équipe disponible pour vous accompagner dans vos démarches administratives.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ABOUT SECTION ===== -->
    <section id="apropos">
        <div class="container">
            <div class="about-content">
                <div class="about-image">
                    <div class="about-illustration">
                        <i class="fas fa-hospital"></i>
                    </div>
                </div>
                <div class="about-text">
                    <h2>À propos de l'Hôpital</h2>
                    <p>
                        L'hôpital est un établissement moderne dédié à la qualité des soins, à l'organisation efficace 
                        des services médicaux et à l'amélioration de l'expérience des patients. Il permet aux patients, 
                        médecins et secrétaires d'accéder à un système de gestion clair et pratique.
                    </p>
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span>Qualité des soins reconnue</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span>Personnel qualifié et expérimenté</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span>Organisation moderne et efficace</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span>Accessibilité et disponibilité</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATISTICS SECTION ===== -->
    <section id="statistiques">
        <div class="container">
            <h2 class="section-title">Nos Statistiques</h2>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Patients</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Médecins</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">20+</div>
                        <div class="stat-label">Services</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Assistance</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CONTACT SECTION ===== -->
    <section id="contact">
        <div class="container">
            <h2 class="section-title">Nous Contacter</h2>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Adresse</h4>
                        <p>123 Rue de la Santé<br>Ville, Code Postal</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Téléphone</h4>
                        <p>+212 6 00 00 00 00<br>Appel gratuit</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email</h4>
                        <p>contact@hopital.com<br>info@hopital.com</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Horaires</h4>
                        <p>Lun - Ven: 08h - 18h<br>Sam: 08h - 13h</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <i class="fas fa-hospital-alt"></i> Gestion Hôpital
                </div>
                <div class="footer-links">
                    <a href="#accueil">Accueil</a>
                    <a href="#services">Services</a>
                    <a href="#apropos">À propos</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="footer-socials">
                    <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Gestion Hôpital SantéPlus - Tous droits réservés</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
