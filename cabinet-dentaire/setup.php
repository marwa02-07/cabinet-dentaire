<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Setup</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .success { color: green; padding: 10px; background: #eaffea; border: 1px solid green; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #ffeeee; border: 1px solid red; margin: 10px 0; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #333; color: white; }
    </style>
</head>
<body>
    <h1>Installation Base de Données</h1>

    <?php
    try {
        echo "<div class='success'>Étape 1 : Connexion MySQL...</div>";
        $pdo = new PDO('mysql:host=localhost', 'root', '');
        echo "<div class='success'>✓ Connecté à MySQL</div>";
        
        echo "<div class='success'>Étape 2 : Création base hospital_db...</div>";
        @$pdo->exec("DROP DATABASE IF EXISTS hospital_db");
        $pdo->exec("CREATE DATABASE hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "<div class='success'>✓ Base créée</div>";
        
        echo "<div class='success'>Étape 3 : Connexion à hospital_db...</div>";
        $pdo = new PDO('mysql:host=localhost;dbname=hospital_db;charset=utf8mb4', 'root', '');
        echo "<div class='success'>✓ Connecté à hospital_db</div>";
        
        echo "<div class='success'>Étape 4 : Création table users...</div>";
        @$pdo->exec("DROP TABLE IF EXISTS users");
        $pdo->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                email VARCHAR(150) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('patient','medecin','secretaire') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
        echo "<div class='success'>✓ Table créée</div>";
        
        // Mots de passe EN CLAIR (sans hashage)
        echo "<div class='success'>Étape 5 : Insertion données...</div>";
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['Dupont', 'Jean', 'patient@test.com', '123456', 'patient']);
        $stmt->execute(['Martin', 'Marie', 'medecin@test.com', '123456', 'medecin']);
        $stmt->execute(['Bernard', 'Sophie', 'secretaire@test.com', '123456', 'secretaire']);
        echo "<div class='success'>✓ Données insérées</div>";
        
        echo "<div class='success' style='font-weight: bold; font-size: 16px;'>✓ INSTALLATION RÉUSSIE</div>";
        
        echo "<h2>Identifiants de connexion :</h2>";
        echo "<table>";
        echo "<tr><th>Email</th><th>Mot de passe</th><th>Rôle</th></tr>";
        echo "<tr><td><strong>patient@test.com</strong></td><td><strong>123456</strong></td><td>Patient</td></tr>";
        echo "<tr><td><strong>medecin@test.com</strong></td><td><strong>123456</strong></td><td>Médecin</td></tr>";
        echo "<tr><td><strong>secretaire@test.com</strong></td><td><strong>123456</strong></td><td>Secrétaire</td></tr>";
        echo "</table>";
        
        echo "<h2>Prochaine étape :</h2>";
        echo "<p>Allez à : <strong>http://localhost/web-hopital/public/index.php/login</strong></p>";
        
    } catch (Exception $e) {
        echo "<div class='error'>";
        echo "<strong>❌ ERREUR :</strong><br>";
        echo htmlspecialchars($e->getMessage());
        echo "</div>";
    }
    ?>

</body>
</html>
