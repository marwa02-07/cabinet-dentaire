<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Rendez-vous - Cabinet Dentaire</title>
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
        }
        .navbar-custom .nav-link:hover {
            color: white !important;
        }
        .user-info {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
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
        
        /* Bouton Retour */
        .btn-retour { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            border: none; 
            padding: 12px 25px; 
            border-radius: 8px; 
            font-weight: 600;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-retour:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4); 
            color: white;
            text-decoration: none;
        }
        .btn-retour i {
            font-size: 14px;
        }
        
        /* Rendez-vous Card */
        .rdv-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .rdv-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
        }
        
        /* Card Header */
        .rdv-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 25px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .rdv-card-header .dentiste-info h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .rdv-card-header .dentiste-info p {
            margin: 5px 0 0 0;
            font-size: 13px;
            opacity: 0.9;
        }
        .rdv-card-header .dentiste-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        /* Card Body */
        .rdv-card-body {
            padding: 25px;
            flex: 1;
        }
        
        /* Date & Time Section */
        .rdv-datetime {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .rdv-date, .rdv-time {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .rdv-date i, .rdv-time i {
            font-size: 20px;
            color: #667eea;
            margin-bottom: 8px;
            display: block;
        }
        .rdv-date .label, .rdv-time .label {
            font-size: 11px;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .rdv-date .value, .rdv-time .value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 700;
            margin-top: 5px;
        }
        
        /* Details */
        .rdv-detail {
            margin-bottom: 15px;
        }
        .rdv-detail:last-child {
            margin-bottom: 0;
        }
        .rdv-detail .detail-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #667eea;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .rdv-detail .detail-value {
            font-size: 14px;
            color: #2c3e50;
            padding-left: 20px;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-planifie { background-color: #fff3cd; color: #856404; }
        .status-confirme { background-color: #d4edda; color: #155724; }
        .status-complete { background-color: #cce5ff; color: #004085; }
        .status-annule { background-color: #f8d7da; color: #721c24; }
        .status-absent { background-color: #e2e3e5; color: #383d41; }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
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
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .calendar-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(16, 24, 40, 0.08);
            padding: 25px;
            margin-bottom: 30px;
        }

        #patient-calendar {
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
            border-color: #667eea;
        }

        .fc .fc-button-primary:hover {
            background: #5568d4;
            border-color: #5568d4;
        }

        .fc-event-status {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            opacity: 0.9;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .rdv-datetime {
                flex-direction: column;
            }
            .rdv-card-header {
                flex-direction: column-reverse;
                text-align: center;
                gap: 15px;
            }
            .rdv-card-header .dentiste-icon {
                margin: 0 auto;
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
                        <strong><?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></strong>
                        <span class="role-badge">Patient</span>
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
            <h1><i class="fas fa-calendar-alt"></i> Mes Rendez-vous</h1>
            <p>Consultez tous vos rendez-vous passés et à venir</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Bouton Retour -->
        <div class="mb-4">
            <a href="index.php?route=/patient/dashboard" class="btn btn-retour">
                <i class="fas fa-arrow-left"></i> Retour au dashboard
            </a>
        </div>

        <div class="calendar-card">
            <div id="patient-calendar"></div>
        </div>
        
        <?php if (empty($rendezVous)): ?>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h4>Aucun rendez-vous</h4>
                <p>Vous n'avez pas encore de rendez-vous planifié.</p>
                <a href="index.php?route=/patient/rendez-vous/create" class="btn-primary-custom">
                    <i class="fas fa-plus"></i> Prendre un rendez-vous
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($rendezVous as $rdv): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="rdv-card">
                            <!-- Card Header -->
                            <div class="rdv-card-header">
                                <div class="dentiste-info">
                                    <h5><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')); ?></h5>
                                    <p><?php echo htmlspecialchars($rdv['dentiste_specialite'] ?? 'Chirurgie Dentaire'); ?></p>
                                </div>
                                <div class="dentiste-icon">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="rdv-card-body">
                                <!-- Date & Time -->
                                <div class="rdv-datetime">
                                    <div class="rdv-date">
                                        <i class="fas fa-calendar-day"></i>
                                        <div class="label">Date</div>
                                        <div class="value"><?php echo date('d/m/Y', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                    </div>
                                    <div class="rdv-time">
                                        <i class="fas fa-clock"></i>
                                        <div class="label">Heure</div>
                                        <div class="value"><?php echo date('H:i', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                    </div>
                                </div>
                                
                                <!-- Details -->
                                <div class="rdv-detail">
                                    <div class="detail-label">
                                        <i class="fas fa-stethoscope"></i> Type de consultation
                                    </div>
                                    <div class="detail-value">
                                        <?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'] ?? 'Consultation')); ?>
                                    </div>
                                </div>
                                
                                <div class="rdv-detail">
                                    <div class="detail-label">
                                        <i class="fas fa-comment-medical"></i> Motif de la visite
                                    </div>
                                    <div class="detail-value">
                                        <?php echo htmlspecialchars($rdv['motif'] ?? 'Non spécifié'); ?>
                                    </div>
                                </div>
                                
                                <!-- Status -->
                                <div class="mt-3 text-end">
                                    <span class="status-badge status-<?php echo $rdv['statut'] ?? 'planifie'; ?>">
                                        <?php echo ucfirst($rdv['statut'] ?? 'planifié'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('patient-calendar');
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
                selectable: false,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: {
                    url: 'get_events.php',
                    method: 'GET',
                    failure: function() {
                        console.error('Impossible de charger les rendez-vous du calendrier.');
                    }
                },
                eventContent: function(arg) {
                    var status = arg.event.extendedProps.status || '';
                    return {
                        html: '<div class="fc-event-title">' + arg.event.title + '</div>' +
                              '<div class="fc-event-status">' + status + '</div>'
                    };
                },
                eventClick: function(info) {
                    var props = info.event.extendedProps;
                    var details = 'Dentiste : ' + (props.dentiste || 'N/A') + '\n' +
                                  'Type : ' + (props.type || 'N/A') + '\n' +
                                  'Statut : ' + (props.status || 'N/A') + '\n' +
                                  'Motif : ' + (props.motif || 'N/A');
                    alert(info.event.title + '\n\n' + details);
                }
            });

            calendar.render();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>