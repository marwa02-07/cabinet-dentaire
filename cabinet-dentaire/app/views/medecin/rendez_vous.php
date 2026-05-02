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
        body { background-color: #f4f6f9; }
        .navbar-custom { background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%); }
        .page-header { background: white; padding: 25px 0; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; }
        .page-header h1 { color: #1a202c; font-weight: 700; font-size: 28px; margin: 0; }
        .table-card { background: white; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
        .table thead th { background: #f8fafc; color: #4a5568; font-weight: 600; font-size: 13px; text-transform: uppercase; padding: 15px; border-bottom: 2px solid #e2e8f0; }
        .table td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #edf2f7; }
        .table tbody tr:hover { background: #f7fafc; }
        .badge-planifie, .badge-pending { background: #4299e1; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-confirme, .badge-confirmed { background: #48bb78; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-complete, .badge-complété { background: #718096; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-annule, .badge-cancelled { background: #f56565; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; }
        .btn-confirm { background: #48bb78; border: none; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .btn-confirm:hover { background: #38a169; color: white; }
        .btn-complete { background: #2c5282; border: none; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .btn-complete:hover { background: #1a365d; color: white; }
        .btn-cancel { background: #e53e3e; border: none; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .btn-cancel:hover { background: #c53030; color: white; }
        .patient-name { font-weight: 600; color: #2d3748; }
        .datetime { color: #4a5568; font-size: 14px; }
        .type-badge { background: #edf2f7; color: #4a5568; padding: 4px 10px; border-radius: 4px; font-size: 13px; }
        .motif-text { color: #718096; font-size: 13px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .alert { border-radius: 8px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php?route=/medecin/dashboard"><i class="fas fa-tooth"></i> Cabinet Dentaire</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?route=/medecin/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-bold" href="index.php?route=/medecin/rendez-vous">Rendez-vous</a></li>
                </ul>
                <span class="navbar-text text-white me-3"><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></span>
                <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3">Mes rendez-vous</h1>
                <p class="text-muted mb-0">Gérez vos rendez-vous et consultations</p>
            </div>
            <a href="index.php?route=/medecin/dashboard" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date & heure</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Motif</th>
                            <th class="text-end">Actions</th>
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
                                    $currentStatus = $rdv['status'] ?? ($rdv['statut'] ?? 'pending');
                                    $badgeClass = 'badge-planifie';
                                    switch ($currentStatus) {
                                        case 'confirmed':
                                        case 'confirmé':
                                            $badgeClass = 'badge-confirmed';
                                            break;
                                        case 'pending':
                                        case 'planifié':
                                            $badgeClass = 'badge-pending';
                                            break;
                                        case 'cancelled':
                                        case 'annulé':
                                            $badgeClass = 'badge-cancelled';
                                            break;
                                        case 'complété':
                                        case 'completed':
                                            $badgeClass = 'badge-complete';
                                            break;
                                    }
                                    $typeLabel = ucfirst($rdv['type_rendez_vous']);
                                ?>
                                <tr id="rdv-<?php echo (int)$rdv['rdv_id']; ?>">
                                    <td>
                                        <span class="patient-name">
                                            <i class="fas fa-user text-muted me-1"></i>
                                            <?php echo htmlspecialchars($rdv['patient_prenom'] . ' ' . $rdv['patient_nom']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="datetime">
                                            <i class="fas fa-calendar-alt text-muted me-1"></i>
                                            <?php echo date('d/m/Y', strtotime($rdv['date_heure'])); ?>
                                            <span class="text-muted"> à </span>
                                            <?php echo date('H:i', strtotime($rdv['date_heure'])); ?>
                                        </div>
                                    </td>
                                    <td><span class="type-badge"><?php echo htmlspecialchars($typeLabel); ?></span></td>
                                    <td><span class="<?php echo $badgeClass; ?>"><?php echo htmlspecialchars(ucfirst($currentStatus)); ?></span></td>
                                    <td><span class="motif-text" title="<?php echo htmlspecialchars($rdv['motif']); ?>"><?php echo htmlspecialchars($rdv['motif']); ?></span></td>
                                    <td class="text-end">
                                        <a href="index.php?route=/medecin/patient/<?php echo (int)$rdv['rdv_patient_id']; ?>" class="btn btn-sm btn-info btn-action me-1" title="Voir dossier patient">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="index.php?route=/medecin/consultation/create&id=<?php echo (int)$rdv['rdv_id']; ?>" class="btn btn-sm btn-primary btn-action me-1" title="Lancer consultation">
                                            <i class="fas fa-stethoscope"></i>
                                        </a>
                                        <?php if ($currentStatus !== 'cancelled' && $currentStatus !== 'annulé' && $currentStatus !== 'complété'): ?>
                                            <?php if ($currentStatus !== 'confirmed' && $currentStatus !== 'confirmé'): ?>
                                                <form action="index.php?route=/medecin/rendez-vous/status" method="POST" class="d-inline status-form" data-id="<?php echo (int)$rdv['rdv_id']; ?>">
                                                    <input type="hidden" name="rendez_vous_id" value="<?php echo (int)$rdv['rdv_id']; ?>">
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn-confirm" title="Confirmer">
                                                        <i class="fas fa-check"></i> Confirmer
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="index.php?route=/medecin/rendez-vous/status" method="POST" class="d-inline status-form" data-id="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="rendez_vous_id" value="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn-complete" title="Compléter">
                                                    <i class="fas fa-check-circle"></i> Compléter
                                                </button>
                                            </form>
                                            <form action="index.php?route=/medecin/rendez-vous/status" method="POST" class="d-inline status-form" data-id="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="rendez_vous_id" value="<?php echo (int)$rdv['rdv_id']; ?>">
                                                <input type="hidden" name="status" value="cancelled">
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
