<?php

/**
 * Classe Controller
 * Classe de base pour tous les contrôleurs
 * Gère le chargement des vues
 */

class Controller
{
    public function view($viewName, $data = [])
    {
        // Convertir le nom du fichier (ex: 'auth.login' -> 'auth/login.php')
        $viewPath = __DIR__ . '/../views/' . str_replace('.', '/', $viewName) . '.php';
        
        if (!file_exists($viewPath)) {
            die("✗ Vue introuvable : " . htmlspecialchars($viewName) . " (chemin: {$viewPath})");
        }
        
        // Extraire les données pour les rendre disponibles dans la vue
        if (!empty($data)) {
            extract($data);
        }
        
        include $viewPath;
    }
}
