<?php 
// Vérifications défensives pour les variables
$user = $user ?? [];
$patient = $patient ?? [];
$rendezVous = $rendezVous ?? [];
?>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle consultation - Cabinet Dentaire</title>
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

        .welcome-title{ font-weight: 900; margin: 0; font-size: clamp(1.2rem,2.2vw,1.7rem); }
        .welcome-sub{ margin:.45rem 0 0; opacity:.94; max-width: 780px; }

        .card-custom { border-radius: 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--line); background: var(--surface); }
        .card-header-custom { border-radius: 16px 16px 0 0; padding: 16px 18px; color: white; }
        .section-title { font-weight: 700; color: #344767; margin-bottom: 18px; }
        .form-label { font-weight: 600; color: #344767; }
        .form-control, .form-select { border-radius: 12px; border: 1px solid #ced4da; padding: 12px 14px; }
        .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(37,99,235,.15); border-color: var(--primary); }
        .btn-primary-custom { border-radius: 12px; padding: 10px 18px; font-weight: 700; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border: none; }
        .btn-primary-custom:hover { color:#fff; transform: translateY(-1px); }
        .btn-secondary-custom{ border-radius: 10px; }
        .toggle-card { border: 1px solid #dee2e6; border-radius: 16px; background: white; cursor: pointer; transition: all .25s ease; }
        .toggle-card:hover { border-color: var(--primary); box-shadow: 0 12px 28px rgba(37,99,235,.12); }
        .ordonnance-section { display: none; background: #f8f9ff; border-radius: 16px; border: 1px solid #dce7ff; padding: 24px; margin-top: 20px; }
        .ordonnance-section.active { display: block; animation: fadeIn .35s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .medicament-row { border: 1px solid #dee2e6; padding: 16px; border-radius: 8px; margin-bottom: 12px; background: #f8f9fa; }
        .text-purple{ color: var(--primary-dark); }
        .card-custom {
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(37,99,235,0.10);
    border: 1px solid var(--line);
    background: var(--surface);
    overflow: hidden;
    transition: all 0.3s ease;
}

.card-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(37,99,235,0.18);
}
.card-body {
    padding: 28px !important;
}
.ordonnance-section {
    display: none;
    background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
    border-radius: 14px;
    border: 1px solid #bbf7d0;
    padding: 22px;
    margin-top: 20px;
}

.ordonnance-section.active {
    display: block;
    animation: fadeIn .3s ease-in-out;
}
.medicament-row {
    border: 1px solid #e2e8f0;
    padding: 18px;
    border-radius: 12px;
    margin-bottom: 14px;
    background: #ffffff;
    transition: all 0.2s;
}

.medicament-row:hover {
    border-color: #16a34a;
    box-shadow: 0 6px 16px rgba(22,163,74,0.12);
}
.toggle-card {
    border: 1px solid #dbeafe;
    border-radius: 14px;
    background: #f8fbff;
    cursor: pointer;
    transition: all .25s ease;
    padding: 16px;
}

.toggle-card:hover {
    border-color: var(--primary);
    background: #eef4ff;
}
.card-header-consultation {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 20px;
    color: white;
}
.card-header-ordonnance {
    background: linear-gradient(135deg, #16a34a, #15803d);
    padding: 20px;
    color: white;
}
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
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="welcome-title"><i class="fas fa-file-medical-alt me-2"></i>Nouvelle consultation</h1>
                    <p class="welcome-sub">Enregistrez la consultation et rattachez une ordonnance si nécessaire.</p>
                </div>
                <a href="index.php?route=/medecin/rendez-vous" class="btn btn-outline-secondary btn-secondary-custom"><i class="fas fa-arrow-left me-2"></i>Retour aux rendez-vous</a>
            </div>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card-custom mb-4">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-4">
                        <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #e9f0ff 0%, #f3f6ff 100%);">
                            <h5 class="mb-3"><i class="fas fa-user me-2 text-primary"></i>Patient</h5>
                            <p class="mb-1"><strong><?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?></strong></p>
                            <p class="text-muted mb-0"><?php echo htmlspecialchars($patient['email'] ?? ''); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #e9f0ff 0%, #f3f6ff 100%);">
                            <h5 class="mb-3"><i class="fas fa-calendar-check me-2 text-purple"></i>Date</h5>
                            <p class="mb-0"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($rendezVous['date_heure'] ?? 'now'))); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #e9f0ff 0%, #f3f6ff 100%);">
                            <h5 class="mb-3"><i class="fas fa-notes-medical me-2 text-success"></i>Motif</h5>
                            <p class="mb-0"><?php echo htmlspecialchars($rendezVous['motif'] ?? ''); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="index.php?route=/medecin/consultation/store" method="POST" id="consultationForm">
            <input type="hidden" name="rendez_vous_id" value="<?php echo htmlspecialchars($rendezVous['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <div class="card-custom mb-4">
                <div class="card-header card-header-consultation">
                    <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Détails de la consultation</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Diagnostic <span class="text-danger">*</span></label>
                            <textarea name="diagnostic" class="form-control" rows="4" required placeholder="Entrez le diagnostic..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Traitement effectué <span class="text-danger">*</span></label>
                            <textarea name="traitement_effectue" class="form-control" rows="4" required placeholder="Détail du traitement réalisé..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Traitement prévu</label>
                            <textarea name="traitement_prevu" class="form-control" rows="4" placeholder="Plan de suivi ou prochaines étapes..."></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Dents traitées <span class="text-danger">*</span></label>
                            <input type="text" name="dents_traitees" class="form-control" placeholder="Ex: 11, 26, 36" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Prix (DH)</label>
                            <input type="number" step="0.01" name="prix" class="form-control" placeholder="Ex: 350.00" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Notes</label>
                            <input type="text" name="notes" class="form-control" placeholder="Observations supplémentaires...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-custom mb-4">
                <div class="card-header card-header-ordonnance">
                    <h5 class="mb-0"><i class="fas fa-prescription-bottle-alt me-2"></i>Ordonnance (optionnelle)</h5>
                </div>
                <div class="card-body">
                    <div class="toggle-card p-3 d-flex align-items-center justify-content-between" onclick="toggleOrdonnance()">
                        <div>
                            <h6 class="mb-1">Ajouter une ordonnance</h6>
                            <p class="mb-0 text-muted">Activez pour afficher la section de prescription.</p>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="hasOrdonnance" onchange="toggleOrdonnance()">
                        </div>
                    </div>
                    <div class="ordonnance-section" id="ordonnanceSection">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Médicaments</label>
                                <div id="medicamentsContainerConsultation">
                                    <div class="medicament-row" data-index="0">
                                        <div class="row gy-3">
                                            <div class="col-md-5">
                                                <label class="form-label">Nom du médicament</label>
                                                <input type="text" name="medicaments[0][nom_medicament]" class="form-control" placeholder="Ex: Amoxicilline">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Dosage</label>
                                                <input type="text" name="medicaments[0][dosage]" class="form-control" placeholder="Ex: 500 mg">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Fréquence</label>
                                                <input type="text" name="medicaments[0][frequence]" class="form-control" placeholder="Ex: 2 fois/jour">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMedicamentRowConsultation(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row gy-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label">Durée</label>
                                                <input type="text" name="medicaments[0][duree]" class="form-control" placeholder="Ex: 5 jours">
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Instructions</label>
                                                <input type="text" name="medicaments[0][instructions_medicament]" class="form-control" placeholder="Ex: À prendre après les repas">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-success mt-2" onclick="addMedicamentRowConsultation()">
                                    <i class="fas fa-plus me-1"></i> Ajouter un médicament
                                </button>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Posologie</label>
                                <textarea name="posologie" class="form-control" rows="3" placeholder="Ex: 1 comprimé 3 fois par jour pendant 7 jours"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instructions</label>
                                <textarea name="instructions" class="form-control" rows="3" placeholder="Conseils au patient, prise avant/après repas..."></textarea>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-info mb-0" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>L’ordonnance est liée automatiquement à la consultation lorsque vous terminez la consultation.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-5">
                <a href="index.php?route=/medecin/rendez-vous" class="btn btn-outline-secondary btn-secondary-custom"><i class="fas fa-times me-2"></i>Annuler</a>
                <button type="submit" class="btn btn-primary btn-primary-custom" id="submitBtn" onclick="return validateAndSubmit(this);">
                    <i class="fas fa-check-circle me-2"></i>Terminer la consultation
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let medicamentIndexConsultation = 1;
        let isSubmitting = false;

        // ========== DEBUG FRONTEND - LOGS DÉTAILLÉS ==========
        document.getElementById('consultationForm').addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                alert('Enregistrement en cours, veuillez patienter...');
                return false;
            }

            const submitBtn = document.getElementById('submitBtn');
            const originalBtnContent = submitBtn.innerHTML;
            
            // ========== STEP 0: Début ==========
            console.log('═══════════════════════════════════════════');
            console.log('🔵 DEBUG: Début soumission formulaire');
            console.log('═══════════════════════════════════════════');
            
            // Collecter toutes les données du formulaire
            const formData = new FormData(this);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            // ========== STEP 1: Données collectées ==========
            console.log('▸ STEP 1: Données collectées du formulaire');
            console.log('   - rendez_vous_id:', data.rendez_vous_id, '(type:', typeof data.rendez_vous_id + ')');
            console.log('   - diagnostic:', data.diagnostic ? data.diagnostic.substring(0, 50) + '...' : 'VIDE');
            console.log('   - traitement_effectue:', data.traitement_effectue ? data.traitement_effectue.substring(0, 50) + '...' : 'VIDE');
            console.log('   - dents_traitees:', data.dents_traitees);
            console.log('   - prix:', data.prix);
            console.log('   - posologie:', data.posologie || 'non définie');
            console.log('   - instructions:', data.instructions || 'non définies');
            
            // Parser les médicaments
            const medicaments = [];
            for (let [key, value] of formData.entries()) {
                const match = key.match(/^medicaments\[(\d+)\]\[(.+)\]$/);
                if (match) {
                    const index = parseInt(match[1]);
                    const field = match[2];
                    if (!medicaments[index]) medicaments[index] = {};
                    medicaments[index][field] = value;
                }
            }
            const validMeds = medicaments.filter(m => m && m.nom_medicament);
            console.log('▸ STEP 1b: Médicaments');
            console.log('   - Total lignes medicaments:', medicaments.length);
            console.log('   - Médicaments valides:', validMeds.length);
            validMeds.forEach((m, i) => {
                console.log('     * Med ' + (i+1) + ':', m.nom_medicament, '-', m.dosage, '-', m.frequence);
            });
            
            // ========== STEP 2: Validation ==========
            console.log('▸ STEP 2: Validation des champs');
            let hasError = false;
            let errorMessages = [];
            
            if (!data.diagnostic || data.diagnostic.trim() === '') {
                errorMessages.push('Diagnostic manquant');
                hasError = true;
                console.log('   ❌ diagnostic: VIDE');
            } else {
                console.log('   ✓ diagnostic: OK');
            }
            
            if (!data.traitement_effectue || data.traitement_effectue.trim() === '') {
                errorMessages.push('Traitement effectué manquant');
                hasError = true;
                console.log('   ❌ traitement_effectue: VIDE');
            } else {
                console.log('   ✓ traitement_effectue: OK');
            }
            
            if (!data.dents_traitees || data.dents_traitees.trim() === '') {
                errorMessages.push('Dents traitées manquantes');
                hasError = true;
                console.log('   ❌ dents_traitees: VIDE');
            } else {
                console.log('   ✓ dents_traitees: OK');
            }
            
            const hasOrdonnance = document.getElementById('hasOrdonnance').checked;
            console.log('   - hasOrdonnance (checkbox):', hasOrdonnance);
            console.log('   - posologie présente:', !!data.posologie);
            console.log('   - medicaments valides:', validMeds.length > 0);
            
            if (hasOrdonnance && validMeds.length > 0 && (!data.posologie || data.posologie.trim() === '')) {
                errorMessages.push('Posologie requise pour ordonnance');
                hasError = true;
                console.log('   ❌ posologie: REQUISE mais vide');
            } else if (hasOrdonnance && validMeds.length > 0) {
                console.log('   ✓ posologie: OK');
            }
            
            if (hasError) {
                console.log('▸ STEP 2b: ÉCHEC validation');
                console.error('   Erreurs:', errorMessages);
                e.preventDefault();
                alert('Erreurs détectées:\n' + errorMessages.join('\n'));
                return false;
            }
            
            console.log('▸ STEP 2b: Validation PASSÉE ✓');
            
            // ========== STEP 3: Préparation soumission ==========
            console.log('▸ STEP 3: Préparation soumission');
            console.log('   - Ordonnance à créer:', hasOrdonnance || validMeds.length > 0);
            console.log('   - Nombre medicaments:', validMeds.length);
            
            // ========== STEP 4: Loading ==========
            console.log('▸ STEP 4: Activation loading');
            isSubmitting = true;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enregistrement en cours...';
            
            // Timeout de sécurité
            setTimeout(() => {
                console.log('   ⚠️ Timeout sécurité activé (30s)');
                if (isSubmitting) {
                    isSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;
                    alert('L\'enregistrement prend plus de temps que prévu.');
                }
            }, 30000);
            
            console.log('▸ STEP 5: Formulaire soumis au serveur');
            console.log('═══════════════════════════════════════════');
            console.log('⏳ En attente de réponse du serveur...');
            console.log('═══════════════════════════════════════════');
        });

        function toggleOrdonnance() {
            const checkbox = document.getElementById('hasOrdonnance');
            const section = document.getElementById('ordonnanceSection');
            // Synchroniser checkbox et section
            const isChecked = checkbox.checked;
            section.classList.toggle('active', isChecked);
            console.log('Ordonnance toggled:', isChecked ? 'activée' : 'désactivée');
        }

        function addMedicamentRowConsultation() {
            const container = document.getElementById('medicamentsContainerConsultation');
            const row = document.createElement('div');
            row.className = 'medicament-row';
            row.dataset.index = medicamentIndexConsultation;
            row.innerHTML = `
                <div class="row gy-3">
                    <div class="col-md-5">
                        <label class="form-label">Nom du médicament</label>
                        <input type="text" name="medicaments[${medicamentIndexConsultation}][nom_medicament]" class="form-control" placeholder="Ex: Amoxicilline">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dosage</label>
                        <input type="text" name="medicaments[${medicamentIndexConsultation}][dosage]" class="form-control" placeholder="Ex: 500 mg">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Fréquence</label>
                        <input type="text" name="medicaments[${medicamentIndexConsultation}][frequence]" class="form-control" placeholder="Ex: 2 fois/jour">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMedicamentRowConsultation(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row gy-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Durée</label>
                        <input type="text" name="medicaments[${medicamentIndexConsultation}][duree]" class="form-control" placeholder="Ex: 5 jours">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Instructions</label>
                        <input type="text" name="medicaments[${medicamentIndexConsultation}][instructions_medicament]" class="form-control" placeholder="Ex: À prendre après les repas">
                    </div>
                </div>`;
            container.appendChild(row);
            medicamentIndexConsultation++;
        }

        function removeMedicamentRowConsultation(btn) {
            const row = btn.closest('.medicament-row');
            const container = document.getElementById('medicamentsContainerConsultation');
            if (container.children.length > 1) {
                row.remove();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('ordonnanceSection').classList.remove('active');
        });

        function validateAndSubmit(btn) {
            const hasOrdonnance = document.getElementById('hasOrdonnance').checked;
            const posologie = document.querySelector('textarea[name="posologie"]').value.trim();
            const medicamentRows = document.querySelectorAll('#medicamentsContainerConsultation .medicament-row');
            
            let hasMedicament = false;
            medicamentRows.forEach(row => {
                const nom = row.querySelector('input[name$="[nom_medicament]"]').value.trim();
                if (nom) hasMedicament = true;
            });

            if (hasOrdonnance && !hasMedicament) {
                alert('Veuillez ajouter au moins un médicament pour l\'ordonnance.');
                return false;
            }

            if (hasOrdonnance && hasMedicament && !posologie) {
                alert('La posologie est requise lorsqu\'un médicament est ajouté.');
                return false;
            }

            // Use class instead of disabled to allow form submission
            btn.classList.add('btn-loading');
            btn.dataset.originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enregistrement...';
            
            // Safety timeout - re-enable button after 30 seconds if no response
            setTimeout(function() {
                if (btn.classList.contains('btn-loading')) {
                    btn.classList.remove('btn-loading');
                    btn.innerHTML = btn.dataset.originalHtml || '<i class="fas fa-check-circle me-2"></i>Terminer la consultation';
                    alert('L\'enregistrement prend plus de temps que prévu. Veuillez vérifier si les données ont été enregistrées.');
                }
            }, 30000);
            
            return true;
        }

        // Re-enable button on page load if it was stuck in loading state
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn && submitBtn.classList.contains('btn-loading')) {
                submitBtn.classList.remove('btn-loading');
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
