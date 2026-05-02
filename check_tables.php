<?php
/**
 * CHECK_TABLES.PHP - AJAX endpoint to check if database tables exist
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
    
    // Get list of tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $requiredTables = ['users', 'patients', 'medecins', 'secretaires', 'rendez_vous', 'consultations'];
    $tablesExist = count(array_intersect($requiredTables, $tables)) === count($requiredTables);
    
    echo json_encode([
        'tables_exist' => $tablesExist,
        'tables' => $tables
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'tables_exist' => false,
        'tables' => [],
        'error' => $e->getMessage()
    ]);
}
