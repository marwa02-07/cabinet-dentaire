<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Patient - Cabinet Dentaire</title>
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
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-user-edit me-2"></i>Modifier le patient</h1>
            <p class="welcome-sub">Mettre à jour les informations du patient.</p>
        </section>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="panel p-3 p-md-4">
            <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients/update" class="sec-form">
                <input type="hidden" name="patient_id" value="<?php echo $patient['id']; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($patient['nom'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom *</label>
                        <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($patient['prenom'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['email'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" value="<?php echo htmlspecialchars($patient['telephone'] ?? ''); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control" value="<?php echo $patient['date_naissance'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" value="<?php echo htmlspecialchars($patient['adresse'] ?? ''); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Groupe sanguin</label>
                        <select name="groupe_sanguin" class="form-select">
                            <option value="">Sélectionner</option>
                            <option value="A+" <?php echo ($patient['groupe_sanguin'] ?? '') === 'A+' ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo ($patient['groupe_sanguin'] ?? '') === 'A-' ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo ($patient['groupe_sanguin'] ?? '') === 'B+' ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo ($patient['groupe_sanguin'] ?? '') === 'B-' ? 'selected' : ''; ?>>B-</option>
                            <option value="AB+" <?php echo ($patient['groupe_sanguin'] ?? '') === 'AB+' ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo ($patient['groupe_sanguin'] ?? '') === 'AB-' ? 'selected' : ''; ?>>AB-</option>
                            <option value="O+" <?php echo ($patient['groupe_sanguin'] ?? '') === 'O+' ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo ($patient['groupe_sanguin'] ?? '') === 'O-' ? 'selected' : ''; ?>>O-</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Allergies</label>
                        <input type="text" name="allergies" class="form-control" value="<?php echo htmlspecialchars($patient['allergies'] ?? ''); ?>" placeholder="Liste des allergies">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Observations</label>
                    <textarea name="observations" class="form-control" rows="3" placeholder="Notes médicales importantes"><?php echo htmlspecialchars($patient['observations'] ?? ''); ?></textarea>
                </div>
                <div class="text-end">
                    <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients" class="btn btn-outline-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary-custom ms-2">
                        <i class="fas fa-save me-1"></i>Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
