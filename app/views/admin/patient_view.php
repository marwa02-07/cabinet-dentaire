<?php
// filepath: app/views/admin/patient_view.php
$patient = $patient ?? [];
$rendezVous = $rendezVous ?? [];
$consultations = $consultations ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Patient - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand { font-weight: 700; font-size: 20px; color: white !important; }
        .navbar-custom .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; margin-left: 15px; }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active { color: white !important; background: rgba(255,255,255,0.1); border-radius: 8px; }
        .user-info { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin-right: 20px; }
        .user-info strong { color: white; font-weight: 600; }
        .role-badge { background-color: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .custom-card { border: none; border-radius: 15px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .patient-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 15px 15px 0 0; }
        .patient-avatar { width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 600; }
        .info-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 15px; }
        .info-label { font-weight: 600; color: #667eea; margin-bottom: 5px; }
        .info-value { color: #2c3e50; }
        .btn-primary-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 30px; padding: 10px 25px; font-weight: 600; transition: all 0.3s; }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4); color: white; }
        .table th { background: #f8f9fa; border-top: none; font-weight: 600; color: #2c3e50; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-confirme { background: #d4edda; color: #155724; }
        .status-annule { background: #f8d7da; color: #721c24; }
        .status-en-attente { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php?route=/admin/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/admin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/admin/medecins">
                            <i class="fas fa-user-md me-1"></i>Médecins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/admin/secretaires">
                            <i class="fas fa-user-secret me-1"></i>Secrétaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/admin/patients">
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
                    <a href="<?php echo BASE_URL; ?>index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Patient Header -->
    <div class="patient-header">
        <div class="container">
            <div class="d-flex align-items-center gap-4">
                <div class="patient-avatar">
                    <?php echo strtoupper(substr($patient['prenom'] ?? 'P', 0, 1)); ?>
                </div>
                <div>
                    <h1 class="h3 mb-1"><?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?></h1>
                    <p class="mb-0 opacity-75">Patient ID: <?php echo htmlspecialchars($patient['id'] ?? 'N/A'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container" style="margin-top: -30px;">
        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="<?php echo BASE_URL; ?>index.php?route=/admin/patients/edit/<?php echo $patient['id']; ?>" class="btn btn-primary-custom text-white">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="<?php echo BASE_URL; ?>index.php?route=/admin/patients" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>

        <div class="row">
            <!-- Informations Personnelles -->
            <div class="col-lg-6">
                <div class="custom-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-user me-2"></i>Informations Personnelles</h5>
                        <div class="info-section">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="info-label">Nom</div>
                                    <div class="info-value"><?php echo htmlspecialchars($patient['nom'] ?? '-'); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-label">Prénom</div>
                                    <div class="info-value"><?php echo htmlspecialchars($patient['prenom'] ?? '-'); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-label">Email</div>
                                    <div class="info-value"><?php echo htmlspecialchars($patient['email'] ?? '-'); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-label">Téléphone</div>
                                    <div class="info-value"><?php echo htmlspecialchars($patient['telephone'] ?? '-'); ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-label">Date de naissance</div>
                                    <div class="info-value"><?php echo $patient['date_naissance'] ? htmlspecialchars(date('d/m/Y', strtotime($patient['date_naissance']))) : '-'; ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="info-label">Âge</div>
                                    <div class="info-value"><?php echo $patient['age'] ? htmlspecialchars($patient['age'] . ' ans') : '-'; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations Médicales -->
            <div class="col-lg-6">
                <div class="custom-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-heartbeat me-2"></i>Informations Médicales</h5>
                        <div class="info-section">
                            <div class="mb-3">
                                <div class="info-label">Allergies</div>
                                <div class="info-value"><?php echo htmlspecialchars($patient['allergies'] ?? 'Aucune'); ?></div>
                            </div>
                            <div class="mb-3">
                                <div class="info-label">Groupe Sanguin</div>
                                <div class="info-value"><?php echo htmlspecialchars($patient['groupe_sanguin'] ?? 'Non spécifié'); ?></div>
                            </div>
                            <div>
                                <div class="info-label">Adresse</div>
                                <div class="info-value"><?php echo nl2br(htmlspecialchars($patient['adresse'] ?? '-')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rendez-vous -->
        <div class="custom-card">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="fas fa-calendar-alt me-2"></i>Rendez-vous (<?php echo count($rendezVous); ?>)</h5>
                <?php if (empty($rendezVous)): ?>
                    <p class="text-muted">Aucun rendez-vous trouvé pour ce patient.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Heure</th>
                                    <th>Type</th>
                                    <th>Dentiste</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rendezVous as $rdv): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rdv['date_heure']))); ?></td>
                                        <td><?php echo htmlspecialchars($rdv['type_rendez_vous'] ?? 'Consultation'); ?></td>
                                        <td><?php echo htmlspecialchars(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo strtolower($rdv['status'] ?? 'en-attente'); ?>">
                                                <?php echo htmlspecialchars($rdv['status'] ?? 'En attente'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Consultations -->
        <div class="custom-card">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="fas fa-stethoscope me-2"></i>Consultations (<?php echo count($consultations); ?>)</h5>
                <?php if (empty($consultations)): ?>
                    <p class="text-muted">Aucune consultation trouvée pour ce patient.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Dentiste</th>
                                    <th>Diagnostic</th>
                                    <th>Traitement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($consultations as $consultation): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($consultation['date_consultation']))); ?></td>
                                        <td><?php echo htmlspecialchars(($consultation['dentiste_prenom'] ?? '') . ' ' . ($consultation['dentiste_nom'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars(substr($consultation['diagnostic'] ?? '', 0, 50)); ?><?php echo strlen($consultation['diagnostic'] ?? '') > 50 ? '...' : ''; ?></td>
                                        <td><?php echo htmlspecialchars(substr($consultation['traitement'] ?? '', 0, 50)); ?><?php echo strlen($consultation['traitement'] ?? '') > 50 ? '...' : ''; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>