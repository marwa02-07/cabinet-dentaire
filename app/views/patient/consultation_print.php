<?php
$user = $user ?? [];
$patient = $patient ?? [];
$consultation = $consultation ?? [];
$rendezVous = $rendezVous ?? [];
$medecin = $medecin ?? [];
$ordonnance = $ordonnance ?? null;

$patientNomComplet = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''));
$medecinNomComplet = trim(($medecin['prenom'] ?? '') . ' ' . ($medecin['nom'] ?? ''));
$patientAge = '';
if (!empty($patient['date_naissance'])) {
    $naissance = new DateTime($patient['date_naissance']);
    $patientAge = (new DateTime())->diff($naissance)->y . ' ans';
}

$dateConsultation = !empty($rendezVous['date_heure']) ? date('d/m/Y H:i', strtotime($rendezVous['date_heure'])) : date('d/m/Y H:i');
$dateOrdonnance = !empty($ordonnance['date_creation']) ? date('d/m/Y', strtotime($ordonnance['date_creation'])) : date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation #<?php echo htmlspecialchars((string)($consultation['id'] ?? '')); ?> - Impression</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 24px;
            background: #f1f5f9;
            color: #0f172a;
            font-family: Arial, "Times New Roman", serif;
            line-height: 1.55;
        }

        .print-toolbar {
            max-width: 900px;
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }

        .btn {
            border: 1px solid transparent;
            color: #fff;
            padding: 9px 15px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
            transition: background-color 0.2s ease;
        }

        .print-toolbar .btn:first-child {
            background: #64748b;
        }

        .print-toolbar .btn:first-child:hover {
            background: #475569;
        }

        .print-toolbar .btn:last-child {
            background: #2563eb;
        }

        .print-toolbar .btn:last-child:hover {
            background: #1d4ed8;
        }

        .sheet {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            padding: 28px 34px 42px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            border-bottom: 1px solid #dbe3ef;
            background: #f8fbff;
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 22px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
        }

        .logo-box {
            width: 86px;
            height: 86px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            text-align: center;
            color: #64748b;
            padding: 8px;
        }

        .cabinet-info {
            flex: 1;
            text-align: right;
        }

        .cabinet-name {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 6px 0;
            color: #0f172a;
        }

        .meta-line {
            margin: 0;
            font-size: 14px;
            color: #475569;
        }

        .section {
            background: #fff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 16px;
            overflow: hidden;
        }

        .section-title {
            margin: 0;
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            background: #f8fafc;
        }

        .section-content {
            padding: 14px;
            font-size: 14px;
        }

        .grid-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field {
            margin: 0 0 10px 0;
            color: #0f172a;
        }

        .field strong {
            display: inline-block;
            min-width: 170px;
            font-weight: 700;
            color: #334155;
        }

        .text-block {
            margin: 8px 0 14px;
            white-space: pre-wrap;
            color: #111827;
        }

        .ordonnance-list {
            margin: 0;
            padding-left: 20px;
        }

        .ordonnance-item {
            margin-bottom: 12px;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
        }

        .ordonnance-item:nth-child(odd) {
            background: #f1f5f9;
        }

        .ordonnance-item:last-child {
            margin-bottom: 0;
        }

        .signature-zone {
            margin-top: 36px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-card {
            width: 280px;
            text-align: center;
            color: #334155;
        }

        .signature-line {
            margin-top: 56px;
            border-top: 1px solid #94a3b8;
            padding-top: 8px;
            font-weight: 700;
            color: #0f172a;
        }

        @page {
            size: A4;
            margin: 12mm;
        }

        @media (max-width: 768px) {
            body { padding: 12px; }
            .sheet { padding: 16px; border-radius: 12px; }
            .header { flex-direction: column; }
            .cabinet-info { text-align: left; }
            .grid-two { grid-template-columns: 1fr; }
            .field strong { min-width: 120px; }
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
                color: #000;
            }

            .print-toolbar {
                display: none !important;
            }

            .sheet {
                border: none;
                border-radius: 0;
                box-shadow: none;
                margin: 0;
                max-width: none;
                padding: 0;
            }

            .header,
            .section,
            .logo-box,
            .ordonnance-item {
                box-shadow: none !important;
                background: #fff !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <a class="btn" href="<?php echo BASE_URL; ?>index.php?route=/patient/consultations">Retour</a>
        <button class="btn" type="button" onclick="window.print()">Imprimer</button>
    </div>

    <main class="sheet">
        <header class="header">
            <div class="logo-box">Logo<br>Cabinet</div>
            <div class="cabinet-info">
                <h1 class="cabinet-name"><?php echo htmlspecialchars(defined('APP_NAME') ? APP_NAME : 'Cabinet Dentaire'); ?></h1>
                <p class="meta-line">Adresse: Cabinet <?php echo htmlspecialchars($medecin['cabinet'] ?? 'Dentaire'); ?></p>
                <p class="meta-line">Tél: <?php echo htmlspecialchars($medecin['telephone'] ?? 'N/A'); ?></p>
                <p class="meta-line">Email: <?php echo htmlspecialchars($medecin['email'] ?? 'N/A'); ?></p>
            </div>
        </header>

        <section class="section">
            <h2 class="section-title">Informations patient</h2>
            <div class="section-content grid-two">
                <div>
                    <p class="field"><strong>Nom du patient:</strong> <?php echo htmlspecialchars($patientNomComplet ?: 'N/A'); ?></p>
                    <p class="field"><strong>Age:</strong> <?php echo htmlspecialchars($patientAge ?: 'N/A'); ?></p>
                </div>
                <div>
                    <p class="field"><strong>Téléphone:</strong> <?php echo htmlspecialchars($patient['telephone'] ?? 'N/A'); ?></p>
                    <p class="field"><strong>Date de consultation:</strong> <?php echo htmlspecialchars($dateConsultation); ?></p>
                </div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Informations médecin</h2>
            <div class="section-content">
                <p class="field"><strong>Nom du médecin:</strong> Dr. <?php echo htmlspecialchars($medecinNomComplet ?: 'N/A'); ?></p>
                <p class="field"><strong>Spécialité:</strong> <?php echo htmlspecialchars($medecin['specialite'] ?? 'Médecine dentaire'); ?></p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Consultation</h2>
            <div class="section-content">
                <p class="field"><strong>N° consultation:</strong> <?php echo htmlspecialchars((string)($consultation['id'] ?? 'N/A')); ?></p>
                <p class="field"><strong>Diagnostic:</strong></p>
                <p class="text-block"><?php echo nl2br(htmlspecialchars($consultation['diagnostic'] ?? 'N/A')); ?></p>

                <p class="field"><strong>Notes:</strong></p>
                <p class="text-block"><?php echo nl2br(htmlspecialchars($consultation['notes'] ?? 'Aucune note')); ?></p>

                <p class="field"><strong>Traitement:</strong></p>
                <p class="text-block"><?php echo nl2br(htmlspecialchars($consultation['traitement_effectue'] ?? 'N/A')); ?></p>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Ordonnance</h2>
            <div class="section-content">
                <p class="field"><strong>Date ordonnance:</strong> <?php echo htmlspecialchars($dateOrdonnance); ?></p>
                <?php if (!empty($ordonnance) && !empty($ordonnance['medicaments'])): ?>
                    <ol class="ordonnance-list">
                        <?php foreach ($ordonnance['medicaments'] as $medicament): ?>
                            <li class="ordonnance-item">
                                <p class="field"><strong>Médicament:</strong> <?php echo htmlspecialchars($medicament['nom_medicament'] ?? 'N/A'); ?></p>
                                <p class="field"><strong>Posologie:</strong> <?php echo htmlspecialchars($medicament['dosage'] ?? 'Non précisée'); ?> - <?php echo htmlspecialchars($medicament['frequence'] ?? 'Non précisée'); ?><?php if (!empty($medicament['duree'])): ?> - <?php echo htmlspecialchars($medicament['duree']); ?><?php endif; ?></p>
                                <p class="field"><strong>Instructions:</strong> <?php echo htmlspecialchars($medicament['instructions_medicament'] ?? ($ordonnance['instructions'] ?? 'Suivre la prescription médicale.')); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php else: ?>
                    <p>Aucune ordonnance liée à cette consultation.</p>
                <?php endif; ?>
            </div>
        </section>

        <div class="signature-zone">
            <div class="signature-card">
                <p>Fait le <?php echo date('d/m/Y'); ?></p>
                <div class="signature-line">Signature du médecin / Cachet</div>
            </div>
        </div>
    </main>
</body>
</html>
