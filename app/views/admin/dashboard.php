<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur - Gestion Hôpital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php
    // Valeurs par défaut pour éviter les erreurs undefined
    $stats = $stats ?? [
        'total_users' => 0,
        'total_medecins' => 0,
        'total_secretaires' => 0,
        'total_patients' => 0
    ];
    ?>
    <style>
        :root{
            --bg0:#f6f8fb;
            --bg1:#eef3ff;
            --card:#ffffffcc;
            --cardSolid:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:rgba(15, 23, 42, 0.08);
            --shadow: 0 18px 50px rgba(15, 23, 42, 0.10);
            --shadowSm: 0 8px 24px rgba(15, 23, 42, 0.10);
            --brandA:#0ea5e9;
            --brandB:#6366f1;
            --accent:#22c55e;
        }

        body{
            color: var(--text);
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
            background:
                radial-gradient(1100px 520px at 15% -5%, rgba(99,102,241,0.14), transparent 62%),
                radial-gradient(980px 520px at 85% 0%, rgba(14,165,233,0.16), transparent 58%),
                linear-gradient(180deg, var(--bg1) 0%, var(--bg0) 52%, #ffffff 100%);
            padding-top: 76px;
        }

        .navbar-custom{
            background: linear-gradient(135deg, rgba(14,165,233,0.95) 0%, rgba(99,102,241,0.92) 55%, rgba(34,197,94,0.85) 120%);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .navbar-custom .navbar-brand{
            font-weight: 800;
            letter-spacing: .2px;
            font-size: 18px;
            color: white !important;
        }

        .navbar-custom .nav-link{
            color: rgba(255, 255, 255, 0.92) !important;
            font-weight: 600;
            margin-left: 10px;
            border-radius: 999px;
            padding: 8px 12px;
        }

        .navbar-custom .nav-link:hover{
            background: rgba(255,255,255,0.16);
            color: #fff !important;
        }

        .navbar-custom .nav-link.active{
            background: rgba(255,255,255,0.20);
            color: #fff !important;
        }

        .user-info{
            color: rgba(255, 255, 255, 0.92);
            font-size: 13px;
            margin-right: 12px;
            display:flex;
            align-items:center;
            gap:10px;
            white-space: nowrap;
        }

        .role-badge{
            background-color: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .page-wrap{
            max-width: 1280px;
            margin: 0 auto;
        }

        .hero{
            border: 1px solid var(--border);
            background: linear-gradient(135deg, rgba(255,255,255,0.75), rgba(255,255,255,0.55));
            border-radius: 18px;
            box-shadow: var(--shadowSm);
            padding: 18px 18px;
            position: relative;
            overflow:hidden;
        }

        .hero:before{
            content:"";
            position:absolute;
            inset:-2px;
            background:
                radial-gradient(700px 280px at 10% 20%, rgba(14,165,233,0.20), transparent 60%),
                radial-gradient(700px 280px at 85% 30%, rgba(99,102,241,0.18), transparent 55%);
            pointer-events:none;
        }

        .hero > *{ position: relative; }

        .hero-title{
            font-weight: 900;
            letter-spacing: -0.4px;
            margin: 0;
        }

        .hero-sub{
            color: var(--muted);
            margin: 0;
        }

        .chip{
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.65);
            border-radius: 999px;
            padding: 8px 12px;
            font-weight: 700;
            color: var(--text);
        }

        .soft-card{
            border: 1px solid var(--border);
            background: var(--cardSolid);
            border-radius: 16px;
            box-shadow: var(--shadowSm);
        }

        .stat-tile{
            border: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(255,255,255,0.82));
            border-radius: 18px;
            box-shadow: var(--shadowSm);
            transition: transform .18s ease, box-shadow .18s ease;
            overflow:hidden;
            position: relative;
        }

        .stat-tile:hover{
            transform: translateY(-4px);
            box-shadow: var(--shadow);
        }

        .stat-icon{
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display:flex;
            align-items:center;
            justify-content:center;
            color: #fff;
            box-shadow: 0 10px 22px rgba(15,23,42,0.14);
        }

        .grad-blue{ background: linear-gradient(135deg, #0ea5e9, #2563eb); }
        .grad-green{ background: linear-gradient(135deg, #22c55e, #16a34a); }
        .grad-amber{ background: linear-gradient(135deg, #f59e0b, #f97316); }
        .grad-indigo{ background: linear-gradient(135deg, #6366f1, #8b5cf6); }

        .stat-label{ color: var(--muted); font-weight: 700; }
        .stat-value{ font-weight: 900; letter-spacing: -0.4px; }

        .quick-tile{
            border: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(255,255,255,0.92), rgba(255,255,255,0.80));
            border-radius: 18px;
            box-shadow: var(--shadowSm);
            text-decoration: none;
            color: var(--text);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
            position: relative;
            overflow:hidden;
            min-height: 108px;
        }

        .quick-tile:hover{
            transform: translateY(-4px);
            box-shadow: var(--shadow);
            border-color: rgba(99,102,241,0.25);
            color: var(--text);
        }

        .quick-tile:before{
            content:"";
            position:absolute;
            inset:-2px;
            background: radial-gradient(420px 180px at 10% 10%, rgba(14,165,233,0.16), transparent 60%);
            pointer-events:none;
        }

        .quick-tile > *{ position: relative; }

        .quick-ico{
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
        }

        .quick-title{ font-weight: 900; margin: 0; }
        .quick-desc{ color: var(--muted); margin: 0; font-weight: 600; font-size: 13px; }

        .section-title{
            font-weight: 900;
            letter-spacing: -0.2px;
            margin: 0;
        }

        .subtle-divider{
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(15,23,42,0.10), transparent);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?route=/admin/dashboard">
                <i class="fas fa-tooth me-2"></i>
                Cabinet Dentaire - Admin
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/admin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/medecins">
                            <i class="fas fa-user-md me-1"></i>Médecins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/secretaires">
                            <i class="fas fa-user-secret me-1"></i>Secrétaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="user-info">
                        <i class="fas fa-user me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']); ?>
                        <span class="role-badge ms-2">ADMIN</span>
                    </div>
                    <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-0">
        <div class="page-wrap px-2 px-md-3">
            <!-- Hero -->
            <div class="hero mb-4">
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="chip">
                                <i class="fas fa-sparkle me-2"></i>Admin
                            </span>
                            <span class="chip">
                                <i class="fas fa-clock me-2"></i><?php echo date('d/m/Y H:i'); ?>
                            </span>
                        </div>
                        <h1 class="hero-title h3 mb-1">
                            Dashboard Administrateur
                        </h1>
                        <p class="hero-sub">
                            Vue d’ensemble rapide des utilisateurs, rôles et accès.
                        </p>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="index.php?route=/register-medecin" class="btn btn-outline-dark">
                            <i class="fas fa-user-plus me-2"></i>Nouveau médecin
                        </a>
                        <a href="index.php?route=/register-secretaire" class="btn btn-outline-dark">
                            <i class="fas fa-user-secret me-2"></i>Ajouter secrétaire
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-tile p-3 h-100">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-label mb-1">Total utilisateurs</div>
                                <div class="stat-value display-6 mb-0"><?php echo $stats['total_users']; ?></div>
                            </div>
                            <div class="stat-icon grad-amber">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="subtle-divider my-3"></div>
                        <div class="text-muted fw-semibold small">
                            <i class="fas fa-shield-halved me-2"></i>Contrôle des accès & rôles
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-tile p-3 h-100">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-label mb-1">Médecins</div>
                                <div class="stat-value display-6 mb-0"><?php echo $stats['total_medecins']; ?></div>
                            </div>
                            <div class="stat-icon grad-blue">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>
                        <div class="subtle-divider my-3"></div>
                        <div class="text-muted fw-semibold small">
                            <i class="fas fa-stethoscope me-2"></i>Gestion du personnel médical
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-tile p-3 h-100">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-label mb-1">Secrétaires</div>
                                <div class="stat-value display-6 mb-0"><?php echo $stats['total_secretaires']; ?></div>
                            </div>
                            <div class="stat-icon grad-green">
                                <i class="fas fa-user-secret"></i>
                            </div>
                        </div>
                        <div class="subtle-divider my-3"></div>
                        <div class="text-muted fw-semibold small">
                            <i class="fas fa-clipboard-check me-2"></i>Support & organisation
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="stat-tile p-3 h-100">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="stat-label mb-1">Patients</div>
                                <div class="stat-value display-6 mb-0"><?php echo $stats['total_patients']; ?></div>
                            </div>
                            <div class="stat-icon grad-indigo">
                                <i class="fas fa-procedures"></i>
                            </div>
                        </div>
                        <div class="subtle-divider my-3"></div>
                        <div class="text-muted fw-semibold small">
                            <i class="fas fa-heart-pulse me-2"></i>Base patients & suivi
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick actions + Side panel -->
            <div class="row g-3">
                <div class="col-12 col-xl-12">
                    <div class="soft-card p-3 p-md-4 h-100">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <div class="section-title h5 mb-1">
                                    <i class="fas fa-bolt me-2"></i>Actions rapides
                                </div>
                                <div class="text-muted fw-semibold small">Accès direct aux tâches les plus fréquentes.</div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <a href="index.php?route=/register-medecin" class="quick-tile p-3 d-flex align-items-center gap-3">
                                    <div class="quick-ico grad-blue">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="quick-title">Ajouter médecin</p>
                                        <p class="quick-desc">Créer un compte médecin en quelques secondes.</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-muted"></i>
                                </a>
                            </div>

                            <div class="col-12 col-md-6">
                                <a href="index.php?route=/admin/medecins" class="quick-tile p-3 d-flex align-items-center gap-3">
                                    <div class="quick-ico grad-blue">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="quick-title">Gérer médecins</p>
                                        <p class="quick-desc">Consulter, modifier et organiser.</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-muted"></i>
                                </a>
                            </div>

                            <div class="col-12 col-md-6">
                                <a href="index.php?route=/register-secretaire" class="quick-tile p-3 d-flex align-items-center gap-3">
                                    <div class="quick-ico grad-green">
                                        <i class="fas fa-user-secret"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="quick-title">Ajouter secrétaire</p>
                                        <p class="quick-desc">Ajouter un profil de secrétariat.</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-muted"></i>
                                </a>
                            </div>

                            <div class="col-12 col-md-6">
                                <a href="index.php?route=/admin/secretaires" class="quick-tile p-3 d-flex align-items-center gap-3">
                                    <div class="quick-ico grad-green">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="quick-title">Gérer secrétaires</p>
                                        <p class="quick-desc">Administration des accès et profils.</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-muted"></i>
                                </a>
                            </div>

                            <div class="col-12 col-md-6">
                                <a href="index.php?route=/register-patient" class="quick-tile p-3 d-flex align-items-center gap-3">
                                    <div class="quick-ico grad-indigo">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="quick-title">Ajouter patient</p>
                                        <p class="quick-desc">Créer un nouveau dossier patient.</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-muted"></i>
                                </a>
                            </div>

                            

                            

                           

                            <div class="col-12 col-md-6">
                                <a href="index.php?route=/admin/patients" class="quick-tile p-3 d-flex align-items-center gap-3">
                                    <div class="quick-ico grad-indigo">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="quick-title">Gérer patients</p>
                                        <p class="quick-desc">Rechercher, filtrer et mettre à jour.</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-muted"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>