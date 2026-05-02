<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Rendez-vous - Cabinet Dentaire</title>
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
            <h1 class="welcome-title"><i class="fas fa-calendar-edit me-2"></i>Modifier le rendez-vous</h1>
            <p class="welcome-sub">Mettre à jour les informations du rendez-vous.</p>
        </section>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="panel p-3 p-md-4">
            <form method="POST" action="index.php?route=/secretaire/rendezvous/update" class="sec-form">
                <input type="hidden" name="rendezvous_id" value="<?php echo $rendezvous['id']; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient *</label>
                        <select name="patient_id" class="form-select" required>
                            <option value="">Sélectionner un patient</option>
                            <?php foreach ($patients as $p): ?>
                                <option value="<?php echo $p['id']; ?>" <?php echo ($rendezvous['patient_id'] ?? '') == $p['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(($p['prenom'] ?? '') . ' ' . ($p['nom'] ?? '')); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dentiste *</label>
                        <select name="dentiste_id" class="form-select" required>
                            <option value="">Sélectionner un dentiste</option>
                            <?php foreach ($dentistes as $d): ?>
                                <option value="<?php echo $d['id']; ?>" <?php echo ($rendezvous['dentiste_id'] ?? '') == $d['id'] ? 'selected' : ''; ?>>
                                    Dr. <?php echo htmlspecialchars(($d['prenom'] ?? '') . ' ' . ($d['nom'] ?? '')); ?> - <?php echo htmlspecialchars($d['specialite'] ?? ''); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date et Heure *</label>
                        <input type="datetime-local" name="date_heure" class="form-control" value="<?php echo $rendezvous['date_heure'] ? date('Y-m-d\TH:i', strtotime($rendezvous['date_heure'])) : ''; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Durée (minutes)</label>
                        <select name="duree_minutes" class="form-select">
                            <option value="15" <?php echo ($rendezvous['duree_minutes'] ?? 30) == 15 ? 'selected' : ''; ?>>15 minutes</option>
                            <option value="30" <?php echo ($rendezvous['duree_minutes'] ?? 30) == 30 ? 'selected' : ''; ?>>30 minutes</option>
                            <option value="45" <?php echo ($rendezvous['duree_minutes'] ?? 30) == 45 ? 'selected' : ''; ?>>45 minutes</option>
                            <option value="60" <?php echo ($rendezvous['duree_minutes'] ?? 30) == 60 ? 'selected' : ''; ?>>60 minutes</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type de rendez-vous *</label>
                        <select name="type_rendez_vous" class="form-select" required>
                            <option value="consultation" <?php echo ($rendezvous['type_rendez_vous'] ?? '') === 'consultation' ? 'selected' : ''; ?>>Consultation</option>
                            <option value="nettoyage" <?php echo ($rendezvous['type_rendez_vous'] ?? '') === 'nettoyage' ? 'selected' : ''; ?>>Nettoyage</option>
                            <option value="extraction" <?php echo ($rendezvous['type_rendez_vous'] ?? '') === 'extraction' ? 'selected' : ''; ?>>Extraction</option>
                            <option value="traitement" <?php echo ($rendezvous['type_rendez_vous'] ?? '') === 'traitement' ? 'selected' : ''; ?>>Traitement</option>
                            <option value="blanchiment" <?php echo ($rendezvous['type_rendez_vous'] ?? '') === 'blanchiment' ? 'selected' : ''; ?>>Blanchiment</option>
                            <option value="radio" <?php echo ($rendezvous['type_rendez_vous'] ?? '') === 'radio' ? 'selected' : ''; ?>>Radio</option>
                            <option value="autre" <?php echo ($rendezvous['type_rendez_vous'] ?? '') === 'autre' ? 'selected' : ''; ?>>Autre</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Motif</label>
                        <input type="text" name="motif" class="form-control" value="<?php echo htmlspecialchars($rendezvous['motif'] ?? ''); ?>" placeholder="Motif du rendez-vous">
                    </div>
                </div>
                <div class="text-end">
                    <a href="index.php?route=/secretaire/rendezvous" class="btn btn-outline-secondary">Annuler</a>
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
