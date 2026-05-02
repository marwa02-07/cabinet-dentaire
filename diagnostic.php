<?php
/**
 * DIAGNOSTIC.PHP - System Diagnostic Tool
 * 
 * This page helps diagnose connection and database issues
 * Access at: http://localhost/web-hopital/diagnostic.php
 */

define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');

// Load config
require_once APP_PATH . '/config/config.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Diagnostic du système</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-ok { color: #28a745; font-weight: bold; }
        .status-error { color: #dc3545; font-weight: bold; }
        code { background-color: #f0f0f0; padding: 2px 6px; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Diagnostic du système</h1>
        
        <!-- PHP Version -->
        <div class="alert alert-info">
            <h5>Version PHP</h5>
            <p><span class="status-ok">✓</span> PHP <?php echo phpversion(); ?></p>
        </div>
        
        <!-- Database Configuration -->
        <div class="alert alert-info">
            <h5>Configuration de la base de données</h5>
            <ul>
                <li>Hôte: <code><?php echo DB_HOST; ?></code></li>
                <li>Utilisateur: <code><?php echo DB_USER; ?></code></li>
                <li>Base de données: <code><?php echo DB_NAME; ?></code></li>
            </ul>
        </div>
        
        <!-- Database Connection Test -->
        <div class="alert" id="connection_alert">
            <h5>Test de connexion MySQL</h5>
            <p id="connection_status">Vérification en cours...</p>
        </div>
        
        <!-- Tables Check -->
        <div class="alert" id="tables_alert">
            <h5>Vérification des tables</h5>
            <p id="tables_status">En attente...</p>
        </div>
        
        <!-- Test Users Check -->
        <div class="alert" id="users_alert">
            <h5>Vérification des utilisateurs de test</h5>
            <p id="users_status">En attente...</p>
        </div>
        
        <!-- Session Test -->
        <div class="alert alert-warning">
            <h5>Test de session</h5>
            <?php
            session_start();
            $_SESSION['test_session'] = time();
            if (isset($_SESSION['test_session'])) {
                echo "<p><span class='status-ok'>✓</span> Les sessions PHP fonctionnent correctement</p>";
            } else {
                echo "<p><span class='status-error'>✗</span> Problème avec les sessions PHP</p>";
            }
            ?>
        </div>
        
        <!-- Quick Links -->
        <div class="alert alert-success">
            <h5>Liens utiles</h5>
            <ul>
                <li><a href="reinit.php">Réinitialiser la base de données (reinit.php)</a></li>
                <li><a href="public/index.php?route=/login">Aller au formulaire de login</a></li>
            </ul>
        </div>
    </div>
    
    <script>
        // Test database connection
        fetch('test_connection.php')
            .then(response => response.json())
            .then(data => {
                const alert = document.getElementById('connection_alert');
                const status = document.getElementById('connection_status');
                
                if (data.connected) {
                    alert.classList.remove('alert-info');
                    alert.classList.add('alert-success');
                    status.innerHTML = '<span class="status-ok">✓</span> Connexion MySQL réussie';
                } else {
                    alert.classList.remove('alert-info');
                    alert.classList.add('alert-danger');
                    status.innerHTML = '<span class="status-error">✗</span> Erreur: ' + data.error;
                }
            })
            .catch(error => {
                document.getElementById('connection_alert').classList.add('alert-danger');
                document.getElementById('connection_status').innerHTML = '<span class="status-error">✗</span> Erreur AJAX: ' + error;
            });
        
        // Check tables
        fetch('check_tables.php')
            .then(response => response.json())
            .then(data => {
                const alert = document.getElementById('tables_alert');
                const status = document.getElementById('tables_status');
                
                if (data.tables_exist) {
                    alert.classList.remove('alert-info');
                    alert.classList.add('alert-success');
                    status.innerHTML = '<span class="status-ok">✓</span> Toutes les tables existent<br>';
                    status.innerHTML += 'Tables trouvées: ' + data.tables.join(', ');
                } else {
                    alert.classList.remove('alert-info');
                    alert.classList.add('alert-warning');
                    status.innerHTML = '<span class="status-error">✗</span> Tables manquantes<br>';
                    status.innerHTML += '<a href="reinit.php">Cliquez ici pour initialiser la base de données</a>';
                }
            })
            .catch(error => {
                document.getElementById('tables_alert').classList.add('alert-danger');
                document.getElementById('tables_status').innerHTML = '<span class="status-error">✗</span> Erreur: ' + error;
            });
        
        // Check test users
        fetch('check_users.php')
            .then(response => response.json())
            .then(data => {
                const alert = document.getElementById('users_alert');
                const status = document.getElementById('users_status');
                
                if (data.users_exist) {
                    alert.classList.remove('alert-info');
                    alert.classList.add('alert-success');
                    status.innerHTML = '<span class="status-ok">✓</span> Utilisateurs de test trouvés:<br>';
                    data.users.forEach(user => {
                        status.innerHTML += '• ' + user.email + ' (rôle: ' + user.role + ')<br>';
                    });
                } else {
                    alert.classList.remove('alert-info');
                    alert.classList.add('alert-warning');
                    status.innerHTML = '<span class="status-error">✗</span> Utilisateurs de test non trouvés<br>';
                    status.innerHTML += '<a href="reinit.php">Cliquez ici pour créer les utilisateurs de test</a>';
                }
            })
            .catch(error => {
                document.getElementById('users_alert').classList.add('alert-danger');
                document.getElementById('users_status').innerHTML = '<span class="status-error">✗</span> Erreur: ' + error;
            });
    </script>
</body>
</html>
