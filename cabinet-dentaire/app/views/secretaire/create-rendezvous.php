<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Rendez-vous - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/secretaire-dashboard.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-hospital"></i> Cabinet Dentaire
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/dashboard">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/patients">
                            <i class="fas fa-users"></i> Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/rendezvous">
                            <i class="fas fa-calendar-alt"></i> Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/planning">
                            <i class="fas fa-clock"></i> Planning
                        </a>
                    </li>
                </ul>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <strong><?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'Utilisateur'; ?></strong>
                    <span class="role-badge">Secrétaire</span>
                    <a href="index.php?route=/logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <!-- Header -->
        <section class="dashboard-header">
            <h1><i class="fas fa-calendar-plus"></i> Nouveau Rendez-vous</h1>
            <p>Créer un nouveau rendez-vous</p>
        </section>

        <!-- Messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="index.php?route=/secretaire/rendezvous/store">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Patient *</label>
                            <select name="patient_id" class="form-select" required>
                                <option value="">Sélectionner un patient</option>
                                <?php foreach ($patients as $p): ?>
                                    <option value="<?php echo $p['id']; ?>">
                                        <?php echo htmlspecialchars(($p['prenom'] ?? '') . ' ' . ($p['nom'] ?? '')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date et Heure *</label>
                            <input type="datetime-local" name="date_heure" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type de rendez-vous *</label>
                            <select name="type_rendez_vous" id="type_rendez_vous" class="form-select" required>
                                <option value="">Sélectionner un type</option>
                                <option value="consultation">Consultation</option>
                                <option value="nettoyage">Nettoyage</option>
                                <option value="extraction">Extraction</option>
                                <option value="traitement">Traitement</option>
                                <option value="blanchiment">Blanchiment</option>
                                <option value="radio">Radio</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dentiste *</label>
                            <select name="dentiste_id" id="dentiste_id" class="form-select" required>
                                <option value="">Sélectionner un dentiste</option>
                                <?php foreach ($dentistes as $d): ?>
                                    <?php 
                                    // Normaliser la spécialité pour le filtrage
                                    $specialiteLower = strtolower($d['specialite'] ?? 'chirurgie dentaire');
                                    ?>
                                    <option value="<?php echo $d['id']; ?>" data-specialite="<?php echo htmlspecialchars($specialiteLower); ?>">
                                        Dr. <?php echo htmlspecialchars(($d['prenom'] ?? '') . ' ' . ($d['nom'] ?? '')); ?> - <?php echo htmlspecialchars($d['specialite'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Durée (minutes)</label>
                            <select name="duree_minutes" class="form-select">
                                <option value="15">15 minutes</option>
                                <option value="30" selected>30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">60 minutes</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Motif</label>
                            <input type="text" name="motif" class="form-control" placeholder="Motif du rendez-vous">
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="index.php?route=/secretaire/rendezvous" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>