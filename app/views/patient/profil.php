<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Cabinet Dentaire</title>
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
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-user-circle me-2"></i>Mon profil</h1>
            <p class="welcome-sub">Consultez vos informations personnelles et médicales.</p>
        </section>

        <a href="<?php echo BASE_URL; ?>index.php?route=/patient/dashboard" class="btn btn-retour mb-4">
            <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
        </a>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="panel p-4 mb-4">
                    <h4 class="panel-title h5 mb-4"><i class="fas fa-user-circle me-2 text-primary"></i>Informations du compte</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Nom</p>
                            <p class="info-value"><?php echo htmlspecialchars($user['nom'] ?? ''); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Prénom</p>
                            <p class="info-value"><?php echo htmlspecialchars($user['prenom'] ?? ''); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Email</p>
                            <p class="info-value"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Rôle</p>
                            <p class="info-value"><span class="badge bg-primary">Patient</span></p>
                        </div>
                    </div>
                </div>

                <div class="panel p-4">
                    <h4 class="panel-title h5 mb-4"><i class="fas fa-file-medical me-2 text-primary"></i>Informations médicales</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Âge</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['age'] ?? 'Non spécifié'); ?> ans</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Téléphone</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['telephone'] ?? 'Non spécifié'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Date de naissance</p>
                            <p class="info-value"><?php echo !empty($patient['date_naissance']) ? date('d/m/Y', strtotime($patient['date_naissance'])) : 'Non spécifiée'; ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Groupe sanguin</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['groupe_sanguin'] ?? 'Non spécifié'); ?></p>
                        </div>
                        <div class="col-12 mb-3">
                            <p class="info-label">Adresse</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['adresse'] ?? 'Non spécifiée'); ?></p>
                        </div>
                        <div class="col-12 mb-3">
                            <p class="info-label">Allergies</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['allergies'] ?? 'Aucune'); ?></p>
                        </div>
                        <?php if (!empty($patient['observations'])): ?>
                        <div class="col-12">
                            <p class="info-label">Observations médicales</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['observations']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
