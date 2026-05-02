<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimer Planning - <?php echo date('d/m/Y', strtotime($date)); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body { padding: 0; margin: 0; }
            .no-print { display: none !important; }
            .card { border: none !important; box-shadow: none !important; }
            .card-body { padding: 0 !important; }
        }
        body { background: #f8f9fa; padding: 20px; }
        .planning-header { text-align: center; margin-bottom: 30px; }
        .planning-header h1 { color: #7b1fa2; font-size: 24px; }
        .planning-header .date { color: #666; font-size: 16px; }
        .table { font-size: 14px; }
        .table th { background: #7b1fa2; color: white; }
        .statut-planifie { background: #e3f2fd; color: #1565c0; }
        .statut-confirme { background: #e8f5e9; color: #2e7d32; }
        .statut-annule { background: #ffebee; color: #c62828; }
        .statut-complete { background: #f3e5f5; color: #7b1fa2; }
        .statut-absent { background: #fff3e0; color: #e65100; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bouton retour et impression -->
        <div class="no-print mb-3">
            <a href="index.php?route=/secretaire/dashboard" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Imprimer
            </button>
        </div>

        <!-- En-tête du planning -->
        <div class="planning-header">
            <h1><i class="fas fa-hospital"></i> Cabinet Dentaire</h1>
            <h2>Planning du <?php echo date('d/m/Y', strtotime($date)); ?></h2>
            <p class="date">Généré le <?php echo date('d/m/Y à H:i'); ?></p>
        </div>

        <!-- Tableau des rendez-vous -->
        <div class="card">
            <div class="card-body">
                <?php if (empty($rendezvous)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Aucun rendez-vous prévu pour aujourd'hui.
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
                                    <span class="badge statut-<?php echo $rdv['statut']; ?>">
                                        <?php echo htmlspecialchars($rdv['statut']); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Résumé -->
                    <div class="mt-4">
                        <h5>Résumé</h5>
                        <p>
                            <strong>Total des rendez-vous:</strong> <?php echo count($rendezvous); ?>
                        </p>
                        <?php
                        $stats = ['planifié' => 0, 'confirmé' => 0, 'annulé' => 0, 'complété' => 0, 'absent' => 0];
                        foreach ($rendezvous as $rdv) {
                            if (isset($stats[$rdv['statut']])) {
                                $stats[$rdv['statut']]++;
                            }
                        }
                        ?>
                        <p>
                            Planifiés: <?php echo $stats['planifié']; ?> | 
                            Confirmés: <?php echo $stats['confirmé']; ?> | 
                            Complétés: <?php echo $stats['complété']; ?> | 
                            Absents: <?php echo $stats['absent']; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="text-center mt-4 text-muted">
            <small>Cabinet Dentaire - <?php echo date('Y'); ?></small>
        </div>
    </div>

    <script>
        // Lancer l'impression automatiquement après chargement
        // window.onload = function() { window.print(); };
    </script>
</body>
</html>