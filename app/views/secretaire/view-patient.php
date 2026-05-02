<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir Patient - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/secretaire-theme.css" rel="stylesheet">
</head>
<body class="secretaire-body">
<nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?route=/secretaire/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Secrétaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/secretaire/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/rendezvous">
                            <i class="fas fa-calendar-check me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/planning">
                            <i class="fas fa-calendar-alt me-1"></i>Planning
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="secretary-pill">
                        <i class="fas fa-user-tie"></i>
                        <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?>
                    </div>
                    <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard">
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-user me-2"></i>Détails du patient</h1>
            <p class="welcome-sub">Informations complètes du patient et historique des rendez-vous.</p>
        </section>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Informations du patient -->
            <div class="col-lg-6 mb-4">
                <div class="panel p-3 p-md-4">
                    <h3 class="panel-title mb-3">
                        <i class="fas fa-id-card me-2"></i>Informations personnelles
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nom</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['nom'] ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Prénom</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['prenom'] ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['email'] ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Téléphone</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['telephone'] ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Date de naissance</label>
                            <p class="form-control-plaintext">
                                <?php echo $patient['date_naissance'] ? htmlspecialchars(date('d/m/Y', strtotime($patient['date_naissance']))) : '-'; ?>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Adresse</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['adresse'] ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations médicales -->
            <div class="col-lg-6 mb-4">
                <div class="panel p-3 p-md-4">
                    <h3 class="panel-title mb-3">
                        <i class="fas fa-heartbeat me-2"></i>Informations médicales
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Groupe sanguin</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['groupe_sanguin'] ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Allergies</label>
                            <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['allergies'] ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Observations</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($patient['observations'] ?? '-'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des rendez-vous -->
        <div class="panel p-3 p-md-4">
            <h3 class="panel-title mb-3">
                <i class="fas fa-calendar-alt me-2"></i>Historique des rendez-vous
            </h3>
            <?php if (empty($rendezvous)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Aucun rendez-vous enregistré pour ce patient.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar"></i> Date & Heure</th>
                                <th><i class="fas fa-user-md"></i> Médecin</th>
                                <th><i class="fas fa-stethoscope"></i> Type</th>
                                <th><i class="fas fa-comment"></i> Motif</th>
                                <th><i class="fas fa-info-circle"></i> Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rendezvous as $rdv): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rdv['date_heure']))); ?></td>
                                    <td><?php echo htmlspecialchars($rdv['dentiste_nom'] . ' ' . $rdv['dentiste_prenom']); ?></td>
                                    <td><?php echo htmlspecialchars($rdv['type_rendez_vous']); ?></td>
                                    <td><?php echo htmlspecialchars($rdv['motif'] ?? '-'); ?></td>
                                    <td>
                                        <span class="badge bg-<?php
                                            switch($rdv['statut']) {
                                                case 'planifié': echo 'secondary'; break;
                                                case 'confirmé': echo 'primary'; break;
                                                case 'complété': echo 'success'; break;
                                                case 'annulé': echo 'danger'; break;
                                                case 'absent': echo 'warning'; break;
                                                default: echo 'secondary';
                                            }
                                        ?>">
                                            <?php echo htmlspecialchars($rdv['statut']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="text-end mt-3">
            <a href="index.php?route=/secretaire/patients" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
            </a>
            <a href="index.php?route=/secretaire/patients/edit&id=<?php echo $patient['id']; ?>" class="btn btn-primary-custom ms-2">
                <i class="fas fa-edit me-1"></i>Modifier
            </a>
            <a href="index.php?route=/secretaire/rendezvous/create&patient_id=<?php echo $patient['id']; ?>" class="btn btn-success ms-2">
                <i class="fas fa-plus me-1"></i>Nouveau RDV
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>