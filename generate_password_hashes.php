<?php
/**
 * SCRIPT DE GÉNÉRATION DE HASHES DE MOTS DE PASSE
 * Utilise password_hash() avec PASSWORD_DEFAULT (bcrypt)
 * 
 * À utiliser sur votre serveur PHP pour générer les hashes
 * Résultat à mettre dans hospital.sql
 */

// Mots de passe à hasher
$passwords = [
    'patient@test.com' => '123456',
    'medecin@test.com' => '123456',
    'secretaire@test.com' => '123456'
];

echo "═══════════════════════════════════════════════════════════════\n";
echo "GÉNÉRATION DE HASHES PASSWORD_HASH()\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

foreach ($passwords as $email => $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "Email: " . $email . "\n";
    echo "Mot de passe: " . $password . "\n";
    echo "Hash généré:\n";
    echo $hash . "\n";
    echo "───────────────────────────────────────────────────────────\n\n";
}

echo "\n✅ Vous pouvez copier ces hashes dans hospital.sql\n";
echo "⚠️  IMPORTANT: Chaque exécution génère des hashes différents,\n";
echo "   c'est normal! password_hash() génère un salt aléatoire.\n";
echo "   Les hashes ci-dessus ne peuvent être utilisés qu'UNE FOIS.\n";
