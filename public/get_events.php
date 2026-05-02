<?php

// Configurer les sessions (12 heures)
$session_lifetime = 43200;
ini_set('session.gc_maxlifetime', $session_lifetime);
ini_set('session.cookie_lifetime', $session_lifetime);
session_set_cookie_params($session_lifetime, '/');

session_start();

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/controllers/' . $class . '.php',
        APP_PATH . '/models/' . $class . '.php',
        APP_PATH . '/core/' . $class . '.php'
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

header('Content-Type: application/json; charset=UTF-8');

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'patient') {
    http_response_code(403);
    echo json_encode(['error' => 'Accès refusé']);
    exit;
}

$userId = $_SESSION['user_id'];

$patientModel = new Patient();
$patient = $patientModel->findByUserId($userId);

if (!$patient) {
    http_response_code(404);
    echo json_encode(['error' => 'Patient introuvable']);
    exit;
}

$start = $_GET['start'] ?? date('Y-m-d');
$end = $_GET['end'] ?? date('Y-m-d', strtotime('+1 month'));
$startDate = $start . ' 00:00:00';
$endDate = $end . ' 23:59:59';

$database = new Database();
$pdo = $database->getPdo();

try {
    $query = "SELECT rv.*, d.specialite AS dentiste_specialite, u.nom AS dentiste_nom, u.prenom AS dentiste_prenom
              FROM rendez_vous rv
              LEFT JOIN dentistes d ON rv.dentiste_id = d.id
              LEFT JOIN users u ON d.user_id = u.id
              WHERE rv.patient_id = :patient_id
              AND rv.date_heure BETWEEN :start AND :end
              ORDER BY rv.date_heure ASC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':patient_id', $patient['id'], PDO::PARAM_INT);
    $stmt->bindParam(':start', $startDate);
    $stmt->bindParam(':end', $endDate);
    $stmt->execute();
    $rendezvous = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
    exit;
}

function getStatusColor($status)
{
    $status = strtolower(trim($status));
    switch ($status) {
        case 'confirmed':
        case 'confirmé':
            return '#28a745';
        case 'cancelled':
        case 'annulé':
            return '#dc3545';
        case 'completed':
        case 'complété':
            return '#6c757d';
        case 'pending':
        case 'planifié':
        case 'planifie':
        default:
            return '#0d6efd';
    }
}

$events = [];
foreach ($rendezvous as $rdv) {
    $startTime = $rdv['date_heure'] ?? null;
    $endTime = $startTime ? date('Y-m-d H:i:s', strtotime($startTime . ' + ' . ($rdv['duree_minutes'] ?? 30) . ' minutes')) : null;
    $status = $rdv['status'] ?? $rdv['statut'] ?? 'pending';
    $events[] = [
        'id' => $rdv['id'] ?? null,
        'title' => trim((($rdv['type_rendez_vous'] ?? 'Rendez-vous') . ' - ' . ($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? ''))),
        'start' => $startTime,
        'end' => $endTime,
        'backgroundColor' => getStatusColor($status),
        'borderColor' => getStatusColor($status),
        'textColor' => '#ffffff',
        'extendedProps' => [
            'status' => $status,
            'dentiste' => trim(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')),
            'type' => $rdv['type_rendez_vous'] ?? '',
            'motif' => $rdv['motif'] ?? ''
        ]
    ];
}

echo json_encode($events);
