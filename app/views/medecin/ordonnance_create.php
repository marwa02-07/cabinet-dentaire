<?php 
// Vérifications défensives pour les variables
$user = $user ?? [];
$patient = $patient ?? [];
$rendezVous = $rendezVous ?? [];
$consultation = $consultation ?? [];
$date_creation = $date_creation ?? date('Y-m-d');
?>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une ordonnance - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .medicament-row {
            border: 1px solid #dee2e6;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            background: #f8f9fa;
        }
        .medicament-row .btn-remove {
            min-width: 140px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php?route=/medecin/dashboard"><i class="fas fa-tooth"></i> Cabinet Dentaire</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?route=/medecin/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?route=/medecin/rendez-vous">Rendez-vous</a></li>
                </ul>
                <span class="navbar-text text-white me-3"><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container py-5 mt-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3">Nouvelle ordonnance</h1>
                <p class="text-muted mb-0">Rédigez une ordonnance pour le patient sélectionné.</p>
            </div>
            <a href="index.php?route=/medecin/ordonnance/select" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la sélection
            </a>
        </div>

        <?php if (!empty($consultation)): ?>
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="fas fa-link me-2"></i>
            <div>
                <strong>Consultation détectée :</strong> Cette ordonnance sera automatiquement liée à la dernière consultation du patient
                (<?php echo htmlspecialchars(date('d/m/Y', strtotime($consultation['created_at']))); ?>).
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div>
                <strong>Aucune consultation trouvée :</strong> Cette ordonnance sera créée sans liaison à une consultation. 
                Vous pourrez la lier plus tard depuis la fiche patient.
            </div>
        </div>
        <?php endif; ?>

        <?php // Champ consultation_id toujours présent pour assurer la transmission ?>
        <input type="hidden" name="consultation_id" value="<?php echo (int)($consultation['id'] ?? 0); ?>">

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="fas fa-user"></i> Patient</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom :</strong> <?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?></p>
                        <p><strong>Email :</strong> <?php echo htmlspecialchars($patient['email'] ?? ''); ?></p>
                        <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($patient['telephone'] ?? 'N/A'); ?></p>
                        <p><strong>Adresse :</strong> <?php echo htmlspecialchars($patient['adresse'] ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0"><i class="fas fa-calendar-alt"></i> Rendez-vous</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Date :</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rendezVous['date_heure'] ?? 'now'))); ?></p>
                        <p><strong>Motif :</strong> <?php echo htmlspecialchars($rendezVous['motif'] ?? ''); ?></p>
                        <p><strong>Type :</strong> <?php echo htmlspecialchars(ucfirst($rendezVous['type_rendez_vous'] ?? '')); ?></p>
                        <p><strong>Statut :</strong> <?php echo htmlspecialchars(ucfirst($rendezVous['statut'] ?? '')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <form action="index.php?route=/medecin/ordonnance/store" method="POST">
            <input type="hidden" name="rendez_vous_id" value="<?php echo (int)($rendezVous['id'] ?? 0); ?>">
            <input type="hidden" name="patient_id" value="<?php echo (int)($patient['id'] ?? 0); ?>">

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-medical"></i> Détails de l’ordonnance</h5>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <label class="form-label">Date de création</label>
                            <input type="date" name="date_creation" class="form-control" value="<?php echo htmlspecialchars($date_creation); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Posologie</label>
                            <input type="text" name="posologie" class="form-control" placeholder="Ex: 1 comprimé 2 fois par jour" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Instructions</label>
                            <textarea name="instructions" class="form-control" rows="3" placeholder="Ex: À prendre après les repas."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-pills"></i> Médicaments</h5>
                    <button type="button" class="btn btn-sm btn-success" onclick="addMedicamentRow()">
                        <i class="fas fa-plus"></i> Ajouter un médicament
                    </button>
                </div>
                <div class="card-body" id="medicamentsContainer">
                    <div class="medicament-row" data-index="0">
                        <div class="row gy-3">
                            <div class="col-md-5">
                                <label class="form-label">Nom du médicament</label>
                                <input type="text" name="medicaments[0][nom_medicament]" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Dosage</label>
                                <input type="text" name="medicaments[0][dosage]" class="form-control" placeholder="Ex: 500 mg" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fréquence</label>
                                <input type="text" name="medicaments[0][frequence]" class="form-control" placeholder="Ex: 2 fois/jour" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-remove" onclick="removeMedicamentRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row gy-3 mt-3">
                            <div class="col-md-4">
                                <label class="form-label">Durée</label>
                                <input type="text" name="medicaments[0][duree]" class="form-control" placeholder="Ex: 5 jours">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Instructions spécifiques</label>
                                <input type="text" name="medicaments[0][instructions_medicament]" class="form-control" placeholder="Ex: À prendre avant le coucher">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Enregistrer l’ordonnance
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let medicamentIndex = 1;

        function addMedicamentRow() {
            const container = document.getElementById('medicamentsContainer');
            const row = document.createElement('div');
            row.className = 'medicament-row';
            row.dataset.index = medicamentIndex;
            row.innerHTML = `
                <div class="row gy-3">
                    <div class="col-md-5">
                        <label class="form-label">Nom du médicament</label>
                        <input type="text" name="medicaments[${medicamentIndex}][nom_medicament]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dosage</label>
                        <input type="text" name="medicaments[${medicamentIndex}][dosage]" class="form-control" placeholder="Ex: 500 mg" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fréquence</label>
                        <input type="text" name="medicaments[${medicamentIndex}][frequence]" class="form-control" placeholder="Ex: 2 fois/jour" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger btn-remove" onclick="removeMedicamentRow(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row gy-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Durée</label>
                        <input type="text" name="medicaments[${medicamentIndex}][duree]" class="form-control" placeholder="Ex: 5 jours">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Instructions spécifiques</label>
                        <input type="text" name="medicaments[${medicamentIndex}][instructions_medicament]" class="form-control" placeholder="Ex: À prendre avant le coucher">
                    </div>
                </div>
            `;
            container.appendChild(row);
            medicamentIndex++;
        }

        function removeMedicamentRow(button) {
            const row = button.closest('.medicament-row');
            if (!row) return;
            const container = document.getElementById('medicamentsContainer');
            if (container.querySelectorAll('.medicament-row').length === 1) {
                return;
            }
            row.remove();
        }
    </script>
</body>
</html>
