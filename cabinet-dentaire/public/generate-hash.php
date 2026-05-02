<?php
/**
 * Script pour générer le bon hash bcrypt
 * Affiche le hash correcte pour '123456'
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Générateur de Hash</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .success { background: #d4edda; padding: 15px; border: 1px solid green; border-radius: 5px; margin: 20px 0; }
        .code { background: #f4f4f4; padding: 10px; border-radius: 5px; font-family: monospace; word-break: break-all; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔐 Générateur de Hash Bcrypt</h1>

    <?php
    $password = '123456';
    $hash = password_hash($password, PASSWORD_BCRYPT);
    
    echo "<div class='success'>";
    echo "<h3>✓ Hash généré pour le mot de passe '123456'</h3>";
    echo "<p>Copiez ce hash et utilisez-le dans votre base de données :</p>";
    echo "<div class='code'>" . htmlspecialchars($hash) . "</div>";
    echo "</div>";
    
    // Test
    echo "<h3>Test de vérification :</h3>";
    if (password_verify($password, $hash)) {
        echo "<div class='success'>✓ Le mot de passe '123456' correspond au hash</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border: 1px solid red; border-radius: 5px;'>✗ Erreur de vérification</div>";
    }
    ?>

</div>
</body>
</html>
