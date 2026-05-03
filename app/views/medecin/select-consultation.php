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
    <style>
        :root{
            --bg:#f1f6ff;
            --surface:#ffffff;
            --surface-alt:#f8fbff;
            --text:#0b1736;
            --muted:#5d6b89;
            --line:#dbe7ff;
            --primary:#2563eb;
            --primary-dark:#1e40af;
            --cyan:#06b6d4;
            --shadow:0 16px 36px rgba(37,99,235,0.15);
            --shadow-sm:0 8px 18px rgba(37,99,235,0.12);
        }

        body{
    margin: 0;
    color: var(--text);
    font-family: "Segoe UI", system-ui, -apple-system, sans-serif;

    background:
        radial-gradient(900px 400px at 10% 0%, rgba(37,99,235,0.12), transparent 70%),
        radial-gradient(800px 400px at 90% 10%, rgba(6,182,212,0.10), transparent 70%),
        linear-gradient(180deg, #f8fbff 0%, #eef4ff 40%, #f1f6ff 100%);

    background-repeat: no-repeat;
    background-attachment: fixed;

    padding-top: 84px;
}

        .topbar{
            background: linear-gradient(90deg, #0f3fb5 0%, #2563eb 50%, #0ea5e9 100%);
            box-shadow: 0 8px 24px rgba(15,63,181,.28);
        }

        .topbar .navbar-brand{
            color: #fff !important;
            font-weight: 800;
            letter-spacing: .2px;
        }

        .topbar .nav-link{
            color: rgba(255,255,255,.92) !important;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 12px !important;
            margin-left: 6px;
        }

        .topbar .nav-link:hover{
            background: rgba(255,255,255,.15);
            color: #fff !important;
        }

        .doctor-pill{
            display:flex;
            align-items:center;
            gap:8px;
            color:#fff;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.28);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 13px;
            font-weight: 700;
            margin-right: 8px;
        }

        .dashboard{
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 14px 22px;
        }

        .welcome-banner{
            background:
                linear-gradient(130deg, rgba(37,99,235,.95), rgba(6,182,212,.90)),
                #2563eb;
            color:#fff;
            border-radius: 22px;
            padding: 22px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            margin-bottom: 18px;
        }

        .welcome-banner::after{
            content:"";
            position:absolute;
            right:-80px;
            top:-80px;
            width:220px;
            height:220px;
            border-radius:50%;
            background: rgba(255,255,255,.15);
        }

        .welcome-title{ margin:0; font-size: clamp(1.2rem,2.2vw,1.7rem); font-weight: 900; }
        .welcome-sub{ margin:.45rem 0 0; opacity:.94; max-width: 780px; }

        .panel{
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .panel-head{
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, #fff, var(--surface-alt));
        }

        .panel-title{ margin:0; font-weight:900; color:#10224f; }
        .form-label{ font-weight:700; color:#334155; }
        .form-control, .form-select{ border-radius:10px; border:1px solid #cdddfc; padding:10px 12px; }
        .form-control:focus, .form-select:focus{ border-color: var(--primary); box-shadow: 0 0 0 .2rem rgba(37,99,235,.15); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php?route=/medecin/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Médecin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/medecin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/medecin/rendez-vous">
                            <i class="fas fa-calendar-alt me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/medecin/consultation/select">
                            <i class="fas fa-stethoscope me-1"></i>Consultations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/medecin/profile">
                            <i class="fas fa-user-cog me-1"></i>Mon Profil
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="doctor-pill">
                        <i class="fas fa-user-md"></i>
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
        <div class="welcome-banner">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="welcome-title">Créer une consultation</h1>
                    <p class="welcome-sub">Sélectionnez un rendez-vous avant de passer à la saisie médicale.</p>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/dashboard" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Retour dashboard
                </a>
            </div>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="panel">
            <div class="panel-head">
                <h5 class="panel-title"><i class="fas fa-calendar-check me-2 text-primary"></i>Sélection du rendez-vous</h5>
            </div>
            <div class="p-3 p-md-4">
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
                        <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/dashboard" class="btn btn-outline-secondary">
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
