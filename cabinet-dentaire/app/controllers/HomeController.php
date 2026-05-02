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
        // Afficher la vue home/index
        $this->view('home.index', []);
    }
}
