<?php

/**
 * HomeController
 * Gère l'affichage de la page d'accueil publique
 * Accessible sans authentification
 */

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {
        // Charger le fichier index.php depuis la racine
        if (!defined('ROOT_PATH')) {
            define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));
        }
        
        $viewPath = ROOT_PATH . '/index.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            // Fallback vers la vue app/views/home/index
            $this->view('home.index', []);
        }
    }
}
