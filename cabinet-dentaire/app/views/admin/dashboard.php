<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur - Gestion Hôpital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php
    // Valeurs par défaut pour éviter les erreurs undefined
    $stats = $stats ?? [
        'total_users' => 0,
        'total_medecins' => 0,
        'total_secretaires' => 0,
        'total_patients' => 0
    ];
    ?>
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 60px;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .navbar-brand {
            font-weight: 700;
            font-size: 20px;
            color: white !important;
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin-left: 15px;
        }

        .navbar-custom .nav-link:hover {
            color: white !important;
        }

        .user-info {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-right: 20px;
        }

        .user-info strong {
            color: white;
            font-weight: 600;
        }

        .role-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .stats-card {
            transition: transform 0.2s;
            border: none;
            border-radius: 10px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .action-btn {
            transition: all 0.3s;
            border-radius: 10px;
            font-weight: 600;
        }

        .action-btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hospital-alt me-2"></i>
                Gestion Hôpital - Admin
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/admin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/medecins">
                            <i class="fas fa-user-md me-1"></i>Médecins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/secretaires">
                            <i class="fas fa-user-secret me-1"></i>Secrétaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="user-info">
                        <i class="fas fa-user me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']); ?>
                        <span class="role-badge ms-2">ADMIN</span>
                    </div>
                    <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Administrateur
                    </h1>
                    <small class="text-muted"><?php echo date('d/m/Y H:i'); ?></small>
                </div>

                <!-- Statistiques -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card bg-primary text-white h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-2x mb-3"></i>
                                <h5 class="card-title">Total Utilisateurs</h5>
                                <h2 class="mb-0"><?php echo $stats['total_users']; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card bg-success text-white h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-user-md fa-2x mb-3"></i>
                                <h5 class="card-title">Médecins</h5>
                                <h2 class="mb-0"><?php echo $stats['total_medecins']; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card bg-warning text-white h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-user-secret fa-2x mb-3"></i>
                                <h5 class="card-title">Secrétaires</h5>
                                <h2 class="mb-0"><?php echo $stats['total_secretaires']; ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card bg-info text-white h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-procedures fa-2x mb-3"></i>
                                <h5 class="card-title">Patients</h5>
                                <h2 class="mb-0"><?php echo $stats['total_patients']; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-bolt me-2"></i>Actions Rapides
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Row 1: 4 cards -->
                                <div class="row g-4 mb-4">
                                    <div class="col-md-3 col-6">
                                        <a href="index.php?route=/register-medecin" class="btn btn-success action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                                            <span class="fw-bold">Ajouter Médecin</span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <a href="index.php?route=/register-secretaire" class="btn btn-warning action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                            <i class="fas fa-user-secret fa-2x mb-2"></i>
                                            <span class="fw-bold">Ajouter Secrétaire</span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <a href="index.php?route=/admin/medecins" class="btn btn-primary action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                            <i class="fas fa-list fa-2x mb-2"></i>
                                            <span class="fw-bold">Gérer Médecins</span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <a href="index.php?route=/admin/secretaires" class="btn btn-secondary action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                            <i class="fas fa-cogs fa-2x mb-2"></i>
                                            <span class="fw-bold">Gérer Secrétaires</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Row 2: 2 centered cards -->
                                <div class="row g-4 justify-content-center">
                                    <div class="col-md-3 col-6">
                                        <a href="index.php?route=/register-patient" class="btn btn-info action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-white">
                                            <i class="fas fa-user-plus fa-2x mb-2"></i>
                                            <span class="fw-bold">Ajouter Patient</span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <a href="index.php?route=/admin/patients" class="btn btn-info action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-white">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <span class="fw-bold">Gérer Patients</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>