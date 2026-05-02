<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre Rendez-vous - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        .navbar-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-custom .navbar-brand { font-weight: 700; font-size: 20px; color: white !important; }
        .page-header { background: white; padding: 30px 0; margin-bottom: 30px; border-bottom: 1px solid #e9ecef; }
        .page-header h1 { color: #2c3e50; font-weight: 700; margin: 0; font-size: 32px; }
        .card-custom { background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px; }
        .form-label { color: #2c3e50; font-weight: 600; }
        .btn-submit { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px 30px; border-radius: 6px; font-weight: 600; width: 100%; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4); color: white; }
        .btn-retour { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-tooth"></i> Cabinet Dentaire</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-white me-3"><i class="fas fa-user"></i> <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                <a href="index.php?route=/logout" class="btn btn-sm btn-danger"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1>Prendre un Rendez-vous</h1>
            <p>Planifiez votre consultation avec un dentiste</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <a href="index.php?route=/patient/dashboard" class="btn btn-retour mb-4"><i class="fas fa-arrow-left"></i> Retour</a>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-custom">
                    <h4 class="mb-4"><i class="fas fa-calendar-plus"></i> Nouveau Rendez-vous</h4>
                    <?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    
                    <form action="index.php?route=/patient/rendez-vous/store" method="POST">
                        <!-- Sélection du dentiste -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-user-md"></i> Choisir un dentiste *</label>
                            <select id="dentisteSelect" name="dentiste_id" class="form-select" required>
                                <option value="">-- Sélectionner un dentiste --</option>
                                <?php if (!empty($dentistes)): ?>
                                    <?php foreach ($dentistes as $dentiste): ?>
                                        <option value="<?php echo $dentiste['id']; ?>" data-specialite="<?php echo htmlspecialchars(strtolower($dentiste['specialite'] ?? '')); ?>">
                                            Dr. <?php echo htmlspecialchars($dentiste['prenom'] . ' ' . $dentiste['nom']); ?> 
                                            - <?php echo htmlspecialchars($dentiste['specialite'] ?? 'Chirurgie Dentaire'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Aucun dentiste disponible</option>
                                <?php endif; ?>
                            </select>
                            <div id="dentisteHelpText" class="form-text">Choisissez un type de consultation pour filtrer les dentistes spécialisés.</div>
                        </div>
                        
                        <!-- Date et heure -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-calendar-alt"></i> Date *</label>
                                <input type="date" name="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-clock"></i> Heure *</label>
                                <input type="time" name="heure" class="form-control" min="09:00" max="18:00" required>
                            </div>
                        </div>
                        
                        <!-- Type de rendez-vous -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-stethoscope"></i> Type de consultation *</label>
                            <select name="type_rendez_vous" class="form-select" required>
                                <option value="">-- Sélectionner le type --</option>
                                <option value="consultation">Consultation</option>
                                <option value="nettoyage">Nettoyage</option>
                                <option value="extraction">Extraction</option>
                                <option value="traitement">Traitement</option>
                                <option value="blanchiment">Blanchiment</option>
                                <option value="radio">Radio</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        
                        <!-- Motif -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-comment"></i> Motif de la visite *</label>
                            <textarea name="motif" class="form-control" rows="3" placeholder="Décrivez brièvement votre motif de consultation..." required></textarea>
                        </div>
                        
                        <!-- Durée -->
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-hourglass-half"></i> Durée estimée</label>
                            <select name="duree_minutes" class="form-select">
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">1 heure</option>
                            </select>
                        </div>
                        
                        <!-- Submit -->
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-check"></i> Confirmer le rendez-vous
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.querySelector('select[name="type_rendez_vous"]');
            const dentistSelect = document.querySelector('#dentisteSelect');
            const dentistOptions = Array.from(dentistSelect.querySelectorAll('option[data-specialite]'));
            const helpText = document.querySelector('#dentisteHelpText');

            const specialtyMap = {
                consultation: [],
                nettoyage: ['nettoyage', 'hygiene', 'hygiène', 'prophylaxie'],
                extraction: ['extraction', 'chirurgie', 'orale'],
                traitement: ['traitement', 'endodontie', 'restauration'],
                blanchiment: ['blanchiment', 'esthétique', 'esthetique', 'cosmétique', 'cosmetique'],
                radio: ['radio', 'imagerie', 'radiologie'],
                autre: []
            };

            function filterDentists() {
                const type = typeSelect.value || '';
                const keywords = specialtyMap[type] || [];
                const normalizedType = type.trim().toLowerCase();

                dentistSelect.innerHTML = '<option value="">-- Sélectionner un dentiste --</option>';
                let count = 0;

                dentistOptions.forEach(option => {
                    const specialite = option.dataset.specialite || '';
                    let keep = false;

                    if (normalizedType === '' || normalizedType === 'consultation' || normalizedType === 'autre') {
                        keep = true;
                    } else {
                        keep = keywords.some(keyword => specialite.includes(keyword));
                    }

                    if (keep) {
                        dentistSelect.appendChild(option.cloneNode(true));
                        count++;
                    }
                });

                if (count === 0) {
                    const emptyOption = document.createElement('option');
                    emptyOption.value = '';
                    emptyOption.textContent = 'Aucun dentiste disponible pour ce type';
                    dentistSelect.appendChild(emptyOption);
                    dentistSelect.disabled = true;
                } else {
                    dentistSelect.disabled = false;
                }

                helpText.textContent = normalizedType
                    ? 'Dentistes filtrés pour le type: ' + normalizedType
                    : 'Choisissez un type de consultation pour filtrer les dentistes spécialisés.';
            }

            typeSelect.addEventListener('change', filterDentists);
            filterDentists();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>