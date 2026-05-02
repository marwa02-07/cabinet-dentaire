<?php
/**
 * Script de réinitialisation - Crée/Recrée la base de données
 * Accédez à : http://localhost/web-hopital/public/reinit.php
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation Base de Données</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .success { color: green; padding: 15px; background: #d4edda; border: 1px solid green; margin: 10px 0; border-radius: 5px; }
        .error { color: red; padding: 15px; background: #f8d7da; border: 1px solid red; margin: 10px 0; border-radius: 5px; }
        h1 { color: #333; }
        .button { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .button:hover { background: #0056b3; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔧 Réinitialisation Base de Données</h1>

    <?php
    try {
        // 1. Connexion MySQL
        echo "Étape 1 : Connexion MySQL... ";
        $pdo = new PDO('mysql:host=localhost', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<span style='color: green;'>✓</span><br>";

        // 2. Supprimer la base existante
        echo "Étape 2 : Suppression base existante... ";
        @$pdo->exec("DROP DATABASE IF EXISTS hospital_db");
        echo "<span style='color: green;'>✓</span><br>";

        // 3. Créer la base
        echo "Étape 3 : Création base hospital_db... ";
        $pdo->exec("CREATE DATABASE hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "<span style='color: green;'>✓</span><br>";

        // 4. Connexion à la base
        echo "Étape 4 : Connexion à hospital_db... ";
        $pdo = new PDO('mysql:host=localhost;dbname=hospital_db;charset=utf8mb4', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<span style='color: green;'>✓</span><br>";

        // 5. Créer la table users
        echo "Étape 5 : Création table users... ";
        $pdo->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                email VARCHAR(150) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('patient','medecin','secretaire') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                KEY idx_email (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "<span style='color: green;'>✓</span><br>";

        // 6. Insérer les utilisateurs
        echo "Étape 6 : Insertion utilisateurs... ";
        
        // Mots de passe EN CLAIR (sans hashage)
        $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['Dupont', 'Jean', 'patient@test.com', '123456', 'patient']);
        $stmt->execute(['Martin', 'Marie', 'medecin@test.com', '123456', 'medecin']);
        $stmt->execute(['Bernard', 'Sophie', 'secretaire@test.com', '123456', 'secretaire']);
        echo "<span style='color: green;'>✓</span><br>";

        // Succès
        echo "<div class='success' style='margin-top: 30px;'>";
        echo "<h3>✓ Réinitialisation réussie !</h3>";
        echo "<p><strong>Utilisateurs créés :</strong></p>";
        echo "<ul>";
        echo "<li><strong>patient@test.com</strong> / <strong>123456</strong> (Patient)</li>";
        echo "<li><strong>medecin@test.com</strong> / <strong>123456</strong> (Médecin)</li>";
        echo "<li><strong>secretaire@test.com</strong> / <strong>123456</strong> (Secrétaire)</li>";
        echo "</ul>";
        echo "</div>";

        echo "<a href='router.php?route=/login' class='button'>Aller au Login →</a>";
        echo "<a href='diagnostic.php' class='button' style='background: #6c757d; margin-left: 10px;'>Vérifier la Base →</a>";

    } catch (Exception $e) {
        echo "<div class='error'>";
        echo "<h3>❌ Erreur :</h3>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
        
        echo "<div class='error'>";
        echo "<p><strong>Vérifications :</strong></p>";
        echo "<ul>";
        echo "<li>MySQL est lancé dans XAMPP ?</li>";
        echo "<li>Port MySQL = 3306 ?</li>";
        echo "<li>Utilisateur root sans mot de passe ?</li>";
        echo "</ul>";
        echo "</div>";
    }
    ?>

</div>
</body>
</html>
