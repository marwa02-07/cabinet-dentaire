<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/secretaire-theme.css" rel="stylesheet">
</head>
<body class="secretaire-body">
<nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?route=/secretaire/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Secrétaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/secretaire/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/rendezvous">
                            <i class="fas fa-calendar-check me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/planning">
                            <i class="fas fa-calendar-alt me-1"></i>Planning
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="secretary-pill">
                        <i class="fas fa-user-tie"></i>
                        <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?>
                    </div>
                    <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard planning-inner">
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-calendar-alt me-2"></i>Planning du cabinet</h1>
            <p class="welcome-sub">Visualisation des rendez-vous par date et par dentiste.</p>
        </section>

        <div class="container">
        <!-- Navigation Bar -->
        <div class="planning-nav">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <?php $prevDay = date('Y-m-d', strtotime($dateFilter . ' -1 day')); ?>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo $prevDay; ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="nav-btn">
                        <i class="fas fa-chevron-left"></i> Précédent
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="date-display">
                        <?php
                        $dateObj = new DateTime($dateFilter);
                        $dayNames = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                        $monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                        ?>
                        <div class="day-name"><?php echo $dayNames[$dateObj->format('w')]; ?></div>
                        <div class="day-number"><?php echo $dateObj->format('d'); ?></div>
                        <div class="month-year"><?php echo $monthNames[$dateObj->format('n') - 1]; ?> <?php echo $dateObj->format('Y'); ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php $nextDay = date('Y-m-d', strtotime($dateFilter . ' +1 day')); ?>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo $nextDay; ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="nav-btn" style="margin-left: auto;">
                        Suivant <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="index.php?route=/secretaire/planning&date=<?php echo date('Y-m-d'); ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="nav-btn today">
                    <i class="fas fa-calendar-day"></i> Aujourd'hui
                </a>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="filters-card">
            <h4><i class="fas fa-filter"></i> Filtres</h4>
            <form method="GET" action="index.php" class="row g-3">
                <input type="hidden" name="route" value="/secretaire/planning">
                <div class="col-md-5">
                    <label class="form-label"><i class="fas fa-calendar-alt"></i> Date</label>
                    <input type="date" name="date" class="form-control" value="<?php echo $dateFilter; ?>">
                </div>
                <div class="col-md-5">
                    <label class="form-label"><i class="fas fa-user-md"></i> Dentiste</label>
                    <select name="dentiste" class="form-select">
                        <option value="">Tous les dentistes</option>
                        <?php foreach ($dentistes as $d): ?>
                            <option value="<?php echo $d['id']; ?>" <?php echo ($dentisteFilter ?? '') == $d['id'] ? 'selected' : ''; ?>>
                                Dr. <?php echo htmlspecialchars(($d['prenom'] ?? '') . ' ' . ($d['nom'] ?? '')); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-filter w-100">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Planning Section -->
        <div class="planning-section">
            <div class="planning-section-header">
                <h3><i class="fas fa-list"></i> Rendez-vous</h3>
                <span class="rdv-count">
                    <i class="fas fa-calendar-check"></i> <?php echo count($rendezvous); ?> RDV
                </span>
            </div>
            <div class="planning-section-body">
                <?php if (empty($rendezvous)): ?>
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h4>Aucun rendez-vous</h4>
                        <p>Aucun rendez-vous prévu pour cette date.</p>
                        <a href="index.php?route=/secretaire/rendezvous/create" class="btn-create-rdv">
                            <i class="fas fa-plus"></i> Créer un rendez-vous
                        </a>
                    </div>
                <?php else: ?>
                    <?php
                    // Group appointments by hour
                    $groupedRdv = [];
                    foreach ($rendezvous as $rdv) {
                        $hour = date('H:i', strtotime($rdv['date_heure'] ?? ''));
                        if (!isset($groupedRdv[$hour])) {
                            $groupedRdv[$hour] = [];
                        }
                        $groupedRdv[$hour][] = $rdv;
                    }
                    ksort($groupedRdv);
                    ?>
                    
                    <?php foreach ($groupedRdv as $hour => $rdvs): ?>
                        <div class="time-slot">
                            <div class="time-slot-header">
                                <span class="time-badge"><?php echo $hour; ?></span>
                                <span class="slot-label"><?php echo count($rdvs); ?> rendez-vous(s)</span>
                            </div>
                            
                            <?php foreach ($rdvs as $rdv): ?>
                                <div class="appointment-card">
                                    <div class="appt-time">
                                        <div class="time"><?php echo date('H:i', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                        <div class="duration"><?php echo $rdv['duree_minutes'] ?? 30; ?> min</div>
                                    </div>
                                    <div class="appt-info">
                                        <div class="patient-name">
                                            <i class="fas fa-user"></i> <?php echo htmlspecialchars(($rdv['patient_prenom'] ?? '') . ' ' . ($rdv['patient_nom'] ?? '')); ?>
                                        </div>
                                        <div class="details">
                                            <i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')); ?>
                                            &nbsp;|&nbsp;
                                            <i class="fas fa-stethoscope"></i> <?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'] ?? 'Consultation')); ?>
                                        </div>
                                    </div>
                                    <span class="appt-type"><?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'] ?? 'Consultation')); ?></span>
                                    <span class="appt-status status-<?php echo $rdv['statut'] ?? 'planifie'; ?>">
                                        <?php echo ucfirst($rdv['statut'] ?? 'planifié'); ?>
                                    </span>
                                    <div class="appt-actions">
                                        <a href="index.php?route=/secretaire/rendezvous/edit&id=<?php echo $rdv['id']; ?>" class="btn btn-primary-custom btn-sm text-white border-0">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick Navigation -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <?php $prevWeek = date('Y-m-d', strtotime($dateFilter . ' -7 day')); ?>
                    <?php $nextWeek = date('Y-m-d', strtotime($dateFilter . ' +7 day')); ?>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo $prevWeek; ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-chevron-left"></i> Semaine précédente
                    </a>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo date('Y-m-d'); ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="btn btn-primary-custom border-0">
                        <i class="fas fa-calendar-day"></i> Aujourd'hui
                    </a>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo $nextWeek; ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="btn btn-outline-secondary">
                        Semaine suivante <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
