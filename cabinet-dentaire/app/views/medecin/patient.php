<?php 
// Vérifications défensives pour les variables
$user = $user ?? [];
$patient = $patient ?? [];
$patientRendezVous = $patientRendezVous ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier patient - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php?route=/medecin/dashboard"><i class="fas fa-tooth"></i> Cabinet Dentaire</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?route=/medecin/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?route=/medecin/rendez-vous">Rendez-vous</a></li>
                </ul>
                <span class="navbar-text text-white me-3"><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container py-5 mt-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3">Dossier patient</h1>
                <p class="text-muted mb-0">Informations du patient et ses rendez-vous.</p>
            </div>
            <a href="index.php?route=/medecin/rendez-vous" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux rendez-vous
            </a>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="fas fa-user"></i> Informations patient</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom :</strong> <?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?></p>
                        <p><strong>Email :</strong> <?php echo htmlspecialchars($patient['email'] ?? ''); ?></p>
                        <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($patient['telephone'] ?? 'Non renseigné'); ?></p>
                        <p><strong>Âge :</strong> <?php echo htmlspecialchars($patient['age'] ?? 'N/A'); ?></p>
                        <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($patient['date_naissance'] ?? 'N/A'); ?></p>
                        <p><strong>Adresse :</strong> <?php echo htmlspecialchars($patient['adresse'] ?? 'Non renseignée'); ?></p>
                        <p><strong>Allergies :</strong> <?php echo htmlspecialchars($patient['allergies'] ?? 'Aucune'); ?></p>
                        <p><strong>Observations :</strong> <?php echo nl2br(htmlspecialchars($patient['observations'] ?? 'Aucune')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="fas fa-calendar-check"></i> Rendez-vous du patient</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($patientRendezVous)): ?>
                            <p class="text-muted">Aucun rendez-vous trouvé pour ce patient.</p>
                        <?php else: ?>
                            <div class="list-group">
                                <?php foreach ($patientRendezVous as $rv): ?>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rv['date_heure'] ?? 'now'))); ?></h6>
                                                <p class="mb-1"><strong>Type :</strong> <?php echo htmlspecialchars(ucfirst($rv['type_rendez_vous'] ?? '')); ?></p>
                                                <p class="mb-0"><strong>Motif :</strong> <?php echo htmlspecialchars($rv['motif'] ?? ''); ?></p>
                                            </div>
                                            <span class="badge bg-<?php echo $rv['statut'] === 'planifié' ? 'primary' : ($rv['statut'] === 'confirmé' ? 'success' : ($rv['statut'] === 'complété' ? 'secondary' : 'danger')); ?> align-self-start"><?php echo htmlspecialchars(ucfirst($rv['statut'])); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
