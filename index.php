<?php

/**
 * INDEX.PHP - Front Controller & Page d'accueil
 * Point d'entrée principal de l'application
 *
 * Activé le mode DEBUG pour afficher tous les messages
 * Gère le routage et l'exécution des contrôleurs
 * Sert la page d'accueil quand route='/'
 */

// ========== MODE DEBUG ==========
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ========== INITIALISATION ==========

// Définir les chemins
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');

// Définir le chemin de base pour les liens lorsqu'on est dans un sous-dossier
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($scriptDir === '/' || $scriptDir === '\\') {
    define('BASE_URL', '/');
} else {
    define('BASE_URL', rtrim($scriptDir, '/') . '/');
}

// Configurer les sessions pour éviter la déconnexion automatique (12 heures)
$session_lifetime = 43200; // 12 heures en secondes
ini_set('session.gc_maxlifetime', $session_lifetime);
ini_set('session.cookie_lifetime', $session_lifetime);

// ========== SESSION INDÉPENDANTE PAR RÔLE ==========
// Chaque rôle possède son propre cookie de session.
$current_route = isset($_GET['route']) ? $_GET['route'] : '/';

// Table de correspondance route-prefix → session_name
// IMPORTANT : les préfixes /register-* doivent être testés AVANT /register
$session_route_map = [
    '/admin'               => 'SESS_ADMIN',
    '/register-medecin'    => 'SESS_ADMIN',
    '/register-secretaire' => 'SESS_ADMIN',
    '/register-patient'    => 'SESS_ADMIN',
    '/medecin'             => 'SESS_MEDECIN',
    '/login/medecin'       => 'SESS_MEDECIN',
    '/secretaire'          => 'SESS_SECRETAIRE',
    '/api'                 => 'SESS_SECRETAIRE',
    '/patient'             => 'SESS_PATIENT',
];

$session_name = 'PHPSESSID'; // Valeur par défaut (login, logout, home)

foreach ($session_route_map as $prefix => $sname) {
    if (strpos($current_route, $prefix) === 0) {
        $session_name = $sname;
        break;
    }
}

// Pour /login et /logout : détecter la session selon le cookie présent
if ($session_name === 'PHPSESSID') {
    foreach (['SESS_ADMIN', 'SESS_MEDECIN', 'SESS_SECRETAIRE', 'SESS_PATIENT'] as $sname) {
        if (isset($_COOKIE[$sname])) {
            $session_name = $sname;
            break;
        }
    }
}

// CRITIQUE : session_set_cookie_params DOIT être appelé AVANT session_name()
session_set_cookie_params($session_lifetime, '/');
session_name($session_name);

// Démarrer les sessions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========== AUTOLOADER ==========
/**
 * Autoloader simple pour charger les classes
 * Cherche dans : controllers, modèles, classes core
 */
spl_autoload_register(function ($class) {
    // Chercher dans les contrôleurs
    $controllerPath = APP_PATH . '/controllers/' . $class . '.php';
    if (file_exists($controllerPath)) {
        include_once $controllerPath;
        return;
    }

    // Chercher dans les modèles
    $modelPath = APP_PATH . '/models/' . $class . '.php';
    if (file_exists($modelPath)) {
        include_once $modelPath;
        return;
    }

    // Chercher dans les classes core
    $corePath = APP_PATH . '/core/' . $class . '.php';
    if (file_exists($corePath)) {
        include_once $corePath;
        return;
    }
});

// ========== CHARGEMENT DES ROUTES ==========
$routes = include ROOT_PATH . '/routes/web.php';

// ========== PARSING DE L'URL ==========
$method = $_SERVER['REQUEST_METHOD'];
$uri = isset($_GET['route']) ? $_GET['route'] : '/';

// Normaliser l'URI (s'assurer qu'il commence par /)
if (strpos($uri, '/') !== 0) {
    $uri = '/' . $uri;
}

