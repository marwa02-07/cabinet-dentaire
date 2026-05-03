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
                radial-gradient(1200px 500px at -10% -5%, rgba(37,99,235,.20), transparent 60%),
                radial-gradient(1000px 420px at 100% 0%, rgba(6,182,212,.16), transparent 55%),
                var(--bg);
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
            max-width: 1280px;
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

        .welcome-title{
            margin:0;
            font-size: clamp(1.2rem, 2.2vw, 1.7rem);
            font-weight: 900;
        }

        .welcome-sub{
            margin:.45rem 0 0;
            opacity:.94;
            max-width: 780px;
        }

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
        .info-line{ margin-bottom: 8px; color:#344767; }
        .info-line:last-child{ margin-bottom:0; }
        .history-item{ border:1px solid #e6eeff; border-radius:10px; padding:12px; background:#fbfdff; }
        .status-pill{ border-radius:999px; padding:5px 10px; font-size:12px; font-weight:700; }
        .status-planifie{ background:#fef3c7; color:#92400e; }
        .status-confirme{ background:#dcfce7; color:#166534; }
        .status-complete{ background:#dbeafe; color:#1e40af; }
        .status-annule{ background:#fee2e2; color:#b91c1c; }
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
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                <div>
                    <h1 class="welcome-title">Dossier patient</h1>
                    <p class="welcome-sub">Informations complètes et historique des rendez-vous du patient.</p>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/rendez-vous" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Retour aux rendez-vous
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="panel mb-4">
                    <div class="panel-head">
                        <h5 class="panel-title"><i class="fas fa-user me-2 text-primary"></i>Informations patient</h5>
                    </div>
                    <div class="p-3 p-md-4">
                        <p class="info-line"><strong>Nom :</strong> <?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?></p>
                        <p class="info-line"><strong>Email :</strong> <?php echo htmlspecialchars($patient['email'] ?? ''); ?></p>
                        <p class="info-line"><strong>Téléphone :</strong> <?php echo htmlspecialchars($patient['telephone'] ?? 'Non renseigné'); ?></p>
                        <p class="info-line"><strong>Âge :</strong> <?php echo htmlspecialchars($patient['age'] ?? 'N/A'); ?></p>
                        <p class="info-line"><strong>Date de naissance :</strong> <?php echo htmlspecialchars($patient['date_naissance'] ?? 'N/A'); ?></p>
                        <p class="info-line"><strong>Adresse :</strong> <?php echo htmlspecialchars($patient['adresse'] ?? 'Non renseignée'); ?></p>
                        <p class="info-line"><strong>Allergies :</strong> <?php echo htmlspecialchars($patient['allergies'] ?? 'Aucune'); ?></p>
                        <p class="info-line mb-0"><strong>Observations :</strong> <?php echo nl2br(htmlspecialchars($patient['observations'] ?? 'Aucune')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="panel mb-4">
                    <div class="panel-head">
                        <h5 class="panel-title"><i class="fas fa-calendar-check me-2 text-primary"></i>Rendez-vous du patient</h5>
                    </div>
                    <div class="p-3 p-md-4">
                        <?php if (empty($patientRendezVous)): ?>
                            <p class="text-muted">Aucun rendez-vous trouvé pour ce patient.</p>
                        <?php else: ?>
                            <div class="d-grid gap-2">
                                <?php foreach ($patientRendezVous as $rv): ?>
                                    <?php
                                        $statusClass = 'status-planifie';
                                        if (($rv['statut'] ?? '') === 'confirmé') { $statusClass = 'status-confirme'; }
                                        elseif (($rv['statut'] ?? '') === 'complété') { $statusClass = 'status-complete'; }
                                        elseif (($rv['statut'] ?? '') === 'annulé') { $statusClass = 'status-annule'; }
                                    ?>
                                    <div class="history-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rv['date_heure'] ?? 'now'))); ?></h6>
                                                <p class="mb-1"><strong>Type :</strong> <?php echo htmlspecialchars(ucfirst($rv['type_rendez_vous'] ?? '')); ?></p>
                                                <p class="mb-0"><strong>Motif :</strong> <?php echo htmlspecialchars($rv['motif'] ?? ''); ?></p>
                                            </div>
                                            <span class="status-pill <?php echo $statusClass; ?>"><?php echo htmlspecialchars(ucfirst($rv['statut'])); ?></span>
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
