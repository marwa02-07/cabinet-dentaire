<?php

/**
 * Classe Model
 * Classe de base pour tous les modèles
 * Initialise la connexion à la base de données
 */

class Model
{
    protected $pdo;
    public $debug_messages = [];
    
    public function __construct()
    {
        try {
            $db = new Database();
            $this->pdo = $db->getPdo();
            $this->debug_messages = array_merge($this->debug_messages, $db->getDebugMessages());
        } catch (Exception $e) {
            $this->debug_messages[] = "✗ Erreur initialisation Model : " . $e->getMessage();
        }
    }
    
    public function getDebugMessages()
    {
        return $this->debug_messages;
    }

    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }
}
