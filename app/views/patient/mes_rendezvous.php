<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Rendez-vous - Cabinet Dentaire</title>
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
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous">
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
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-calendar-alt me-2"></i>Mes rendez-vous</h1>
            <p class="welcome-sub">Consultez tous vos rendez-vous passés et à venir.</p>
        </section>

        <div class="mb-4">
            <a href="<?php echo BASE_URL; ?>index.php?route=/patient/dashboard" class="btn btn-retour">
                <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
            </a>
        </div>

        <?php if (empty($rendezVous)): ?>
            <div class="patient-empty-state">
                <i class="fas fa-calendar-times"></i>
                <h4>Aucun rendez-vous</h4>
                <p>Vous n'avez pas encore de rendez-vous planifié.</p>
                <a href="<?php echo BASE_URL; ?>index.php?route=/patient/rendez-vous/create" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-2"></i>Prendre un rendez-vous
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($rendezVous as $rdv): ?>
                    <div class="col-lg-6">
                        <article class="patient-rdv-card">
                            <div class="patient-rdv-card-header">
                                <div class="dentiste-info">
                                    <h5><i class="fas fa-user-md me-2"></i>Dr. <?php echo htmlspecialchars(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')); ?></h5>
                                    <p><?php echo htmlspecialchars($rdv['dentiste_specialite'] ?? 'Chirurgie dentaire'); ?></p>
                                </div>
                                <div class="dentiste-icon">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                            </div>
                            <div class="patient-rdv-card-body">
                                <div class="patient-rdv-datetime">
                                    <div class="patient-rdv-date">
                                        <i class="fas fa-calendar-day"></i>
                                        <div class="label">Date</div>
                                        <div class="value"><?php echo date('d/m/Y', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                    </div>
                                    <div class="patient-rdv-time">
                                        <i class="fas fa-clock"></i>
                                        <div class="label">Heure</div>
                                        <div class="value"><?php echo date('H:i', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                    </div>
                                </div>

                                <div class="patient-rdv-detail">
                                    <div class="detail-label">
                                        <i class="fas fa-stethoscope"></i>Type de consultation
                                    </div>
                                    <div class="detail-value">
                                        <?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'] ?? 'Consultation')); ?>
                                    </div>
                                </div>

                                <div class="patient-rdv-detail">
                                    <div class="detail-label">
                                        <i class="fas fa-comment-medical"></i>Motif de la visite
                                    </div>
                                    <div class="detail-value">
                                        <?php echo htmlspecialchars($rdv['motif'] ?? 'Non spécifié'); ?>
                                    </div>
                                </div>

                                <div class="mt-3 text-end">
                                    <span class="status-badge status-<?php echo htmlspecialchars($rdv['statut'] ?? 'planifié', ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo ucfirst($rdv['statut'] ?? 'planifié'); ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
