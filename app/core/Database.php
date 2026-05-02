<?php

/**
 * Classe Database
 * Gère la connexion PDO à MySQL
 * Affiche les messages de debug
 */

class Database
{
    private $host = 'localhost';
    private $dbname = 'cabinet_dentaire';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $port = 3306;
    
    private $pdo = null;
    public $debug_messages = [];
    

    public function connect()
    {
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
            
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $message = "✓ Connexion PDO réussie (host: {$this->host}, port: {$this->port}, dbname: {$this->dbname})";
            $this->debug_messages[] = $message;
            
            return $this->pdo;
            
        } catch (PDOException $e) {
            $message = "✗ ERREUR PDO : " . $e->getMessage();
            $this->debug_messages[] = $message;
            die($message);
        }
    }
    
    public function getPdo()
    {
        if ($this->pdo === null) {
            $this->connect();
        }
        return $this->pdo;
    }
    
    public function getDebugMessages()
    {
        return $this->debug_messages;
    }
}
