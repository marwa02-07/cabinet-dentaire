<?php 
// Vérifications défensives pour les variables
$user = $user ?? [];
$rendezVous = $rendezVous ?? [];
?>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rédiger une ordonnance - Cabinet Dentaire</title>
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
                <h1 class="h3">Rédiger une ordonnance</h1>
                <p class="text-muted mb-0">Sélectionnez un patient et un rendez-vous pour rédiger l’ordonnance.</p>
            </div>
            <a href="index.php?route=/medecin/dashboard" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour au dashboard
            </a>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-notes-medical"></i> Choisir un rendez-vous</h5>
            </div>
            <div class="card-body">
                <form id="selectForm" method="GET">
                    <input type="hidden" name="route" value="/medecin/ordonnance/create">
                    <div class="mb-3">
                        <label for="rendezVousSelect" class="form-label">Sélectionnez un rendez-vous <span class="text-danger">*</span></label>
                        <select id="rendezVousSelect" name="id" class="form-select" required onchange="updateOrdonnanceInfo()">
                            <option value="">-- Choisir un rendez-vous --</option>
                            <?php if (!empty($rendezVous)): ?>
                                <?php foreach ($rendezVous as $rdv): ?>
                                    <?php
                                    $dateHeure = new DateTime($rdv['date_heure']);
                                    $patientName = htmlspecialchars($rdv['patient_prenom'] . ' ' . $rdv['patient_nom']);
                                    $dateDisplay = $dateHeure->format('d/m/Y H:i');
                                    ?>
                                    <option
                                        value="<?php echo (int)$rdv['rdv_id']; ?>"
                                        data-patient="<?php echo $patientName; ?>"
                                        data-date="<?php echo $dateDisplay; ?>"
                                        data-motif="<?php echo htmlspecialchars($rdv['motif']); ?>"
                                        data-status="<?php echo htmlspecialchars($rdv['statut']); ?>"
                                    >
                                        <?php echo $patientName; ?> — <?php echo $dateDisplay; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Aucun rendez-vous disponible</option>
                            <?php endif; ?>
                        </select>
                        <small class="form-text text-muted">Seuls les rendez-vous non annulés sont affichés.</small>
                    </div>

                    <div id="ordonnanceInfo" style="display:none;" class="mb-4">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informations du rendez-vous</h6>
                            <p><strong>Patient :</strong> <span id="patientInfo">-</span></p>
                            <p><strong>Date & heure :</strong> <span id="dateInfo">-</span></p>
                            <p><strong>Motif :</strong> <span id="motifInfo">-</span></p>
                            <p><strong>Statut :</strong> <span id="statusInfo" class="badge bg-secondary">-</span></p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                        <i class="fas fa-arrow-right"></i> Continuer vers l’ordonnance
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateOrdonnanceInfo() {
            const select = document.getElementById('rendezVousSelect');
            const selected = select.options[select.selectedIndex];
            const submitBtn = document.getElementById('submitBtn');
            const infoBox = document.getElementById('ordonnanceInfo');

            if (!select.value) {
                infoBox.style.display = 'none';
                submitBtn.disabled = true;
                return;
            }

            document.getElementById('patientInfo').textContent = selected.dataset.patient;
            document.getElementById('dateInfo').textContent = selected.dataset.date;
            document.getElementById('motifInfo').textContent = selected.dataset.motif;
            const statusBadge = document.getElementById('statusInfo');
            statusBadge.textContent = selected.dataset.status.charAt(0).toUpperCase() + selected.dataset.status.slice(1);
            statusBadge.className = 'badge';
            switch (selected.dataset.status) {
                case 'confirmé': statusBadge.classList.add('bg-success'); break;
                case 'planifié': statusBadge.classList.add('bg-info'); break;
                case 'complété': statusBadge.classList.add('bg-secondary'); break;
                default: statusBadge.classList.add('bg-warning'); break;
            }

            infoBox.style.display = 'block';
            submitBtn.disabled = false;
        }
    </script>
</body>
</html>
