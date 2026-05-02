<?php
/**
 * TEST_CONNECTION.PHP - AJAX endpoint to test database connection
 */

define('APP_PATH', __DIR__ . '/app');
require_once APP_PATH . '/config/config.php';

header('Content-Type: application/json');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST,
        DB_USER,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo json_encode([
        'connected' => true,
        'error' => null
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'connected' => false,
        'error' => $e->getMessage()
    ]);
}
