<?php

/**
 * Classe Auth
 * Gère la vérification de l'authentification et des rôles
 * Affiche les messages d'erreur clairs
 */

class Auth
{
    /**
     * Définit les entêtes pour empêcher la mise en cache du contenu
     */
    private static function setNoCacheHeaders()
    {
        if (!headers_sent()) {
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Cache-Control: post-check=0, pre-check=0', false);
            header('Pragma: no-cache');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        }
    }

    /**
     * Vérifie si l'utilisateur est connecté
     */
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        self::setNoCacheHeaders();
        
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Vérifie le rôle de l'utilisateur connecté
     * Si mauvais rôle ou pas connecté, redirige vers login
     */
    public static function role($role)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        self::setNoCacheHeaders();
        
        // Vérifier si connecté
        if (!isset($_SESSION['user_role'])) {
            $_SESSION['login_error'] = 'Accès refusé : veuillez vous reconnecter.';
            header('Location: index.php?route=/login');
            exit();
        }
        
        // Vérifier le rôle (support both "medecin" and "dentiste")
        $allowed = ($role === 'medecin') ? in_array($_SESSION['user_role'], ['medecin', 'dentiste']) : ($_SESSION['user_role'] === $role);
        if (!$allowed) {
            $_SESSION['login_error'] = 'Accès refusé : rôle incorrect.';
            header('Location: index.php?route=/login');
            exit();
        }
    }
    
    /**
     * Retourne les données de l'utilisateur connecté
     */
    public static function user()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (self::check()) {
            return [
                'id' => $_SESSION['user_id'] ?? null,
                'nom' => $_SESSION['user_nom'] ?? '',
                'prenom' => $_SESSION['user_prenom'] ?? '',
                'email' => $_SESSION['user_email'] ?? '',
                'role' => $_SESSION['user_role'] ?? ''
            ];
        }
        
        return null;
    }
}
