<?php
/**
 * CHECK_USERS.PHP - AJAX endpoint to check if test users exist
 */

define('APP_PATH', __DIR__ . '/app');
require_once APP_PATH . '/config/config.php';

header('Content-Type: application/json');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Get test users
    $stmt = $pdo->query("SELECT email, name, role FROM users WHERE email IN ('patient@test.com', 'medecin@test.com', 'secretaire@test.com')");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'users_exist' => count($users) === 3,
        'users' => $users
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'users_exist' => false,
        'users' => [],
        'error' => $e->getMessage()
    ]);
}
