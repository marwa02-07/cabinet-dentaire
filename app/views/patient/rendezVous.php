<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre Rendez-vous - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/patient-theme.css" rel="stylesheet">
</head>
<body class="patient-body">
    <nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?route=/patient/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Patient
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/patient/rendez-vous/create">
                            <i class="fas fa-calendar-plus me-1"></i>Nouveau rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/patient/rendez-vous">
                            <i class="fas fa-calendar-check me-1"></i>Mes rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/patient/consultations">
                            <i class="fas fa-file-medical-alt me-1"></i>Consultations
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="patient-pill">
                        <i class="fas fa-user"></i>
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
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-calendar-plus me-2"></i>Prendre un rendez-vous</h1>
            <p class="welcome-sub">Seules les dates et heures encore disponibles pour le praticien (et pour vous-même) sont proposées.</p>
        </section>

        <div class="mb-4">
            <a href="index.php?route=/patient/dashboard" class="btn btn-retour">
                <i class="fas fa-arrow-left me-2"></i>Retour au tableau de bord
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="panel p-4">
                    <h4 class="panel-title h5 mb-4"><i class="fas fa-calendar-plus me-2 text-primary"></i>Nouveau rendez-vous</h4>
                    <?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show"><?php echo htmlspecialchars($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show"><?php echo htmlspecialchars($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="index.php?route=/patient/rendez-vous/store" method="POST" class="patient-form" id="rdvForm">
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-stethoscope me-1"></i>Type de consultation *</label>
                            <select name="type_rendez_vous" id="typeSelect" class="form-select" required>
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

                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-user-md me-1"></i>Choisir un dentiste *</label>
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
                            <div id="dentisteHelpText" class="form-text text-muted">Choisissez un type pour filtrer les dentistes adaptés.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-hourglass-half me-1"></i>Durée estimée *</label>
                            <select name="duree_minutes" id="dureeSelect" class="form-select" required>
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">1 heure</option>
                            </select>
                            <div class="form-text text-muted">La durée détermine les créneaux proposés (les plages déjà prises sont exclues).</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label"><i class="fas fa-calendar-alt me-1"></i>Date *</label>
                                <select id="dateSelect" name="date" class="form-select" required disabled>
                                    <option value="">Choisissez d'abord un dentiste et une durée</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-clock me-1"></i>Heure *</label>
                                <select id="heureSelect" name="heure" class="form-select" required disabled>
                                    <option value="">Choisissez d'abord une date</option>
                                </select>
                            </div>
                        </div>
                        <p id="slotHelpText" class="small text-muted mb-4"></p>

                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-comment me-1"></i>Motif de la visite *</label>
                            <textarea name="motif" class="form-control" rows="3" placeholder="Décrivez brièvement votre motif de consultation..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-submit" id="submitRdv">
                            <i class="fas fa-check me-2"></i>Confirmer le rendez-vous
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('typeSelect');
            const dentistSelect = document.getElementById('dentisteSelect');
            const dureeSelect = document.getElementById('dureeSelect');
            const dateSelect = document.getElementById('dateSelect');
            const heureSelect = document.getElementById('heureSelect');
            const helpText = document.getElementById('dentisteHelpText');
            const slotHelpText = document.getElementById('slotHelpText');

            const dentistOptions = Array.from(dentistSelect.querySelectorAll('option[data-specialite]'));

            const API_DATES = 'index.php?route=/patient/rendez-vous/available-dates';
            const API_SLOTS = 'index.php?route=/patient/rendez-vous/available-slots';

            function formatFrDate(ymd) {
                const p = ymd.split('-');
                if (p.length !== 3) return ymd;
                return p[2] + '/' + p[1] + '/' + p[0];
            }

            const specialtyMap = {
                consultation: ['consultation', 'dentaire', 'odontologie', 'généraliste', 'generaliste', 'général', 'general'],
                nettoyage: ['nettoyage', 'hygiène', 'hygiene', 'prophylaxie', 'parodontie', 'détartrage', 'detartrage'],
                extraction: ['extraction', 'chirurgie', 'orale', 'chirurgical', 'implantologie'],
                traitement: ['traitement', 'endodontie', 'restauration', 'obturation', 'prothèse', 'prothese', 'odontologie', 'parodontie'],
                blanchiment: ['blanchiment', 'esthétique', 'esthetique', 'cosmétique', 'cosmetique', 'esthetique'],
                radio: ['radio', 'imagerie', 'radiologie', 'scanner', 'panoramique', 'cone beam'],
                autre: ['consultation', 'dentaire', 'odontologie', 'généraliste', 'generaliste', 'général', 'general']
            };

            function filterDentists() {
                const type = typeSelect.value || '';
                const keywords = specialtyMap[type] || [];
                const normalizedType = type.trim().toLowerCase();

                dentistSelect.innerHTML = '<option value="">-- Sélectionner un dentiste --</option>';
                let count = 0;

                dentistOptions.forEach(option => {
                    const specialite = (option.dataset.specialite || '').toLowerCase();
                    let keep = false;

                    if (normalizedType === '') {
                        keep = true;
                    } else {
                        keep = keywords.some(keyword => specialite.includes(keyword.toLowerCase()));
                        if (!keep && (normalizedType === 'consultation' || normalizedType === 'autre') && !specialite.trim()) {
                            keep = true;
                        }
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
                    ? 'Dentistes filtrés pour le type : ' + normalizedType
                    : 'Choisissez un type de consultation pour filtrer les dentistes spécialisés.';

                resetDateAndTime();
                loadDates();
            }

            function resetDateAndTime() {
                dateSelect.innerHTML = '<option value="">—</option>';
                dateSelect.disabled = true;
                heureSelect.innerHTML = '<option value="">Choisissez d\'abord une date</option>';
                heureSelect.disabled = true;
                slotHelpText.textContent = '';
            }

            async function loadDates() {
                const did = dentistSelect.value;
                const duree = dureeSelect.value || '30';

                heureSelect.innerHTML = '<option value="">Choisissez d\'abord une date</option>';
                heureSelect.disabled = true;
                slotHelpText.textContent = '';

                if (!did || dentistSelect.disabled) {
                    dateSelect.innerHTML = '<option value="">Choisissez d\'abord un dentiste et une durée</option>';
                    dateSelect.disabled = true;
                    return;
                }

                dateSelect.innerHTML = '<option value="">Chargement des dates…</option>';
                dateSelect.disabled = true;

                try {
                    const url = API_DATES + '&dentiste_id=' + encodeURIComponent(did) + '&duree_minutes=' + encodeURIComponent(duree);
                    const res = await fetch(url, { credentials: 'same-origin' });
                    const data = await res.json();

                    dateSelect.innerHTML = '';

                    if (!data.ok || !Array.isArray(data.dates)) {
                        dateSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        dateSelect.disabled = true;
                        return;
                    }

                    if (data.dates.length === 0) {
                        dateSelect.innerHTML = '<option value="">Aucune date libre (90 jours)</option>';
                        dateSelect.disabled = true;
                        slotHelpText.textContent = 'Aucun créneau disponible pour ce dentiste avec cette durée sur les trois prochains mois.';
                        return;
                    }

                    const opt0 = document.createElement('option');
                    opt0.value = '';
                    opt0.textContent = '— Choisissez une date —';
                    dateSelect.appendChild(opt0);

                    data.dates.forEach(function (ymd) {
                        const opt = document.createElement('option');
                        opt.value = ymd;
                        opt.textContent = formatFrDate(ymd);
                        dateSelect.appendChild(opt);
                    });

                    dateSelect.disabled = false;
                    slotHelpText.textContent = data.dates.length + ' jour(s) avec au moins un créneau libre.';
                } catch (e) {
                    dateSelect.innerHTML = '<option value="">Erreur réseau</option>';
                    dateSelect.disabled = true;
                }
            }

            async function loadSlots() {
                const did = dentistSelect.value;
                const duree = dureeSelect.value || '30';
                const date = dateSelect.value;

                if (!did || !date) {
                    heureSelect.innerHTML = '<option value="">Choisissez d\'abord une date</option>';
                    heureSelect.disabled = true;
                    return;
                }

                heureSelect.innerHTML = '<option value="">Chargement des heures…</option>';
                heureSelect.disabled = true;

                try {
                    const url = API_SLOTS + '&dentiste_id=' + encodeURIComponent(did) + '&date=' + encodeURIComponent(date) + '&duree_minutes=' + encodeURIComponent(duree);
                    const res = await fetch(url, { credentials: 'same-origin' });
                    const data = await res.json();

                    heureSelect.innerHTML = '';

                    if (!data.ok || !Array.isArray(data.slots)) {
                        heureSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        heureSelect.disabled = true;
                        return;
                    }

                    if (data.slots.length === 0) {
                        heureSelect.innerHTML = '<option value="">Aucune heure libre ce jour</option>';
                        heureSelect.disabled = true;
                        slotHelpText.textContent = 'Ce jour ne comporte plus de créneau libre pour cette durée — choisissez une autre date.';
                        return;
                    }

                    const opt0 = document.createElement('option');
                    opt0.value = '';
                    opt0.textContent = '— Choisissez une heure —';
                    heureSelect.appendChild(opt0);

                    data.slots.forEach(function (hm) {
                        const opt = document.createElement('option');
                        opt.value = hm;
                        opt.textContent = hm;
                        heureSelect.appendChild(opt);
                    });

                    heureSelect.disabled = false;
                    slotHelpText.textContent = data.slots.length + ' horaire(s) disponible(s).';
                } catch (e) {
                    heureSelect.innerHTML = '<option value="">Erreur réseau</option>';
                    heureSelect.disabled = true;
                }
            }

            typeSelect.addEventListener('change', filterDentists);
            dentistSelect.addEventListener('change', function () {
                resetDateAndTime();
                loadDates();
            });
            dureeSelect.addEventListener('change', function () {
                resetDateAndTime();
                loadDates();
            });
            dateSelect.addEventListener('change', loadSlots);

            filterDentists();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
