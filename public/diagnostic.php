<?php
/**
 * Script de diagnostic - Vérifiez la base de données
 * Accédez à : http://localhost/web-hopital/public/diagnostic.php
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Diagnostic</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; }
        .success { color: green; padding: 15px; background: #d4edda; border: 1px solid green; margin: 10px 0; border-radius: 5px; }
        .error { color: red; padding: 15px; background: #f8d7da; border: 1px solid red; margin: 10px 0; border-radius: 5px; }
        .warning { color: orange; padding: 15px; background: #fff3cd; border: 1px solid orange; margin: 10px 0; border-radius: 5px; }
        .info { color: blue; padding: 15px; background: #d1ecf1; border: 1px solid blue; margin: 10px 0; border-radius: 5px; }
        h1 { color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .code { background: #f4f4f4; padding: 5px 10px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔍 Diagnostic - Système de Login</h1>

    <?php
    // 1. Vérifier la connexion MySQL
    echo "<h2>1️⃣ Connexion MySQL</h2>";
    try {
        $pdo = new PDO('mysql:host=localhost', 'root', '');
        echo "<div class='success'>✓ Connexion MySQL réussie</div>";
    } catch (Exception $e) {
        echo "<div class='error'>✗ Erreur de connexion MySQL : " . $e->getMessage() . "</div>";
        die();
    }

    // 2. Vérifier la base de données
    echo "<h2>2️⃣ Base de données</h2>";
    try {
        $result = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'hospital_db'");
        if ($result->rowCount() > 0) {
            echo "<div class='success'>✓ Base de données hospital_db existe</div>";
        } else {
            echo "<div class='error'>✗ Base de données hospital_db N'EXISTE PAS</div>";
            die();
        }
    } catch (Exception $e) {
        echo "<div class='error'>✗ Erreur : " . $e->getMessage() . "</div>";
        die();
    }

    // 3. Connexion à la base
    echo "<h2>3️⃣ Connexion à hospital_db</h2>";
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=hospital_db;charset=utf8mb4', 'root', '');
        echo "<div class='success'>✓ Connecté à hospital_db</div>";
    } catch (Exception $e) {
        echo "<div class='error'>✗ Erreur : " . $e->getMessage() . "</div>";
        die();
    }

    // 4. Vérifier la table users
    echo "<h2>4️⃣ Table users</h2>";
    try {
        $result = $pdo->query("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'hospital_db' AND TABLE_NAME = 'users'");
        $data = $result->fetch(PDO::FETCH_ASSOC);
        
        if ($data['count'] > 0) {
            echo "<div class='success'>✓ Table users existe</div>";
        } else {
            echo "<div class='error'>✗ Table users N'EXISTE PAS</div>";
            die();
        }
    } catch (Exception $e) {
        echo "<div class='error'>✗ Erreur : " . $e->getMessage() . "</div>";
        die();
    }

    // 5. Vérifier les utilisateurs
    echo "<h2>5️⃣ Utilisateurs dans la base</h2>";
    try {
        $result = $pdo->query("SELECT * FROM users");
        $users = $result->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($users) > 0) {
            echo "<div class='success'>✓ " . count($users) . " utilisateur(s) trouvé(s)</div>";
            
            echo "<table>";
            echo "<tr><th>ID</th><th>Email</th><th>Rôle</th><th>Hash Password</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . $user['role'] . "</td>";
                echo "<td><span class='code'>" . substr($user['password'], 0, 20) . "...</span></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='error'>✗ AUCUN utilisateur dans la base !</div>";
            die();
        }
    } catch (Exception $e) {
        echo "<div class='error'>✗ Erreur : " . $e->getMessage() . "</div>";
        die();
    }

    // 6. Tester les mots de passe
    echo "<h2>6️⃣ Vérification des mots de passe</h2>";
    $testPassword = '123456';
    
    try {
        foreach ($users as $user) {
            // Comparaison simple (sans hashage)
            if ($testPassword === $user['password']) {
                echo "<div class='success'>✓ Password '123456' OK pour " . $user['email'] . "</div>";
            } else {
                echo "<div class='error'>✗ Password '123456' INCORRECT pour " . $user['email'] . "</div>";
            }
        }
    } catch (Exception $e) {
        echo "<div class='error'>✗ Erreur : " . $e->getMessage() . "</div>";
    }

    // 7. Recommandations
    echo "<h2>7️⃣ Si ça ne fonctionne pas</h2>";
    echo "<div class='warning'>";
    echo "<strong>Solutions :</strong><br>";
    echo "1. Supprimer la base et la recréer via phpMyAdmin<br>";
    echo "2. Utiliser les requêtes SQL du fichier README.md<br>";
    echo "3. Vérifier que MySQL utilise le charset utf8mb4<br>";
    echo "</div>";

    // 8. Lien pour retourner au login
    echo "<h2>8️⃣ Retour au login</h2>";
    echo "<div class='info'>";
    echo "Si tout est OK, allez à : <a href='router.php?route=/login'><strong>router.php?route=/login</strong></a>";
    echo "</div>";
    ?>

</div>
</body>
</html>
