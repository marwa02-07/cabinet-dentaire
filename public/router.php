<?php
/**
 * Routeur simple pour le projet hôpital
 * Utilise les paramètres GET pour les routes
 * URL : index.php?route=/login
 * 
 * Définir le chemin racine
 */
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

// Autoloader simple
spl_autoload_register(function ($class) {
    // Chercher d'abord dans les contrôleurs
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

// Charger les routes
$routes = include ROOT_PATH . '/routes/web.php';

// Récupérer la méthode et la route
$method = $_SERVER['REQUEST_METHOD'];
$uri = isset($_GET['route']) ? $_GET['route'] : '/login';

// Normaliser l'URI
if (empty($uri)) {
    $uri = '/login';
}

// S'assurer que l'URI commence par /
if (strpos($uri, '/') !== 0) {
    $uri = '/' . $uri;
}

// Chercher la route correspondante
$routeFound = false;

// Fonction pour matcher les routes avec paramètres
function matchRoute($uri, $routePattern) {
    // Convertir le pattern de route en regex
    $pattern = preg_replace('/\/:id$/', '/(?<id>\d+)', $routePattern);
    $pattern = '#^' . $pattern . '$#';
    
    if (preg_match($pattern, $uri, $matches)) {
        return $matches;
    }
    return null;
}

if (isset($routes[$method])) {
    foreach ($routes[$method] as $routePattern => $route) {
        // Vérifier si c'est une route exacte
        if (isset($routes[$method][$uri])) {
            $route = $routes[$method][$uri];
            $controllerName = $route[0];
            $actionName = $route[1];
            
            $controller = new $controllerName();
            
            // Vérifier si l'action existe
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
                $routeFound = true;
                break;
            }
        }
        
        // Vérifier si c'est une route avec paramètre (comme /admin/medecin/edit/:id)
        if (strpos($routePattern, ':id') !== false) {
            $matches = matchRoute($uri, $routePattern);
            if ($matches) {
                $controllerName = $route[0];
                $actionName = $route[1];
                
                $controller = new $controllerName();
                
                // Vérifier si l'action existe et si elle accepte un paramètre id
                if (method_exists($controller, $actionName)) {
                    if (isset($matches['id'])) {
                        $controller->$actionName($matches['id']);
                    } else {
                        $controller->$actionName();
                    }
                    $routeFound = true;
                    break;
                }
            }
        }
    }
}

// Si la route n'est pas trouvée
if (!$routeFound) {
    http_response_code(404);
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head><meta charset='UTF-8'><title>404</title></head>";
    echo "<body style='font-family: Arial; text-align: center; margin-top: 50px;'>";
    echo "<h1>404 - Page non trouvée</h1>";
    echo "<p>Route demandée: " . htmlspecialchars($method) . " " . htmlspecialchars($uri) . "</p>";
    echo "<p><a href='index.php?route=/login'>Retour au login</a></p>";
    echo "</body>";
    echo "</html>";
}
