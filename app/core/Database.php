<?php

/**
 * Classe Database
 * Gère la connexion PDO à MySQL
 * Affiche les messages de debug
 */

class Database
{
    private $host = '127.0.0.1';
    private $dbname = 'cabinet_dentaire';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $port = 3306;
    
    private $pdo = null;
    public $debug_messages = [];
 
    public function __construct()
    {
        $this->loadConfiguration();
    }

    private function loadConfiguration()
    {
        if (!defined('APP_PATH')) {
            define('APP_PATH', dirname(__DIR__));
        }

        $configFile = APP_PATH . '/config/config.php';
        if (file_exists($configFile)) {
            require_once $configFile;
        }

        $this->host = defined('DB_HOST') ? DB_HOST : $this->host;
        $this->dbname = defined('DB_NAME') ? DB_NAME : $this->dbname;
        $this->username = defined('DB_USER') ? DB_USER : $this->username;
        $this->password = defined('DB_PASSWORD') ? DB_PASSWORD : $this->password;
        $this->port = defined('DB_PORT') ? (int) DB_PORT : $this->port;
        $this->charset = defined('DB_CHARSET') ? DB_CHARSET : $this->charset;
    }

    public function connect()
    {
        try {
            $hostsToTry = [$this->host];
            if ($this->host === 'localhost') {
                $hostsToTry[] = '127.0.0.1';
            }

            $lastException = null;
            foreach (array_unique($hostsToTry) as $host) {
                try {
                    $dsn = "mysql:host={$host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
                    $this->pdo = new PDO($dsn, $this->username, $this->password, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);

                    $message = "✓ Connexion PDO réussie (host: {$host}, port: {$this->port}, dbname: {$this->dbname})";
                    $this->debug_messages[] = $message;
                    return $this->pdo;
                } catch (PDOException $e) {
                    $lastException = $e;
                }
            }
            
            if ($lastException instanceof PDOException) {
                throw $lastException;
            }

            throw new PDOException("Connexion PDO impossible sans message d'erreur.");
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
