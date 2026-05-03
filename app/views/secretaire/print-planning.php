<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimer Planning - <?php echo date('d/m/Y', strtotime($date)); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>css/secretaire-theme.css" rel="stylesheet">
    <style>
        @media print {
            body { padding: 0 !important; margin: 0; }
            .no-print { display: none !important; }
            .card { border: none !important; box-shadow: none !important; }
            .card-body { padding: 0 !important; }
        }
    </style>
</head>
<body class="print-planning-shell print-plan-shell">
    <div class="container py-3">
        <div class="no-print mb-3">
            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/dashboard" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Retour
            </a>
            <button type="button" onclick="window.print()" class="btn btn-primary-custom ms-2 border-0">
                <i class="fas fa-print me-1"></i>Imprimer
            </button>
        </div>

        <div class="planning-header">
            <h1><i class="fas fa-tooth me-2"></i>Cabinet Dentaire</h1>
            <h2>Planning du <?php echo date('d/m/Y', strtotime($date)); ?></h2>
            <p class="date text-muted">Généré le <?php echo date('d/m/Y à H:i'); ?></p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <?php if (empty($rendezvous)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-1"></i> Aucun rendez-vous prévu pour cette date.
                    </div>
                <?php else: ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Heure</th>
                                <th>Patient</th>
                                <th>Téléphone</th>
                                <th>Dentiste</th>
                                <th>Type</th>
                                <th>Motif</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rendezvous as $rdv): 
                                $heure = date('H:i', strtotime($rdv['date_heure']));
                                $patient = $patientsMap[$rdv['patient_id']] ?? [];
                                $dentiste = $dentistesMap[$rdv['dentiste_id']] ?? [];
                            ?>
                            <tr>
                                <td><strong><?php echo $heure; ?></strong></td>
                                <td>
                                    <?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?>
                                </td>
                                <td><?php echo htmlspecialchars($patient['telephone'] ?? '-'); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($dentiste['specialite'] ?? 'Dr. ' . ($dentiste['nom'] ?? '')); ?>
                                </td>
                                <td><?php echo htmlspecialchars($rdv['type_rendez_vous']); ?></td>
                                <td><?php echo htmlspecialchars($rdv['motif'] ?? '-'); ?></td>
                                <td>
                                    <span class="badge statut-<?php echo htmlspecialchars($rdv['statut'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($rdv['statut']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <h5 class="fw-bold">Résumé</h5>
                        <p>
                            <strong>Total des rendez-vous :</strong> <?php echo count($rendezvous); ?>
                        </p>
                        <?php
                        $stats = ['planifié' => 0, 'confirmé' => 0, 'annulé' => 0, 'complété' => 0, 'absent' => 0];
                        foreach ($rendezvous as $rdv) {
                            if (isset($stats[$rdv['statut']])) {
                                $stats[$rdv['statut']]++;
                            }
                        }
                        ?>
                        <p class="text-muted">
                            Planifiés : <?php echo $stats['planifié']; ?> |
                            Confirmés : <?php echo $stats['confirmé']; ?> |
                            Complétés : <?php echo $stats['complété']; ?> |
                            Absents : <?php echo $stats['absent']; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-4 text-muted">
            <small>Cabinet Dentaire - <?php echo date('Y'); ?></small>
        </div>
    </div>
</body>
</html>
