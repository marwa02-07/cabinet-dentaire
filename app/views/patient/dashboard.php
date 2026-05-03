<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Patient - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>css/patient-theme.css" rel="stylesheet">
</head>
<body class="patient-body">
    <nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php?route=/patient/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Patient
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/patient/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous/create">
                            <i class="fas fa-calendar-plus me-1"></i>Nouveau rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous">
                            <i class="fas fa-calendar-check me-1"></i>Mes rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/patient/consultations">
                            <i class="fas fa-file-medical-alt me-1"></i>Consultations
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="patient-pill">
                        <i class="fas fa-user"></i>
                        <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?>
                    </div>
                    <a href="<?php echo BASE_URL; ?>index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard">
        <div class="welcome-banner mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                <div>
                    <h1 class="welcome-title">Bonjour <?php echo htmlspecialchars($user['prenom'] ?? ''); ?>, bienvenue dans votre espace patient.</h1>
                    <p class="welcome-sub">
                        Suivez vos rendez-vous, consultez vos comptes-rendus et gerez facilement votre profil.
                    </p>
                </div>
                <span class="clock-badge">
                    <i class="fas fa-clock"></i><?php echo date('d/m/Y H:i'); ?>
                </span>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="kpi">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label">Rendez-vous a venir</div>
                            <div class="value"><?php echo is_array($nextRendezVous) ? count($nextRendezVous) : 0; ?></div>
                        </div>
                        <div class="kpi-icon"><i class="fas fa-calendar-days"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="kpi">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label">Consultations</div>
                            <div class="value"><?php echo isset($stats['consultations']) ? (int) $stats['consultations'] : 0; ?></div>
                        </div>
                        <div class="kpi-icon"><i class="fas fa-file-medical"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="panel p-3 h-100 d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2 class="panel-title h6 mb-0">
                            <i class="fas fa-heart-pulse me-2 text-primary"></i>Résumé rapide
                        </h2>
                        <a href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous" class="btn btn-primary-custom btn-sm">Mes rendez-vous</a>
                    </div>
                    <p class="text-muted small fw-semibold mb-0 mt-2">
                        Retrouvez vos prochains rendez-vous et suivez votre parcours de soin facilement.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-7">
                <div class="panel p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="panel-title h5 mb-0">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Prochains rendez-vous
                        </h2>
                        <a href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous" class="btn btn-primary-custom btn-sm">
                            Voir tout
                        </a>
                    </div>
                    <ul class="rdv-list">
                        <?php if (empty($nextRendezVous)): ?>
                            <li class="rdv-row text-center py-4 text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                Aucun rendez-vous a venir
                            </li>
                        <?php else: ?>
                            <?php foreach ($nextRendezVous as $rdv): ?>
                                <?php
                                $dateHeure = new DateTime($rdv['date_heure']);
                                $now = new DateTime();
                                $diff = $now->diff($dateHeure);

                                $dateFormatted = '';
                                if ($diff->days == 0) {
                                    $dateFormatted = 'Aujourd\'hui a ' . $dateHeure->format('H:i');
                                } elseif ($diff->days == 1) {
                                    $dateFormatted = 'Demain a ' . $dateHeure->format('H:i');
                                } else {
                                    $dateFormatted = $dateHeure->format('d/m/Y') . ' a ' . $dateHeure->format('H:i');
                                }

                                $statutClass = 'status-' . $rdv['statut'];
                                ?>
                                <li class="rdv-row">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div>
                                            <div class="rdv-date">
                                                <i class="fas fa-clock me-1"></i><?php echo htmlspecialchars($dateFormatted); ?>
                                            </div>
                                            <div class="rdv-doctor">
                                                <i class="fas fa-user-md me-1"></i>Dr. <?php echo htmlspecialchars($rdv['dentiste_prenom'] . ' ' . $rdv['dentiste_nom']); ?>
                                            </div>
                                            <div class="rdv-type">
                                                <i class="fas fa-stethoscope me-1"></i><?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'])); ?>
                                            </div>
                                        </div>
                                        <span class="status-pill <?php echo htmlspecialchars($statutClass); ?>">
                                            <?php echo htmlspecialchars(ucfirst($rdv['statut'])); ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <?php if (empty($nextRendezVous)): ?>
                        <div class="mt-3">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous/create" class="btn btn-primary-custom">
                                <i class="fas fa-plus me-1"></i>Prendre un rendez-vous
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="panel p-3 p-md-4 h-100">
                    <div class="mb-3">
                        <h2 class="panel-title h5 mb-1">
                            <i class="fas fa-bolt me-2 text-primary"></i>Actions
                        </h2>
                        <div class="text-muted small fw-semibold">Acces rapide a vos fonctionnalites principales.</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous/create" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-calendar-plus"></i></div>
                                <p class="menu-title">Prendre rendez-vous</p>
                                <p class="menu-desc">Planifiez une consultation avec votre dentiste.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-calendar-check"></i></div>
                                <p class="menu-title">Mes rendez-vous</p>
                                <p class="menu-desc">Consultez vos rendez-vous passes et a venir.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/patient/consultations" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-file-medical-alt"></i></div>
                                <p class="menu-title">Mes consultations</p>
                                <p class="menu-desc">Visualisez vos diagnostics et traitements.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <button type="button" class="menu-card text-start w-100" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <div class="menu-ico"><i class="fas fa-user-cog"></i></div>
                                <p class="menu-title">Mon profil</p>
                                <p class="menu-desc">Consultez vos informations personnelles.</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">
                        <i class="fas fa-user-circle"></i> Mon Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-user"></i> Nom complet</label>
                                <span><?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-envelope"></i> Email</label>
                                <span><?php echo htmlspecialchars($user['email'] ?? ''); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-birthday-cake"></i> Âge</label>
                                <span><?php echo htmlspecialchars($patient['age'] ?? 'Non spécifié'); ?> ans</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-phone"></i> Téléphone</label>
                                <span><?php echo htmlspecialchars($patient['telephone'] ?? 'Non spécifié'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="profile-detail">
                                <label><i class="fas fa-map-marker-alt"></i> Adresse</label>
                                <span><?php echo htmlspecialchars($patient['adresse'] ?? 'Non spécifiée'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                    <a href="<?php echo BASE_URL; ?>index.php?route=/patient/profile" class="btn btn-primary-custom">
                        <i class="fas fa-edit"></i> Modifier le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
