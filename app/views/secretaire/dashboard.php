<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Secrétaire - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>css/secretaire-theme.css" rel="stylesheet">
</head>
<body class="secretaire-body">
    <nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Secrétaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous">
                            <i class="fas fa-calendar-check me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/planning">
                            <i class="fas fa-calendar-alt me-1"></i>Planning
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="secretary-pill">
                        <i class="fas fa-user-tie"></i>
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
        <div class="welcome-banner">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                <div>
                    <h1 class="welcome-title">Bonjour <?php echo htmlspecialchars($user['prenom'] ?? ''); ?>, espace secrétariat prêt.</h1>
                    <p class="welcome-sub">
                        Organisez les rendez-vous, gérez les patients et suivez le planning quotidien du cabinet.
                    </p>
                </div>
                <span class="clock-badge">
                    <i class="fas fa-clock"></i><?php echo date('d/m/Y H:i'); ?>
                </span>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 col-md-6 col-xl-4 mb-3 mb-xl-0">
                <div class="kpi">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label">Patients enregistrés</div>
                            <div class="value"><?php echo isset($stats['patients']) ? (int) $stats['patients'] : 0; ?></div>
                        </div>
                        <div class="kpi-icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4 mb-3 mb-xl-0">
                <div class="kpi">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label">Rendez-vous aujourd'hui</div>
                            <div class="value"><?php echo isset($stats['appointments_today']) ? (int) $stats['appointments_today'] : 0; ?></div>
                        </div>
                        <div class="kpi-icon"><i class="fas fa-calendar-day"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-xl-4">
                <div class="kpi">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label">Rendez-vous confirmés</div>
                            <div class="value"><?php echo isset($stats['appointments_confirmed']) ? (int) $stats['appointments_confirmed'] : 0; ?></div>
                        </div>
                        <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel p-3 p-md-4 mt-3 mb-4">
            <div class="mb-3">
                <h2 class="panel-title h5 mb-1">
                    <i class="fas fa-compass me-2 text-info"></i>Navigation rapide
                </h2>
                <div class="text-muted small fw-semibold">Accès direct aux principales sections du module secrétaire.</div>
            </div>
            <div class="row g-3">
                <div class="col-12 col-md-6 col-xl-3">
                    <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous" class="menu-card">
                        <div class="menu-ico"><i class="fas fa-calendar-check"></i></div>
                        <p class="menu-title">Rendez-vous</p>
                        <p class="menu-desc">Suivre et mettre à jour les rendez-vous.</p>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients" class="menu-card">
                        <div class="menu-ico"><i class="fas fa-users"></i></div>
                        <p class="menu-title">Patients</p>
                        <p class="menu-desc">Rechercher et gérer les dossiers patients.</p>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <button type="button" class="menu-card text-start w-100" data-bs-toggle="modal" data-bs-target="#profileModal">
                        <div class="menu-ico"><i class="fas fa-user-cog"></i></div>
                        <p class="menu-title">Profil</p>
                        <p class="menu-desc">Consulter mes informations personnelles.</p>
                    </button>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/planning" class="menu-card">
                        <div class="menu-ico"><i class="fas fa-calendar-alt"></i></div>
                        <p class="menu-title">Planning</p>
                        <p class="menu-desc">Visualiser le planning global du cabinet.</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-7">
                <div class="panel p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="panel-title h5 mb-0">
                            <i class="fas fa-calendar-check me-2 text-info"></i>Rendez-vous du jour
                        </h2>
                        <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous" class="btn btn-primary-custom btn-sm">
                            Voir tout
                        </a>
                    </div>
                    <ul class="rdv-list">
                        <?php if (empty($todayAppointments)): ?>
                            <li class="rdv-row text-center py-4 text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                Aucun rendez-vous prévu aujourd'hui
                            </li>
                        <?php else: ?>
                            <?php foreach ($todayAppointments as $rdv): ?>
                                <?php
                                    $rawStatut = mb_strtolower(trim((string) ($rdv['statut'] ?? 'planifié')));
                                    if ($rawStatut === 'planifié') {
                                        $badgeClass = 'status-planifie';
                                    } elseif ($rawStatut === 'confirmé' || $rawStatut === 'confirme') {
                                        $badgeClass = 'status-confirme';
                                    } elseif ($rawStatut === 'complet' || $rawStatut === 'complete') {
                                        $badgeClass = 'status-complete';
                                    } elseif ($rawStatut === 'annulé' || $rawStatut === 'annule') {
                                        $badgeClass = 'status-annule';
                                    } else {
                                        $badgeClass = 'status-planifie';
                                    }
                                ?>
                                <li class="rdv-row">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="d-flex gap-3 align-items-start">
                                            <div class="rdv-time">
                                                <div class="time"><?php echo date('H:i', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                                <div class="date"><?php echo date('d/m/Y', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                            </div>
                                            <div>
                                                <div class="rdv-patient">
                                                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars(($rdv['patient_prenom'] ?? '') . ' ' . ($rdv['patient_nom'] ?? '')); ?>
                                                </div>
                                                <div class="rdv-meta">
                                                    <i class="fas fa-user-md me-1"></i>Dr. <?php echo htmlspecialchars(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')); ?>
                                                </div>
                                                <div class="rdv-meta">
                                                    <i class="fas fa-stethoscope me-1"></i><?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'] ?? 'Consultation')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="status-pill <?php echo $badgeClass; ?>">
                                            <?php echo htmlspecialchars(ucfirst((string) ($rdv['statut'] ?? 'planifié'))); ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <?php if (empty($todayAppointments)): ?>
                        <div class="mt-3">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/create" class="btn btn-primary-custom">
                                <i class="fas fa-plus me-1"></i>Créer un rendez-vous
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="panel p-3 p-md-4 h-100">
                    <div class="mb-3">
                        <h2 class="panel-title h5 mb-1">
                            <i class="fas fa-bolt me-2 text-info"></i>Actions rapides
                        </h2>
                        <div class="text-muted small fw-semibold">Raccourcis vers les tâches de secrétariat.</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients/create" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-user-plus"></i></div>
                                <p class="menu-title">Nouveau patient</p>
                                <p class="menu-desc">Enregistrer un nouveau dossier patient.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/create" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-calendar-plus"></i></div>
                                <p class="menu-title">Nouveau rendez-vous</p>
                                <p class="menu-desc">Planifier rapidement un créneau de consultation.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-users"></i></div>
                                <p class="menu-title">Gérer patients</p>
                                <p class="menu-desc">Consulter et administrer la liste des patients.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/planning" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-calendar-alt"></i></div>
                                <p class="menu-title">Voir planning</p>
                                <p class="menu-desc">Suivre les rendez-vous sur la journée et la semaine.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <button type="button" class="menu-card text-start w-100" data-bs-toggle="modal" data-bs-target="#profileModal">
                                <div class="menu-ico"><i class="fas fa-user-cog"></i></div>
                                <p class="menu-title">Mon profil</p>
                                <p class="menu-desc">Afficher mes informations de secrétaire.</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">
                        <i class="fas fa-user-circle"></i> Mon Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="profile-detail">
                        <label><i class="fas fa-user"></i> Nom complet</label>
                        <span><?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                    </div>
                    <div class="profile-detail">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <span><?php echo htmlspecialchars($user['email'] ?? 'Non disponible'); ?></span>
                    </div>
                    <div class="profile-detail">
                        <label><i class="fas fa-building"></i> Département</label>
                        <span>Réception</span>
                    </div>
                    <div class="profile-detail">
                        <label><i class="fas fa-clock"></i> Horaires</label>
                        <span>08:00 - 17:00</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
