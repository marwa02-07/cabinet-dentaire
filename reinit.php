<?php
/**
 * REINIT.PHP - Database Initialization Script
 * 
 * This script DELETES and RECREATES all tables
 * Then inserts test users for testing
 * 
 * IMPORTANT: Run this script BEFORE testing the login system
 * Access it at: http://localhost/web-hopital/reinit.php
 */

define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');

// Load config
require_once APP_PATH . '/config/config.php';

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Try to connect to database
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST,
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<h2>✓ Connexion au serveur MySQL réussie</h2>";
    
    // Drop database if exists
    $pdo->exec("DROP DATABASE IF EXISTS " . DB_NAME);
    echo "<h3>✓ Base de données supprimée (si elle existait)</h3>";
    
    // Create database
    $pdo->exec("CREATE DATABASE " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<h3>✓ Base de données créée : " . DB_NAME . "</h3>";
    
    // Select the database
    $pdo->exec("USE " . DB_NAME);
    
    // Create users table
    $sql = "
    CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<h3>✓ Table 'users' créée</h3>";
    
    // Create patients table
    $sql = "
    CREATE TABLE patients (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL UNIQUE,
        telephone VARCHAR(20),
        address VARCHAR(255),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<h3>✓ Table 'patients' créée</h3>";
    
    // Create medecins table
    $sql = "
    CREATE TABLE medecins (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL UNIQUE,
        specialite VARCHAR(255),
        telephone VARCHAR(20),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<h3>✓ Table 'medecins' créée</h3>";
    
    // Create secretaires table
    $sql = "
    CREATE TABLE secretaires (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL UNIQUE,
        telephone VARCHAR(20),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<h3>✓ Table 'secretaires' créée</h3>";
    
    // Create rendez_vous table
    $sql = "
    CREATE TABLE rendez_vous (
        id INT PRIMARY KEY AUTO_INCREMENT,
        patient_id INT NOT NULL,
        medecin_id INT NOT NULL,
        date_consultation DATETIME,
        motif TEXT,
        status VARCHAR(50) DEFAULT 'En attente',
        FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
        FOREIGN KEY (medecin_id) REFERENCES medecins(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<h3>✓ Table 'rendez_vous' créée</h3>";
    
    // Create consultations table
    $sql = "
    CREATE TABLE consultations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        patient_id INT NOT NULL,
        medecin_id INT NOT NULL,
        date_consultation DATETIME,
        diagnostic TEXT,
        ordonnance TEXT,
        notes TEXT,
        FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
        FOREIGN KEY (medecin_id) REFERENCES medecins(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $pdo->exec($sql);
    echo "<h3>✓ Table 'consultations' créée</h3>";
    
    // NOW insert test users
    // Important: Using plain text passwords for development only!
    
    // Patient
    $pdo->exec("INSERT INTO users (email, password, name, role) VALUES ('patient@test.com', '123456', 'Jean Dupont', 'patient')");
    echo "<h4>✓ Utilisateur patient créé : patient@test.com / 123456</h4>";
    
    // Get patient user_id
    $stmt = $pdo->query("SELECT id FROM users WHERE email = 'patient@test.com'");
    $patientUserId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    $pdo->exec("INSERT INTO patients (user_id) VALUES ($patientUserId)");
    
    // Doctor
    $pdo->exec("INSERT INTO users (email, password, name, role) VALUES ('medecin@test.com', '123456', 'Dr. Marie Martin', 'medecin')");
    echo "<h4>✓ Utilisateur médecin créé : medecin@test.com / 123456</h4>";
    
    // Get doctor user_id
    $stmt = $pdo->query("SELECT id FROM users WHERE email = 'medecin@test.com'");
    $medecinUserId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    $pdo->exec("INSERT INTO medecins (user_id, specialite) VALUES ($medecinUserId, 'Généraliste')");
    
    // Secretary
    $pdo->exec("INSERT INTO users (email, password, name, role) VALUES ('secretaire@test.com', '123456', 'Sophie Bernard', 'secretaire')");
    echo "<h4>✓ Utilisateur secrétaire créé : secretaire@test.com / 123456</h4>";
    
    // Get secretary user_id
    $stmt = $pdo->query("SELECT id FROM users WHERE email = 'secretaire@test.com'");
    $secretaireUserId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    $pdo->exec("INSERT INTO secretaires (user_id) VALUES ($secretaireUserId)");
    
    echo "<div style='background-color: #d4edda; padding: 20px; margin-top: 30px; border-radius: 5px;'>";
    echo "<h2>✓ Base de données initialisée avec succès!</h2>";
    echo "<p><strong>Utilisateurs de test créés :</strong></p>";
    echo "<ul>";
    echo "<li>Email: <code>patient@test.com</code> | Mot de passe: <code>123456</code></li>";
    echo "<li>Email: <code>medecin@test.com</code> | Mot de passe: <code>123456</code></li>";
    echo "<li>Email: <code>secretaire@test.com</code> | Mot de passe: <code>123456</code></li>";
    echo "</ul>";
    echo "<p><strong>Vous pouvez maintenant accéder à :</strong></p>";
    echo "<p><a href='index.php?route=/login' style='color: blue; font-weight: bold;'>Aller au formulaire de login (index.php?route=/login)</a></p>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div style='background-color: #f8d7da; padding: 20px; border-radius: 5px;'>";
    echo "<h2>✗ Erreur de connexion à la base de données</h2>";
    echo "<p><strong>" . htmlspecialchars($e->getMessage()) . "</strong></p>";
    echo "<p>Vérifiez que MySQL est en cours d'exécution et vérifiez les paramètres de la base de données dans <code>app/config/config.php</code></p>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Initialisation de la base de données</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        code {
            background-color: #f0f0f0;
            padding: 2px 6px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <!-- HTML wrapper for the PHP output above -->
</body>
</html>
