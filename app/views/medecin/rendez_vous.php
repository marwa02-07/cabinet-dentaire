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
    <title>Mes rendez-vous - Cabinet Dentaire</title>
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
            --danger:#dc2626;
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
            letter-spacing: -.3px;
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
            padding: 16px 18px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, #fff, var(--surface-alt));
        }

        .panel-title{
            margin: 0;
            font-weight: 900;
            color: #10224f;
            letter-spacing: -.2px;
        }

        .panel-body{
            padding: 0;
        }

        .table thead th {
            background: #f8fafe;
            color: #4f5f82;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 14px;
            border-bottom: 1px solid var(--line);
        }

        .table td {
            padding: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #edf3ff;
        }

        .table tbody tr:hover { background: #f7faff; }
        

        .badge-planifie { background: #fef3c7; color: #92400e; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge-confirme { background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge-complete { background: #dbeafe; color: #1e40af; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge-annule { background: #fee2e2; color: #b91c1c; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; }
        .btn-confirm { background: var(--ok); border: none; color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; }
        .btn-confirm:hover { background: #166534; color: white; }
        .btn-complete { background: var(--primary); border: none; color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; }
        .btn-complete:hover { background: var(--primary-dark); color: white; }
        .btn-cancel { background: var(--danger); border: none; color: white; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; }
        .btn-cancel:hover { background: #b91c1c; color: white; }
        .patient-name { font-weight: 600; color: #2d3748; }
        .datetime { color: #4a5568; font-size: 14px; }
        .type-badge { background: #eef2ff; color: #334155; padding: 4px 10px; border-radius: 8px; font-size: 13px; font-weight: 600; }
        .motif-text { color: #718096; font-size: 13px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .alert { border-radius: 10px; border: none; box-shadow: var(--shadow-sm); }
        .table th i { margin-right: 8px; color: #2c4ee7; }
        

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?route=/medecin/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Médecin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/medecin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/rendez-vous">
                            <i class="fas fa-calendar-alt me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/consultation/select">
                            <i class="fas fa-stethoscope me-1"></i>Consultations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/profile">
                            <i class="fas fa-user-cog me-1"></i>Mon Profil
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="doctor-pill">
                        <i class="fas fa-user-md"></i>
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
        <div class="welcome-banner">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                <div>
                    <h1 class="welcome-title">Mes rendez-vous</h1>
                    <p class="welcome-sub">Gérez les statuts, lancez les consultations et accédez aux dossiers patients.</p>
                </div>
                <a href="index.php?route=/medecin/dashboard" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Retour dashboard
                </a>
            </div>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="panel">
            <div class="panel-head d-flex justify-content-between align-items-center">
                <h2 class="panel-title h5"><i class="fas fa-calendar-check me-2 text-primary"></i>Liste des rendez-vous</h2>
                <span class="text-muted fw-semibold small"><?php echo is_array($rendezVous ?? null) ? count($rendezVous) : 0; ?> élément(s)</span>
            </div>
            <div class="table-responsive panel-body">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i>Patient</th>
                            <th><i class="fas fa-clock"></i>Date & heure</th>
                            <th><i class="fas fa-tag"></i>Type</th>
                            <th><i class="fas fa-info-circle"></i>Statut</th>
                            <th><i class="fas fa-comment"></i>Motif</th>
                            <th class="text-end"><i class="fas fa-cogs"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rendezVous)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                    Aucun rendez-vous planifié
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($rendezVous as $rdv): ?>
                                <?php
                                    $badgeClass = 'badge-planifie';
                                    switch ($rdv['statut']) {
                                        case 'confirmé': $badgeClass = 'badge-confirme'; break;
                                        case 'planifié': $badgeClass = 'badge-planifie'; break;
                                        case 'annulé': $badgeClass = 'badge-annule'; break;
                                        case 'complété': $badgeClass = 'badge-complete'; break;
                                        case 'absent': $badgeClass = 'badge-absent'; break;
                                    }
                                    $typeLabel = ucfirst($rdv['type_rendez_vous']);
                                    $dateObj = new DateTime($rdv['date_heure']);
                                ?>
                                <tr id="rdv-<?php echo (int)$rdv['rdv_id']; ?>" class="align-middle">
                                    <td>
                                        <div class="fw-bold text-dark">
                                            <?php echo htmlspecialchars($rdv['patient_nom'] . ' ' . $rdv['patient_prenom']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div><i class="far fa-calendar-alt text-muted me-1"></i> <?php echo htmlspecialchars($dateObj->format('d/m/Y')); ?></div>
                                        <div class="small text-muted"><i class="far fa-clock me-1"></i> <?php echo htmlspecialchars($dateObj->format('H:i')); ?></div>
                                    </td>
                                    <td>
                                        <span class="text-secondary"><i class="fas fa-notes-medical me-1"></i> <?php echo htmlspecialchars($typeLabel); ?></span>
                                    </td>
                                    <td><span class="badge-status <?php echo $badgeClass; ?>"><?php echo htmlspecialchars(ucfirst($rdv['statut'])); ?></span></td>
                                    <td><span class="motif-text" title="<?php echo htmlspecialchars($rdv['motif']); ?>"><?php echo htmlspecialchars($rdv['motif']); ?></span></td>
                                    <td class="text-end">
                                        <a href="index.php?route=/medecin/patient/<?php echo (int)$rdv['rdv_patient_id']; ?>" class="btn btn-sm btn-info btn-action me-1" title="Voir dossier patient">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="index.php?route=/medecin/consultation/create&id=<?php echo (int)$rdv['rdv_id']; ?>" class="btn btn-sm btn-primary btn-action me-1" title="Lancer consultation">
                                            <i class="fas fa-stethoscope"></i>
                                        </a>
                                        <?php if ($rdv['statut'] !== 'annulé' && $rdv['statut'] !== 'complété'): ?>
                                            <?php if ($rdv['statut'] !== 'confirmé'): ?>
                                                <form action="index.php?route=/medecin/rendez-vous/status" method="POST" class="d-inline status-form" data-id="<?php echo (int)$rdv['rdv_id']; ?>">
                                                    <input type="hidden" name="rendez_vous_id" value="<?php echo (int)$rdv['rdv_id']; ?>">
                                                    <input type="hidden" name="status" value="confirmé">
                                                    <button type="submit" class="btn-confirm" title="Confirmer">
                                                        <i class="fas fa-check"></i> Confirmer
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="index.php?route=/medecin/rendez-vous/status" method="POST" class="d-inline status-form" data-id="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="rendez_vous_id" value="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="status" value="complété">
                                                <button type="submit" class="btn-complete" title="Compléter">
                                                    <i class="fas fa-check-circle"></i> Compléter
                                                </button>
                                            </form>
                                            <form action="index.php?route=/medecin/rendez-vous/status" method="POST" class="d-inline status-form" data-id="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="rendez_vous_id" value="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="status" value="annulé">
                                                <button type="submit" class="btn-cancel" title="Annuler">
                                                    <i class="fas fa-times"></i> Annuler
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Fallback: soumettre le formulaire normalement si JavaScript échoue
    document.querySelectorAll('.status-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Le formulaire sera soumis normalement - pas de preventDefault()
            // Cela permet une mise à jour fiable sans dépendance JavaScript
        });
    });
    </script>
</body>
</html>
