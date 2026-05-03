<?php
$user = $user ?? [];
$patient = $patient ?? [];
$consultation = $consultation ?? [];
$rendezVous = $rendezVous ?? [];
$medecin = $medecin ?? [];
$ordonnance = $ordonnance ?? null;
?>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimer Consultation - Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #eef2ff; color: #111827; font-family: "Segoe UI", system-ui, sans-serif; padding: 20px; }
        .print-shell { max-width: 960px; margin: 0 auto; background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); }
        .header { background: linear-gradient(135deg, #2563eb, #4f46e5); color: white; padding: 26px; }
        .header h1 { margin: 0; font-size: 1.7rem; }
        .header p { margin: 6px 0 0; opacity: 0.92; }
        .section-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 14px; color: #0f172a; }
        .content { padding: 28px; }
        .info-card { border: 1px solid #e2e8f0; border-radius: 14px; background: #f8fafc; padding: 20px; margin-bottom: 20px; }
        .label { color: #475569; font-weight: 700; }
        .print-bar { background: #f8fafc; padding: 18px 28px; display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .btn-print { background: #2563eb; color: white; border: none; }
        @media print {
            body { background: white; padding: 0; }
            .print-bar { display: none !important; }
            .print-shell { box-shadow: none; margin: 0; border-radius: 0; }
        }
    </style>
</head>
<body>
    <div class="print-shell">
        <div class="header">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                <div>
                    <h1><i class="fas fa-print me-2"></i>Consultation</h1>
                    <p>Imprimez le résumé de votre consultation et de votre ordonnance.</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-white text-primary py-2 px-3 shadow-sm">Patient : <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                </div>
            </div>
        </div>
        <div class="print-bar no-print">
            <a href="<?php echo BASE_URL; ?>index.php?route=/patient/consultations" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Retour</a>
            <button type="button" class="btn btn-print btn-sm" onclick="window.print();"><i class="fas fa-print me-1"></i>Imprimer</button>
        </div>
        <div class="content">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-card">
                        <p class="label mb-1">Médecin</p>
                        <p class="mb-1"><strong>Dr. <?php echo htmlspecialchars(($medecin['prenom'] ?? '') . ' ' . ($medecin['nom'] ?? '')); ?></strong></p>
                        <p class="mb-0 text-muted"><?php echo htmlspecialchars($medecin['specialite'] ?? ''); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card">
                        <p class="label mb-1">Rendez-vous</p>
                        <p class="mb-1"><strong><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rendezVous['date_heure'] ?? ''))); ?></strong></p>
                        <p class="mb-0 text-muted">Motif : <?php echo htmlspecialchars($rendezVous['motif'] ?? ''); ?></p>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h2 class="section-title">Détails de la consultation</h2>
                <p><span class="label">Diagnostic :</span><br><?php echo nl2br(htmlspecialchars($consultation['diagnostic'] ?? '')); ?></p>
                <p><span class="label">Traitement effectué :</span><br><?php echo nl2br(htmlspecialchars($consultation['traitement_effectue'] ?? '')); ?></p>
                <?php if (!empty($consultation['traitement_prevu'])): ?>
                    <p><span class="label">Traitement prévu :</span><br><?php echo nl2br(htmlspecialchars($consultation['traitement_prevu'])); ?></p>
                <?php endif; ?>
                <p><span class="label">Dents traitées :</span> <?php echo htmlspecialchars($consultation['dents_traitees'] ?? ''); ?></p>
                <?php if (!empty($consultation['prix'])): ?>
                    <p><span class="label">Prix :</span> <?php echo number_format($consultation['prix'], 2); ?> DH</p>
                <?php endif; ?>
                <?php if (!empty($consultation['notes'])): ?>
                    <p><span class="label">Notes :</span><br><?php echo nl2br(htmlspecialchars($consultation['notes'])); ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($ordonnance)): ?>
                <div class="info-card">
                    <h2 class="section-title">Ordonnance</h2>
                    <p><span class="label">Date :</span> <?php echo htmlspecialchars(date('d/m/Y', strtotime($ordonnance['date_creation'] ?? ''))); ?></p>
                    <p><span class="label">Posologie :</span><br><?php echo nl2br(htmlspecialchars($ordonnance['recommandations'] ?? '')); ?></p>
                    <?php if (!empty($ordonnance['instructions'])): ?>
                        <p><span class="label">Instructions :</span><br><?php echo nl2br(htmlspecialchars($ordonnance['instructions'])); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($ordonnance['medicaments'])): ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Dosage</th>
                                        <th>Fréquence</th>
                                        <th>Durée</th>
                                        <th>Instructions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ordonnance['medicaments'] as $med): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($med['nom_medicament'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($med['dosage'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($med['frequence'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($med['duree'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($med['instructions_medicament'] ?? ''); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="text-muted small">Consultation n° <?php echo htmlspecialchars($consultation['id'] ?? ''); ?> - Imprimée le <?php echo date('d/m/Y H:i'); ?></div>
        </div>
    </div>
</body>
</html>
