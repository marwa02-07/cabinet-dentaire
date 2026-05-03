<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Médecin - Cabinet Dentaire</title>
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
            --ok:#16a34a;
            --warn:#d97706;
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
            font-size: clamp(1.3rem, 2.6vw, 1.85rem);
            font-weight: 900;
            letter-spacing: -.3px;
        }

        .welcome-sub{
            margin:.45rem 0 0;
            opacity:.94;
            max-width: 780px;
        }

        .clock-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            border-radius: 999px;
            border:1px solid rgba(255,255,255,.35);
            background: rgba(15,23,42,.16);
            padding: 8px 12px;
            font-weight: 700;
            font-size: 13px;
        }

        .panel{
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
        }

        .panel-title{
            margin:0;
            font-weight: 900;
            letter-spacing: -.2px;
            color: #10224f;
        }

        .kpi{
            padding: 14px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, #fff, var(--surface-alt));
            height: 100%;
        }

        .kpi .label{
            color: var(--muted);
            font-weight: 700;
            font-size: 13px;
        }

        .kpi .value{
            font-size: 30px;
            font-weight: 900;
            line-height: 1.1;
            color: #112a66;
        }

        .kpi-icon{
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            background: linear-gradient(135deg, var(--primary), var(--cyan));
        }

        .rdv-list{
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .rdv-row{
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            padding: 12px;
            border-left: 4px solid var(--primary);
        }

        .rdv-patient{ font-weight: 800; color: #1a2f61; }
        .rdv-date{ font-size: 13px; color: var(--muted); font-weight: 600; }

        .status-pill{
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .status-planifie{ background:#fff7ed; color:var(--warn); }
        .status-confirme{ background:#ecfeff; color:#0f766e; }

        .menu-card{
            display:block;
            text-decoration:none;
            color:inherit;
            border:1px solid var(--line);
            border-radius: 14px;
            padding: 14px;
            background: linear-gradient(180deg, #fff, #f8fbff);
            transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease;
            height: 100%;
        }

        .menu-card:hover{
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
            border-color: #c1d4ff;
            color:inherit;
        }

        .menu-ico{
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom: 10px;
        }

        .menu-title{ margin:0; font-weight: 800; color:#142f6d; }
        .menu-desc{ margin:.35rem 0 0; color:var(--muted); font-size: 13px; font-weight:600; }

        .btn-primary-custom{
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color:#fff;
            border-radius: 10px;
            padding: 8px 14px;
            font-weight: 700;
        }

        .btn-primary-custom:hover{ color:#fff; }
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
        <div class="welcome-banner mb-4">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                <div>
                    <h1 class="welcome-title">Bonjour Dr. <?php echo htmlspecialchars($user['nom'] ?? ''); ?>, voici votre espace.</h1>
                    <p class="welcome-sub">
                        Visualisez rapidement votre activite du jour, vos rendez-vous a venir et accedez a vos modules medicaux.
                    </p>
                </div>
                <span class="clock-badge">
                    <i class="fas fa-clock"></i><?php echo date('d/m/Y H:i'); ?>
                </span>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="kpi">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label">Patients</div>
                            <div class="value"><?php echo isset($stats['patients']) ? (int) $stats['patients'] : 0; ?></div>
                        </div>
                        <div class="kpi-icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="kpi">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label">Rendez-vous</div>
                            <div class="value"><?php echo isset($stats['appointments_total']) ? (int) $stats['appointments_total'] : 0; ?></div>
                        </div>
                        <div class="kpi-icon"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="panel p-3 h-100 d-flex flex-column justify-content-center">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2 class="panel-title h6 mb-0">
                            <i class="fas fa-wave-square me-2 text-primary"></i>Résumé rapide
                        </h2>
                        <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/rendez-vous" class="btn btn-primary-custom btn-sm">Planning</a>
                    </div>
                    <p class="text-muted small fw-semibold mb-0 mt-2">
                        Continuez le suivi des dossiers patients et des consultations en quelques clics.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12 col-xl-7">
                <div class="panel p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="panel-title h5 mb-0">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Planning à venir
                        </h2>
                        <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/rendez-vous" class="btn btn-primary-custom btn-sm">
                            Voir tout
                        </a>
                    </div>
                    <ul class="rdv-list">
                        <?php if (empty($nextRendezVous)): ?>
                            <li class="rdv-row text-center py-4 text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                Aucun rendez-vous planifie
                            </li>
                        <?php else: ?>
                            <?php foreach ($nextRendezVous as $rdv): ?>
                                <?php
                                    $dateHeure = new DateTime($rdv['date_heure']);
                                    $now = new DateTime();
                                    $diff = $now->diff($dateHeure);

                                    $dateFormatted = '';
                                    if ($diff->days === 0) {
                                        $dateFormatted = 'Aujourd\'hui, ' . $dateHeure->format('H:i');
                                    } elseif ($diff->days === 1) {
                                        $dateFormatted = 'Demain, ' . $dateHeure->format('H:i');
                                    } else {
                                        $dateFormatted = $dateHeure->format('d/m/Y') . ' a ' . $dateHeure->format('H:i');
                                    }

                                    $badgeClass = ($rdv['statut'] === 'planifié') ? 'status-planifie' : 'status-confirme';
                                ?>
                                <li class="rdv-row">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div>
                                            <div class="rdv-patient">
                                                <?php echo htmlspecialchars(($rdv['patient_prenom'] ?? '') . ' ' . ($rdv['patient_nom'] ?? '')); ?>
                                            </div>
                                            <div class="rdv-date">
                                                <i class="fas fa-clock me-1"></i><?php echo htmlspecialchars($dateFormatted); ?>
                                            </div>
                                        </div>
                                        <span class="status-pill <?php echo $badgeClass; ?>">
                                            <?php echo htmlspecialchars(ucfirst($rdv['statut'])); ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="panel p-3 p-md-4 h-100">
                    <div class="mb-3">
                        <h2 class="panel-title h5 mb-1">
                            <i class="fas fa-bolt me-2 text-primary"></i>Actions
                        </h2>
                        <div class="text-muted small fw-semibold">Raccourcis vers les modules les plus utilisés.</div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/rendez-vous" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-calendar-alt"></i></div>
                                <p class="menu-title">Gérer les rendez-vous</p>
                                <p class="menu-desc">Consultez votre agenda et mettez à jour les statuts.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/consultation/select" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-stethoscope"></i></div>
                                <p class="menu-title">Consultations</p>
                                <p class="menu-desc">Ajoutez le suivi médical et les notes cliniques.</p>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="<?php echo BASE_URL; ?>index.php?route=/medecin/profile" class="menu-card">
                                <div class="menu-ico"><i class="fas fa-user-cog"></i></div>
                                <p class="menu-title">Mon profil</p>
                                <p class="menu-desc">Mettez à jour vos informations personnelles.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
