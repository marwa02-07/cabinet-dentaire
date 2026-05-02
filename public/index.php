<?php

/**
 * INDEX.PHP - Front Controller
 * Point d'entrée principal de l'application
 * 
 * Activé le mode DEBUG pour afficher tous les messages
 * Gère le routage et l'exécution des contrôleurs
 */

// ========== MODE DEBUG ==========
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ========== INITIALISATION ==========

// Définir les chemins
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

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
                <p><a href="index.php?route=/login" class="btn btn-primary mt-3">Retour au login</a></p>
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
