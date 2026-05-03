<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Consultations - Cabinet Dentaire</title>
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
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/patient/consultations">
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
        <section class="welcome-banner patient-page-header-band">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                <div>
                    <h1 class="welcome-title"><i class="fas fa-file-medical-alt me-2"></i>Mes consultations</h1>
                    <p class="welcome-sub mb-0">Consultez vos diagnostics, traitements et ordonnances.</p>
                </div>
                <span class="badge bg-success p-3"><i class="fas fa-prescription-bottle-alt me-2"></i>Ordonnances incluses</span>
            </div>
        </section>

        <a href="<?php echo BASE_URL; ?>index.php?route=/patient/dashboard" class="btn btn-retour mb-4">
            <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
        </a>

        <?php if (empty($consultations)): ?>
            <div class="patient-empty-state">
                <i class="fas fa-file-medical-alt"></i>
                <h4>Aucune consultation</h4>
                <p class="mb-0">Vous n'avez pas encore de consultations enregistrées.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($consultations as $consultation): ?>
                    <div class="col-lg-6">
                        <div class="patient-consult-card">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1 fw-bold"><i class="fas fa-user-md me-2 text-primary"></i>Dr. <?php echo htmlspecialchars(($consultation['dentiste_prenom'] ?? '') . ' ' . ($consultation['dentiste_nom'] ?? '')); ?></h5>
                                    <p class="text-muted mb-0 small fw-semibold"><?php echo htmlspecialchars($consultation['dentiste_specialite'] ?? 'Chirurgie Dentaire'); ?></p>
                                </div>
                                <?php if (!empty($consultation['prix'])): ?>
                                    <span class="patient-prix-badge"><?php echo number_format($consultation['prix'], 2); ?> DH</span>
                                <?php endif; ?>
                            </div>

                            <hr class="border-opacity-25">

                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-calendar-alt me-2 text-primary"></i><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($consultation['date_heure'] ?? '')); ?></p>
                                <p class="mb-0"><i class="fas fa-stethoscope me-2 text-primary"></i><strong>Type :</strong> <?php echo htmlspecialchars(ucfirst($consultation['type_rendez_vous'] ?? 'Consultation')); ?></p>
                            </div>

                            <?php if (!empty($consultation['diagnostic'])): ?>
                                <div class="mb-3">
                                    <span class="patient-diagnostic-badge"><i class="fas fa-search me-1"></i>Diagnostic</span>
                                    <p class="mt-2 mb-0"><?php echo htmlspecialchars($consultation['diagnostic']); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($consultation['traitement_effectue'])): ?>
                                <div class="mb-3">
                                    <span class="patient-diagnostic-badge" style="background:#ecfdf5;color:var(--ok);"><i class="fas fa-check-circle me-1"></i>Traitement</span>
                                    <p class="mt-2 mb-0"><?php echo htmlspecialchars($consultation['traitement_effectue']); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($consultation['dents_traitees'])): ?>
                                <div class="mb-3">
                                    <p class="mb-0"><i class="fas fa-tooth me-2 text-primary"></i><strong>Dents traitées :</strong> <?php echo htmlspecialchars($consultation['dents_traitees']); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($consultation['ordonnance'])): ?>
                                <div class="mb-3">
                                    <span class="badge bg-success"><i class="fas fa-prescription-bottle-alt me-1"></i> Ordonnance disponible</span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($consultation['notes'])): ?>
                                <div class="mt-3 pt-3 border-top">
                                    <p class="mb-0 text-muted small"><i class="fas fa-sticky-note me-1"></i><?php echo htmlspecialchars($consultation['notes']); ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="mt-3">
                                <a href="<?php echo BASE_URL; ?>index.php?route=/patient/consultation/print&id=<?php echo (int)$consultation['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-print me-1"></i>Imprimer la consultation
                                </a>
                            </div>

                            <?php if (!empty($consultation['ordonnance'])): ?>
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fw-bold"><i class="fas fa-prescription-bottle-alt text-success me-2"></i>Ordonnance</h6>
                                        <small class="text-muted"><i class="fas fa-calendar me-1"></i><?php echo date('d/m/Y', strtotime($consultation['ordonnance']['date_creation'] ?? '')); ?></small>
                                    </div>

                                    <?php if (!empty($consultation['ordonnance']['medicaments'])): ?>
                                        <div class="mb-3 p-3 rounded" style="background:var(--surface-alt);border:1px solid var(--line);">
                                            <strong><i class="fas fa-pills me-2"></i>Médicaments :</strong>
                                            <ul class="mt-2 mb-0">
                                                <?php foreach ($consultation['ordonnance']['medicaments'] as $med): ?>
                                                    <li class="mb-2">
                                                        <strong><?php echo htmlspecialchars($med['nom_medicament']); ?></strong>
                                                        <?php if (!empty($med['dosage'])): ?> - <?php echo htmlspecialchars($med['dosage']); ?><?php endif; ?>
                                                        <?php if (!empty($med['frequence'])): ?>, <?php echo htmlspecialchars($med['frequence']); ?><?php endif; ?>
                                                        <?php if (!empty($med['duree'])): ?> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($med['duree']); ?></span><?php endif; ?>
                                                        <?php if (!empty($med['instructions_medicament'])): ?><br><small class="text-muted">→ <?php echo htmlspecialchars($med['instructions_medicament']); ?></small><?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($consultation['ordonnance']['recommandations'])): ?>
                                        <div class="mb-2">
                                            <strong><i class="fas fa-list-ol me-2"></i>Posologie :</strong>
                                            <p class="mb-0 text-dark"><?php echo nl2br(htmlspecialchars($consultation['ordonnance']['recommandations'])); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($consultation['ordonnance']['instructions'])): ?>
                                        <div class="p-3 rounded" style="background:rgba(217,119,6,.08);border:1px solid rgba(217,119,6,.25);">
                                            <strong><i class="fas fa-info-circle me-2"></i>Instructions :</strong>
                                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($consultation['ordonnance']['instructions'])); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
