<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        
        /* Navbar */
        .navbar-custom { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .navbar-custom .navbar-brand { 
            font-weight: 700; 
            font-size: 20px; 
            color: white !important; 
        }
        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin-left: 15px;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: white !important;
        }
        .user-info {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-right: 20px;
        }
        .user-info strong {
            color: white;
            font-weight: 600;
        }
        .role-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
            font-weight: 600;
            margin-left: 10px;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            color: white;
        }
        
        /* Page Header */
        .page-header { 
            background: white; 
            padding: 30px 0; 
            margin-bottom: 30px; 
            border-bottom: 1px solid #e9ecef; 
        }
        .page-header h1 { 
            color: #2c3e50; 
            font-weight: 700; 
            margin: 0; 
            font-size: 32px; 
        }
        .page-header p {
            color: #6c757d;
            margin: 10px 0 0 0;
            font-size: 16px;
        }
        
        /* Navigation Bar */
        .planning-nav {
            background: white;
            border-radius: 12px;
            padding: 20px 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .planning-nav .date-display {
            text-align: center;
        }
        .planning-nav .date-display .day-name {
            font-size: 14px;
            color: #667eea;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .planning-nav .date-display .day-number {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1;
        }
        .planning-nav .date-display .month-year {
            font-size: 16px;
            color: #6c757d;
        }
        .planning-nav .nav-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .planning-nav .nav-btn {
            background: #f8f9fa;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            color: #2c3e50;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .planning-nav .nav-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }
        .planning-nav .nav-btn.today {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .planning-nav .nav-btn.today:hover {
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Filters */
        .filters-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .filters-card h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 18px;
        }
        .form-label {
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
        }
        .btn-filter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        /* Planning Cards */
        .planning-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .planning-section-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .planning-section-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .planning-section-header .rdv-count {
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .planning-section-body {
            padding: 30px;
        }
        
        /* Time Slot */
        .time-slot {
            margin-bottom: 30px;
        }
        .time-slot:last-child {
            margin-bottom: 0;
        }
        .time-slot-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        .time-slot-header .time-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
        }
        .time-slot-header .slot-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }
        
        /* Appointment Card */
        .appointment-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .appointment-card:hover {
            background: #f0f1ff;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }
        .appointment-card:last-child {
            margin-bottom: 0;
        }
        .appointment-card .appt-time {
            min-width: 80px;
            text-align: center;
        }
        .appointment-card .appt-time .time {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
        }
        .appointment-card .appt-time .duration {
            font-size: 12px;
            color: #6c757d;
        }
        .appointment-card .appt-info {
            flex: 1;
        }
        .appointment-card .appt-info .patient-name {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .appointment-card .appt-info .details {
            font-size: 13px;
            color: #6c757d;
        }
        .appointment-card .appt-info .details i {
            color: #667eea;
            width: 16px;
        }
        .appointment-card .appt-type {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #e9ecef;
            color: #495057;
        }
        .appointment-card .appt-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-confirme { background-color: #d4edda; color: #155724; }
        .status-planifie { background-color: #cce5ff; color: #004085; }
        .status-annule { background-color: #f8d7da; color: #721c24; }
        .status-complete { background-color: #d4edda; color: #155724; }
        .status-absent { background-color: #e2e3e5; color: #383d41; }
        
        .appointment-card .appt-actions {
            display: flex;
            gap: 10px;
        }
        .appointment-card .appt-actions .btn {
            padding: 8px 12px;
            border-radius: 6px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        .empty-state h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .empty-state p {
            color: #6c757d;
            margin-bottom: 25px;
        }
        .btn-create-rdv {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-create-rdv:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        
        /* Calendar */
        .calendar-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 25px 70px rgba(16, 24, 40, 0.08);
            padding: 20px;
            margin-bottom: 30px;
        }
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }
        .fc .fc-toolbar-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .fc .fc-button {
            border-radius: 10px;
            font-weight: 600;
        }
        .fc .fc-button-primary {
            background: #667eea;
            border: 1px solid #667eea;
        }
        .fc .fc-button-primary:hover {
            background: #5568d4;
            border-color: #5568d4;
        }
        .fc .fc-daygrid-event-harness,
        .fc .fc-timegrid-event {
            border-radius: 12px;
        }
        .fc-event-status {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            opacity: 0.85;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .planning-nav {
                text-align: center;
            }
            .planning-nav .nav-buttons {
                margin-top: 15px;
                justify-content: center;
            }
            .appointment-card {
                flex-direction: column;
                text-align: center;
            }
            .appointment-card .appt-actions {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-tooth"></i> Cabinet Dentaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center">
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <strong><?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'Utilisateur'; ?></strong>
                        <span class="role-badge">Secrétaire</span>
                    </div>
                    <a href="index.php?route=/logout" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-calendar-alt"></i> Planning du Cabinet</h1>
            <p>Visualisation des rendez-vous par date et par dentiste</p>
        </div>
    </div>
    
    <!-- Main Content -->
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

        <!-- Calendar Section -->
        <div class="calendar-card mb-4">
            <div id="calendar"></div>
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
                                        <a href="index.php?route=/secretaire/rendezvous/edit&id=<?php echo $rdv['id']; ?>" class="btn btn-primary btn-sm">
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
                <div class="d-flex justify-content-between">
                    <?php $prevWeek = date('Y-m-d', strtotime($dateFilter . ' -7 day')); ?>
                    <?php $nextWeek = date('Y-m-d', strtotime($dateFilter . ' +7 day')); ?>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo $prevWeek; ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-chevron-left"></i> Semaine précédente
                    </a>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo date('Y-m-d'); ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="btn btn-info">
                        <i class="fas fa-calendar-day"></i> Aujourd'hui
                    </a>
                    <a href="index.php?route=/secretaire/planning&date=<?php echo $nextWeek; ?><?php echo $dentisteFilter ? '&dentiste=' . $dentisteFilter : ''; ?>" class="btn btn-outline-secondary">
                        Semaine suivante <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            if (!calendarEl) {
                return;
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour'
                },
                locale: 'fr',
                slotMinTime: '07:00:00',
                slotMaxTime: '20:00:00',
                allDaySlot: false,
                nowIndicator: true,
                navLinks: true,
                businessHours: true,
                selectable: false,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: {
                    url: 'index.php?route=/secretaire/planning/events',
                    method: 'GET',
                    extraParams: {
                        dentiste: '<?php echo addslashes($dentisteFilter); ?>'
                    },
                    failure: function() {
                        console.error('Impossible de charger les rendez-vous du calendrier.');
                    }
                },
                eventContent: function(arg) {
                    var status = arg.event.extendedProps.status || '';
                    var eventTitle = arg.event.title;
                    return {
                        html: '<div class="fc-event-title">' + eventTitle + '</div>' +
                              '<div class="fc-event-status">' + status + '</div>'
                    };
                },
                eventClick: function(info) {
                    var props = info.event.extendedProps;
                    var details = 'Dentiste: ' + (props.dentiste || 'N/A') + '\n' +
                                  'Type: ' + (props.type || 'N/A') + '\n' +
                                  'Statut: ' + (props.status || 'N/A') + '\n' +
                                  'Motif: ' + (props.motif || 'N/A');
                    alert(info.event.title + '\n\n' + details);
                }
            });

            calendar.render();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>