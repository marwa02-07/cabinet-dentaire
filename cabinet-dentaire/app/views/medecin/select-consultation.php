<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<?php 
// Vérifications défensives pour les variables
$user = $user ?? [];
$medecin = $medecin ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélectionner Consultation - Cabinet Dentaire</title>
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
                <span class="navbar-text text-white me-3"><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></span>
                <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container py-5 mt-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3">Créer une consultation</h1>
                <p class="text-muted mb-0">Sélectionnez un patient et un rendez-vous pour créer une consultation.</p>
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

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-form"></i> Sélection du Rendez-vous</h5>
            </div>
            <div class="card-body">
                <form id="selectForm" method="GET">
                    <input type="hidden" name="route" value="/medecin/consultation/create">
                    <div class="mb-3">
                        <label for="rendezVousSelect" class="form-label">Sélectionnez un rendez-vous <span class="text-danger">*</span></label>
                        <select id="rendezVousSelect" name="id" class="form-select" required onchange="updateConsultationInfo()">
                            <option value="">-- Choisir un rendez-vous --</option>
                            <?php if (!empty($rendezVous)): ?>
                                <?php foreach ($rendezVous as $rdv): ?>
                                    <?php
                                        $dateHeure = new DateTime($rdv['date_heure']);
                                        $patientName = htmlspecialchars($rdv['patient_prenom'] . ' ' . $rdv['patient_nom']);
                                        $motif = htmlspecialchars($rdv['motif']);
                                        $dateDisplay = $dateHeure->format('d/m/Y H:i');
                                    ?>
                                    <option 
                                        value="<?php echo (int)$rdv['rdv_id']; ?>"
                                        data-patient="<?php echo $patientName; ?>"
                                        data-date="<?php echo $dateDisplay; ?>"
                                        data-motif="<?php echo $motif; ?>"
                                        data-status="<?php echo htmlspecialchars($rdv['statut']); ?>"
                                    >
                                        <?php echo $patientName; ?> - <?php echo $dateDisplay; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Aucun rendez-vous disponible</option>
                            <?php endif; ?>
                        </select>
                        <small class="form-text text-muted">Seuls les rendez-vous non annulés apparaissent.</small>
                    </div>

                    <!-- Informations du rendez-vous sélectionné -->
                    <div id="consultationInfo" style="display: none;">
                        <div class="alert alert-info">
                            <h6 class="mb-3"><i class="fas fa-info-circle"></i> Détails du rendez-vous sélectionné</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Patient :</strong> 
                                        <span id="patientInfo">-</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Date & Heure :</strong> 
                                        <span id="dateInfo">-</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <strong>Motif :</strong> 
                                        <span id="motifInfo">-</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <strong>Statut :</strong> 
                                        <span id="statusInfo" class="badge">-</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <i class="fas fa-arrow-right"></i> Continuer vers la consultation
                        </button>
                        <a href="index.php?route=/medecin/dashboard" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateConsultationInfo() {
            const select = document.getElementById('rendezVousSelect');
            const selectedOption = select.options[select.selectedIndex];
            const submitBtn = document.getElementById('submitBtn');
            const infoDiv = document.getElementById('consultationInfo');

            if (select.value) {
                document.getElementById('patientInfo').textContent = selectedOption.dataset.patient;
                document.getElementById('dateInfo').textContent = selectedOption.dataset.date;
                document.getElementById('motifInfo').textContent = selectedOption.dataset.motif;
                
                const statusBadge = document.getElementById('statusInfo');
                statusBadge.textContent = selectedOption.dataset.status.charAt(0).toUpperCase() + selectedOption.dataset.status.slice(1);
                
                // Mettre en couleur le badge selon le statut
                statusBadge.className = 'badge';
                switch(selectedOption.dataset.status) {
                    case 'confirmé':
                        statusBadge.classList.add('bg-success');
                        break;
                    case 'planifié':
                        statusBadge.classList.add('bg-info');
                        break;
                    case 'complété':
                        statusBadge.classList.add('bg-secondary');
                        break;
                    default:
                        statusBadge.classList.add('bg-warning');
                }

                infoDiv.style.display = 'block';
                submitBtn.disabled = false;
            } else {
                infoDiv.style.display = 'none';
                submitBtn.disabled = true;
            }
        }
    </script>
</body>
</html>
