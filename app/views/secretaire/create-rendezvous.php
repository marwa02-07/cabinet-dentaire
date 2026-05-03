<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Rendez-vous - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>css/secretaire-theme.css" rel="stylesheet">
</head>
<body class="secretaire-body">
<nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Secrétaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous">
                            <i class="fas fa-calendar-check me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/planning">
                            <i class="fas fa-calendar-alt me-1"></i>Planning
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="secretary-pill">
                        <i class="fas fa-user-tie"></i>
                        <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?>
                    </div>
                    <a href="<?php echo BASE_URL; ?>index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard">
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-calendar-plus me-2"></i>Nouveau rendez-vous</h1>
            <p class="welcome-sub">Créer un nouveau rendez-vous.</p>
        </section>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="panel p-3 p-md-4">
            <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/store" class="sec-form" id="secRdvForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient *</label>
                        <select name="patient_id" id="patientSelect" class="form-select" required>
                            <option value="">Sélectionner un patient</option>
                            <?php $prefill = (int) ($prefillPatientId ?? 0); ?>
                            <?php foreach ($patients as $p): ?>
                                <option value="<?php echo (int) $p['id']; ?>" <?php echo $prefill === (int) $p['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(($p['prenom'] ?? '') . ' ' . ($p['nom'] ?? '')); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Durée *</label>
                        <select name="duree_minutes" id="dureeSelect" class="form-select" required>
                            <option value="15">15 minutes</option>
                            <option value="30" selected>30 minutes</option>
                            <option value="45">45 minutes</option>
                            <option value="60">60 minutes</option>
                        </select>
                        <div class="form-text text-muted">Les créneaux déjà réservés (dentiste ou ce patient) sont exclus.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type de rendez-vous *</label>
                        <select name="type_rendez_vous" id="type_rendez_vous" class="form-select" required>
                            <option value="">Sélectionner un type</option>
                            <?php foreach (ConsultationTypeCatalog::getTypes() as $typeKey => $typeLabel): ?>
                                <option value="<?php echo htmlspecialchars($typeKey); ?>"><?php echo htmlspecialchars($typeLabel); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dentiste *</label>
                        <select name="dentiste_id" id="dentiste_id" class="form-select" required>
                            <option value="">Sélectionner un dentiste</option>
                            <?php foreach ($dentistes as $d): ?>
                                <?php $specialiteType = ConsultationTypeCatalog::normalize($d['specialite'] ?? ''); ?>
                                <option value="<?php echo (int) $d['id']; ?>" data-specialite-type="<?php echo htmlspecialchars($specialiteType); ?>">
                                    Dr. <?php echo htmlspecialchars(($d['prenom'] ?? '') . ' ' . ($d['nom'] ?? '')); ?> - <?php echo htmlspecialchars(ConsultationTypeCatalog::getLabel($d['specialite'] ?? '') ?: 'Non défini'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="dentisteHelpText" class="form-text text-muted">Filtré selon le type de rendez-vous.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date *</label>
                        <select name="date" id="dateSelect" class="form-select" required disabled>
                            <option value="">Choisissez patient, dentiste et durée</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Heure *</label>
                        <select name="heure" id="heureSelect" class="form-select" required disabled>
                            <option value="">Choisissez d'abord une date</option>
                        </select>
                    </div>
                </div>
                <p id="slotHelpText" class="small text-muted mb-3"></p>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Motif</label>
                        <input type="text" name="motif" class="form-control" placeholder="Motif du rendez-vous">
                    </div>
                </div>
                <div class="text-end">
                    <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous" class="btn btn-outline-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary-custom ms-2">
                        <i class="fas fa-save me-1"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const patientSelect = document.getElementById('patientSelect');
            const typeSelect = document.getElementById('type_rendez_vous');
            const dentistSelect = document.getElementById('dentiste_id');
            const dureeSelect = document.getElementById('dureeSelect');
            const dateSelect = document.getElementById('dateSelect');
            const heureSelect = document.getElementById('heureSelect');
            const helpText = document.getElementById('dentisteHelpText');
            const slotHelpText = document.getElementById('slotHelpText');

            const dentistOptions = Array.from(dentistSelect.querySelectorAll('option[data-specialite-type]'));

            const API_DATES = 'index.php?route=/secretaire/rendezvous/available-dates';
            const API_SLOTS = 'index.php?route=/secretaire/rendezvous/available-slots';

            function formatFrDate(ymd) {
                const p = ymd.split('-');
                if (p.length !== 3) return ymd;
                return p[2] + '/' + p[1] + '/' + p[0];
            }

            function filterDentists() {
                const type = typeSelect.value || '';
                const normalizedType = type.trim().toLowerCase();

                dentistSelect.innerHTML = '<option value="">Sélectionner un dentiste</option>';
                let count = 0;

                dentistOptions.forEach(option => {
                    const specialiteType = (option.dataset.specialiteType || '').toLowerCase();
                    const keep = normalizedType === '' ? true : specialiteType === normalizedType;

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
                    ? 'Dentistes filtrés pour le type sélectionné.'
                    : 'Choisissez un type pour filtrer les dentistes adaptés.';

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
                const pid = patientSelect.value;
                const did = dentistSelect.value;
                const duree = dureeSelect.value || '30';

                heureSelect.innerHTML = '<option value="">Choisissez d\'abord une date</option>';
                heureSelect.disabled = true;
                slotHelpText.textContent = '';

                if (!pid) {
                    dateSelect.innerHTML = '<option value="">Choisissez d\'abord un patient</option>';
                    dateSelect.disabled = true;
                    return;
                }

                if (!did || dentistSelect.disabled) {
                    dateSelect.innerHTML = '<option value="">Choisissez un dentiste et une durée</option>';
                    dateSelect.disabled = true;
                    return;
                }

                dateSelect.innerHTML = '<option value="">Chargement des dates…</option>';
                dateSelect.disabled = true;

                try {
                    const url = API_DATES
                        + '&dentiste_id=' + encodeURIComponent(did)
                        + '&patient_id=' + encodeURIComponent(pid)
                        + '&duree_minutes=' + encodeURIComponent(duree);
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
                        slotHelpText.textContent = 'Aucun créneau disponible pour ce dentiste et ce patient avec cette durée sur les trois prochains mois.';
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
                const pid = patientSelect.value;
                const did = dentistSelect.value;
                const duree = dureeSelect.value || '30';
                const date = dateSelect.value;

                if (!pid || !did || !date) {
                    heureSelect.innerHTML = '<option value="">Choisissez d\'abord une date</option>';
                    heureSelect.disabled = true;
                    return;
                }

                heureSelect.innerHTML = '<option value="">Chargement des heures…</option>';
                heureSelect.disabled = true;

                try {
                    const url = API_SLOTS
                        + '&dentiste_id=' + encodeURIComponent(did)
                        + '&patient_id=' + encodeURIComponent(pid)
                        + '&date=' + encodeURIComponent(date)
                        + '&duree_minutes=' + encodeURIComponent(duree);
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
            patientSelect.addEventListener('change', function () {
                resetDateAndTime();
                loadDates();
            });
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