// ========== GESTION DE LA PAGE D'ACCUEIL ==========
if ($uri === '/' && $method === 'GET') {
    // Servir la page d'accueil directement
    ?>
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
        :root {
    --primary: #2563eb;        /* bleu */
    --primary-dark: #1e40af;   /* bleu foncé */
    --secondary: #7c3aed;      /* violet */
    --accent: #10b981;         /* vert moderne */

    --surface: #ffffff;
    --bg: #f4f7ff;

    --text: #0f172a;
    --muted: #64748b;
    --line: #e2e8f0;

    --shadow: 0 14px 35px rgba(37, 99, 235, 0.15);
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Poppins', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            background:
        radial-gradient(1200px 500px at -10% -10%, rgba(37,99,235,0.25), transparent 70%),
        radial-gradient(1000px 400px at 110% 0%, rgba(124,58,237,0.20), transparent 65%),
        radial-gradient(800px 400px at 50% 100%, rgba(16,185,129,0.18), transparent 70%),
        linear-gradient(180deg, #f4f7ff 0%, #eef2ff 100%);
            color: var(--text);
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 5px 22px rgba(15, 23, 42, 0.06);
            padding: .9rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 900;
            letter-spacing: -.2px;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-custom .nav-link {
            color: var(--muted) !important;
            font-weight: 600;
            margin: 0 8px;
            position: relative;
            transition: color .25s ease;
        }

        .navbar-custom .nav-link:hover { color: var(--primary) !important; }

        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 0;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transition: width .25s ease;
        }

        .navbar-custom .nav-link:hover::after { width: 100%; }

        .btn-login-nav {
            border: none;
            border-radius: 999px;
            padding: 9px 22px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(
        135deg,
        #2563eb,
        #7c3aed,
        #10b981
    );
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .btn-login-nav:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(15, 118, 110, 0.28);
        }

        #accueil {
            padding: 84px 0;
            min-height: 88vh;
            display: flex;
            align-items: center;
        }

        .hero-content h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            line-height: 1.15;
            margin-bottom: 16px;
            letter-spacing: -.5px;
            background: linear-gradient(
        135deg,
        #1e40af 0%,   /* bleu foncé */
        #2563eb 40%,  /* bleu */
        #7c3aed 75%,  /* violet */
        #10b981 100%  /* vert */
    );
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1rem;
            color: var(--muted);
            line-height: 1.8;
            margin-bottom: 26px;
            max-width: 580px;
        }

        .hero-buttons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary-hero {
            background: linear-gradient(
        135deg,
        #2563eb,
        #7c3aed,
        #10b981
    );
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .btn-primary-hero:hover {
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(15, 118, 110, 0.3);
        }

        .btn-secondary-hero {
            background: #fff;
            color: var(--primary-dark);
            border: 1.5px solid var(--line);
            padding: 11px 26px;
            border-radius: 12px;
            font-weight: 700;
        }

        .btn-secondary-hero:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .hero-image {
            text-align: center;
        }

        .hero-icon {
            width: 260px;
            height: 260px;
            margin: 0 auto;
            border-radius: 50%;
            background: linear-gradient(145deg, rgba(15, 118, 110, 0.14), rgba(245, 158, 11, 0.18));
            border: 1px solid rgba(15, 118, 110, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 110px;
            color: var(--primary);
            box-shadow: var(--shadow);
        }

        section { padding: 84px 0; }
        #services, #statistiques { background: transparent; }
        #apropos, #contact {
            background: rgba(255, 255, 255, 0.72);
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.9rem);
            font-weight: 900;
            text-align: center;
            margin-bottom: 44px;
            letter-spacing: -.35px;
            color: #0f172a;
        }

        .service-card,
        .contact-card,
        .stat-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(37,99,235,0.2);
            transition: transform .22s ease, box-shadow .22s ease;
            height: 100%;
        }

        .service-card { padding: 30px 22px; text-align: center; }
        .contact-card { padding: 28px 22px; text-align: center; }
        .stat-card {
            padding: 30px 22px;
            text-align: center;
            background: linear-gradient(
        135deg,
        #1e40af,
        #2563eb,
        #7c3aed
    );
            border-color: transparent;
            color: #fff;
        }

        .service-card:hover,
        .contact-card:hover,
        .stat-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 35px rgba(15, 118, 110, 0.18);
        }

        .service-icon,
        .contact-icon {
            width: 68px;
            height: 68px;
            border-radius: 14px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            background: linear-gradient(
        145deg,
        rgba(37,99,235,0.15),
        rgba(124,58,237,0.15),
        rgba(16,185,129,0.15)
    );
    color: var(--primary);
        }

        .service-card h3,
        .contact-card h4 {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--text);
        }

        .service-card p,
        .contact-card p {
            color: var(--muted);
            font-size: .92rem;
            line-height: 1.75;
            margin: 0;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: .88rem;
            font-weight: 700;
            opacity: .92;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 42px;
        }

        .about-text h2 {
            font-size: clamp(1.9rem, 4vw, 2.6rem);
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 14px;
            letter-spacing: -.3px;
        }

        .about-text p {
            color: var(--muted);
            line-height: 1.8;
            margin-bottom: 20px;
            font-size: .96rem;
        }

        .about-features {
            display: grid;
            gap: 10px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px 12px;
        }

        .feature-icon {
            color: var(--primary);
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .feature-item span {
            color: var(--text);
            font-size: .92rem;
            font-weight: 600;
        }

        .about-image { text-align: center; }

        .about-illustration {
            width: 230px;
            height: 230px;
            margin: 0 auto;
            border-radius: 50%;
            border: 1px solid rgba(15, 118, 110, 0.2);
            background: linear-gradient(145deg, rgba(15, 118, 110, 0.16), rgba(245, 158, 11, 0.16));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 92px;
            color: var(--primary);
            box-shadow: var(--shadow);
        }

        footer {
    background: linear-gradient(135deg, #0f172a, #020617);
    color: #e2e8f0;
    padding: 38px 0 24px;
    text-align: center;
}

.footer-content {
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 18px;
}

.footer-brand {
    font-size: 1.35rem;
    font-weight: 900;
    background: linear-gradient(135deg, #2563eb, #7c3aed, #10b981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.footer-links {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
}

.footer-links a {
    color: #cbd5e1;
    text-decoration: none;
    font-size: .9rem;
    font-weight: 600;
}

.footer-links a:hover {
    color: #7c3aed; /* violet au hover */
}

.footer-socials {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.social-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(37, 99, 235, 0.15); /* bleu léger */
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    text-decoration: none;
    transition: transform .2s ease, background .2s ease;
    font-size: 14px;
}

.social-icon:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #2563eb, #7c3aed, #10b981);
    color: #ffffff;
}

.footer-bottom {
    border-top: 1px solid rgba(148, 163, 184, 0.2);
    padding-top: 14px;
    color: #94a3b8;
    font-size: .82rem;
}

        @media (max-width: 768px) {
            .hero-buttons { flex-direction: column; }
            .btn-primary-hero, .btn-secondary-hero { width: 100%; }
            .hero-icon {
                width: 180px;
                height: 180px;
                font-size: 78px;
            }
            .about-content {
                flex-direction: column;
                gap: 26px;
            }
            .about-illustration {
                width: 170px;
                height: 170px;
                font-size: 68px;
            }
            .footer-content {
                flex-direction: column;
                gap: 16px;
            }
            .navbar-custom .nav-link { margin: 4px 0; }
        }

    </style>
</head>
<body>
    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="?route=/">
                <i class="fas fa-tooth"></i> Cabinet Dentaire
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
                <a href="?route=/login" class="btn btn-login-nav">Se connecter</a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section id="accueil">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Bienvenue au Cabinet Dentaire</h1>
                    <p>
                        Un établissement moderne dédié à la qualité des soins et à votre bien-être.
                        Découvrez notre système de gestion innovant, conçu pour faciliter votre accès aux services médicaux.
                    </p>
                    <div class="hero-buttons">
                        <a href="?route=/login" class="btn btn-primary-hero">Se connecter</a>
                        <div class="dropdown d-inline">
                            <button class="btn btn-secondary-hero dropdown-toggle" type="button" id="dropdownRegister" data-bs-toggle="dropdown" aria-expanded="false">
                                S'inscrire
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownRegister">
                                <li><a class="dropdown-item" href="?route=/register"><i class="fas fa-user"></i> Patient</a></li>

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
                        <i class="fas fa-clinic-medical"></i>
                    </div>
                </div>
                <div class="about-text">
                    <h2>À propos du Cabinet</h2>
                    <p>
                        Le cabinet est un établissement moderne dédié à la qualité des soins, à l'organisation efficace
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
                    <i class="fas fa-tooth"></i> Cabinet Dentaire
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
                <p>&copy; 2026 Cabinet Dentaire - Tous droits réservés</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    <?php
    exit(); // Sortir après avoir servi la page d'accueil
}

// ========== EXÉCUTION DU ROUTEUR ==========
$routeFound = false;

function compileRoutePattern($pattern)
{
    $paramNames = [];
    $regex = '';
    $offset = 0;

    while (preg_match('#:([a-zA-Z_][a-zA-Z0-9_]*)#', $pattern, $matches, PREG_OFFSET_CAPTURE, $offset)) {
        $pos = $matches[0][1];
        $paramNames[] = $matches[1][0];
        $regex .= preg_quote(substr($pattern, $offset, $pos - $offset), '#');
        $regex .= '([^/]+)';
        $offset = $pos + strlen($matches[0][0]);
    }

    $regex .= preg_quote(substr($pattern, $offset), '#');
    return ['regex' => '#^' . $regex . '$#', 'params' => $paramNames];
}

if (isset($routes[$method])) {
    // Exact match d'abord
    if (isset($routes[$method][$uri])) {
        $route = $routes[$method][$uri];
    } else {
        // Essayez de trouver une route dynamique avec des segments :id
        foreach ($routes[$method] as $pattern => $routeDefinition) {
            if (strpos($pattern, ':') === false) {
                continue;
            }

            $compiled = compileRoutePattern($pattern);
            if (preg_match($compiled['regex'], $uri, $matches)) {
                array_shift($matches);
                foreach ($compiled['params'] as $index => $name) {
                    $_GET[$name] = isset($matches[$index]) ? urldecode($matches[$index]) : null;
                }
                $route = $routeDefinition;
                break;
            }
        }
    }

    if (isset($route)) {
        try {
            $controllerName = $route[0];
            $actionName = $route[1];

            if (!class_exists($controllerName)) {
                die("✗ ERREUR : Contrôleur '" . htmlspecialchars($controllerName) . "' introuvable");
            }

            $controller = new $controllerName();

            if (!method_exists($controller, $actionName)) {
                die("✗ ERREUR : Méthode '" . htmlspecialchars($actionName) . "' non trouvée dans '" . htmlspecialchars($controllerName) . "'");
            }

            $controller->$actionName();
            $routeFound = true;

        } catch (Exception $e) {
            die("✗ ERREUR lors de l'exécution : " . htmlspecialchars($e->getMessage()));
        }
    }
}

// ========== GESTION DES ROUTES NON TROUVÉES ==========
if (!$routeFound) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>404 - Route non trouvée</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="alert alert-danger">
                <h1>404 - Route non trouvée</h1>
                <p><strong>Méthode :</strong> <?php echo htmlspecialchars($method); ?></p>
                <p><strong>Route :</strong> <?php echo htmlspecialchars($uri); ?></p>
                <p><a href="?route=/login" class="btn btn-primary mt-3">Retour au login</a></p>
            </div>

            <div class="alert alert-info">
                <h4>Routes disponibles :</h4>
                <ul>
                    <li>GET /login</li>
                    <li>POST /login</li>
                    <li>GET /logout</li>
                    <li>GET /patient/dashboard</li>
                    <li>GET /medecin/dashboard</li>
                    <li>GET /secretaire/dashboard</li>
                </ul>
            </div>
        </div>
    </body>
    </html>
    <?php
}
