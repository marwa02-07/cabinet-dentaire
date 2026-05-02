<?php
// Script d'installation - Accédez à : http://localhost/web-hopital/public/setup.php

ob_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Hôpital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title mb-4">Installation de la base de données</h1>

                        <?php
                        try {
                            // Connexion à MySQL
                            echo "<div class='alert alert-info'>Tentative de connexion à MySQL...</div>";
                            
                            $pdo = new PDO(
                                'mysql:host=localhost',
                                'root',
                                '',
                                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                            );
                            
                            echo "<div class='alert alert-success'>✓ Connexion à MySQL réussie</div>";
                            
                            // Créer la base de données
                            $pdo->exec("CREATE DATABASE IF NOT EXISTS hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                            echo "<div class='alert alert-success'>✓ Base de données 'hospital_db' créée</div>";
                            
                            // Connexion à la base
                            $pdo = new PDO(
                                'mysql:host=localhost;dbname=hospital_db;charset=utf8mb4',
                                'root',
                                '',
                                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                            );
                            
                            // Créer la table
                            $pdo->exec("DROP TABLE IF EXISTS users");
                            
                            $pdo->exec("
                                CREATE TABLE users (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    nom VARCHAR(100) NOT NULL,
                                    prenom VARCHAR(100) NOT NULL,
                                    email VARCHAR(150) UNIQUE NOT NULL,
                                    password VARCHAR(255) NOT NULL,
                                    role ENUM('patient','medecin','secretaire') NOT NULL DEFAULT 'patient',
                                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    KEY idx_email (email)
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                            ");
                            
                            echo "<div class='alert alert-success'>✓ Table 'users' créée</div>";
                            
                            // Insérer les utilisateurs
                            $stmt = $pdo->prepare(
                                "INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)"
                            );
                            
                            $users = [
                                ['Dupont', 'Jean', 'patient@test.com', '$2y$10$OIJ0aKy0O.AhHkJqq5u5GuJUGCXGU5pQx6T7P4KjEwqC1kKQUfTJW', 'patient'],
                                ['Martin', 'Marie', 'medecin@test.com', '$2y$10$OIJ0aKy0O.AhHkJqq5u5GuJUGCXGU5pQx6T7P4KjEwqC1kKQUfTJW', 'medecin'],
                                ['Bernard', 'Sophie', 'secretaire@test.com', '$2y$10$OIJ0aKy0O.AhHkJqq5u5GuJUGCXGU5pQx6T7P4KjEwqC1kKQUfTJW', 'secretaire']
                            ];
                            
                            foreach ($users as $user) {
                                $stmt->execute($user);
                            }
                            
                            echo "<div class='alert alert-success'>✓ 3 utilisateurs de test insérés</div>";
                            
                            echo "<div class='alert alert-success mt-4'><h5>✓ Installation réussie !</h5></div>";
                            
                            echo "<h4 class='mt-4'>Identifiants de test :</h4>";
                            echo "<table class='table table-bordered'>";
                            echo "<thead class='table-dark'>";
                            echo "<tr><th>Email</th><th>Mot de passe</th><th>Rôle</th></tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            echo "<tr><td>patient@test.com</td><td>password</td><td>Patient</td></tr>";
                            echo "<tr><td>medecin@test.com</td><td>password</td><td>Médecin</td></tr>";
                            echo "<tr><td>secretaire@test.com</td><td>password</td><td>Secrétaire</td></tr>";
                            echo "</tbody>";
                            echo "</table>";
                            
                            echo "<p class='mt-4'><a href='/web-hopital/public/index.php/login' class='btn btn-primary btn-lg'>Aller au login →</a></p>";
                            
                        } catch (PDOException $e) {
                            echo "<div class='alert alert-danger'>";
                            echo "<h5>❌ Erreur de connexion :</h5>";
                            echo "<p><strong>Message :</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
                            echo "</div>";
                            
                            echo "<div class='alert alert-warning'>";
                            echo "<h5>Vérifications :</h5>";
                            echo "<ul>";
                            echo "<li>MySQL est-il lancé dans XAMPP ?</li>";
                            echo "<li>L'utilisateur root a-t-il un mot de passe vide ?</li>";
                            echo "<li>Port MySQL = 3306 ?</li>";
                            echo "</ul>";
                            echo "</div>";
                        } catch (Exception $e) {
                            echo "<div class='alert alert-danger'>";
                            echo "<strong>Erreur :</strong> " . htmlspecialchars($e->getMessage());
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
