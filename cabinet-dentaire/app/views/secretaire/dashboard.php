<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Secrétaire - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        .navbar-custom .nav-link:hover {
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
        
        /* Welcome Card */
        .welcome-card {
            background: white;
            border-left: 4px solid #667eea;
            margin-bottom: 30px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .welcome-card h3 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 22px;
        }
        .welcome-card p {
            color: #6c757d;
            margin: 0;
            font-size: 16px;
            line-height: 1.6;
        }
        
        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }
        .stat-card .stat-icon {
            font-size: 36px;
            margin-bottom: 15px;
        }
        .stat-card .stat-value {
            font-size: 42px;
            font-weight: 700;
            color: #2c3e50;
            line-height: 1;
        }
        .stat-card .stat-label {
            font-size: 14px;
            color: #6c757d;
            margin-top: 10px;
            font-weight: 500;
        }
        
        /* Main Rendez-vous Card */
        .main-rdv-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .main-rdv-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .main-rdv-header h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }
        .main-rdv-header .rdv-count {
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .main-rdv-body {
            padding: 30px;
        }
        .rdv-item {
            display: flex;
            align-items: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .rdv-item:last-child {
            margin-bottom: 0;
        }
        .rdv-item:hover {
            background: #f0f1ff;
            transform: translateX(5px);
        }
        .rdv-item .rdv-time {
            min-width: 100px;
            text-align: center;
            padding: 10px 15px;
            background: white;
            border-radius: 8px;
            margin-right: 20px;
        }
        .rdv-item .rdv-time .time {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
        }
        .rdv-item .rdv-time .date {
            font-size: 12px;
            color: #6c757d;
        }
        .rdv-item .rdv-info {
            flex: 1;
        }
        .rdv-item .rdv-info h5 {
            margin: 0 0 5px 0;
            color: #2c3e50;
            font-weight: 600;
        }
        .rdv-item .rdv-info p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
        }
        .rdv-item .rdv-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-planifie { background-color: #fff3cd; color: #856404; }
        .status-confirme { background-color: #d4edda; color: #155724; }
        .status-complete { background-color: #cce5ff; color: #004085; }
        
        /* Tasks Card */
        .tasks-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .tasks-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 25px;
            color: white;
            border-radius: 12px 12px 0 0;
        }
        .tasks-card-header h4 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .tasks-card-body {
            padding: 20px 25px;
        }
        .task-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        .task-item:last-child {
            border-bottom: none;
        }
        .task-item .task-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .task-item .task-icon {
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
        }
        .task-item .task-text {
            color: #2c3e50;
            font-weight: 500;
        }
        .task-item .task-time {
            color: #6c757d;
            font-size: 13px;
        }
        .task-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-urgent { background-color: #f8d7da; color: #721c24; }
        .badge-normal { background-color: #d4edda; color: #155724; }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .action-btn {
            background: white;
            border-radius: 12px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }
        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
            text-decoration: none;
        }
        .action-btn i {
            font-size: 32px;
            color: #667eea;
            margin-bottom: 15px;
            display: block;
        }
        .action-btn h5 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 16px;
        }
        .action-btn p {
            color: #6c757d;
            font-size: 13px;
            margin: 0;
        }
        
        /* Profile Button */
        .profile-btn {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .profile-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
        }
        .profile-btn .profile-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .profile-btn .profile-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }
        .profile-btn .profile-text h5 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }
        .profile-btn .profile-text p {
            margin: 5px 0 0 0;
            color: #6c757d;
            font-size: 13px;
        }
        .profile-btn .profile-arrow {
            color: #667eea;
            font-size: 18px;
        }
        
        /* Profile Modal */
        .profile-modal .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .profile-modal .modal-header .btn-close {
            filter: invert(1);
        }
        .profile-detail {
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .profile-detail:last-child {
            border-bottom: none;
        }
        .profile-detail label {
            color: #667eea;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }
        .profile-detail span {
            color: #2c3e50;
            font-size: 15px;
        }
        
        /* Navigation Cards Grid */
        .nav-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .nav-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
        }
        .nav-card-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            flex-shrink: 0;
        }
        .nav-card-icon i {
            font-size: 28px;
            color: white;
        }
        .nav-card h5 {
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        .nav-card p {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: auto;
            line-height: 1.5;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-nav-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 15px;
        }
        .btn-nav-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
            .nav-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
            .nav-cards-grid {
                grid-template-columns: 1fr;
            }
            .nav-card {
                padding: 25px;
            }
            .nav-card-icon {
                width: 60px;
                height: 60px;
            }
            .nav-card-icon i {
                font-size: 24px;
            }
        }
                grid-template-columns: 1fr;
            }
            .rdv-item {
                flex-direction: column;
                text-align: center;
            }
            .rdv-item .rdv-time {
                margin-right: 0;
                margin-bottom: 15px;
            }
            .rdv-item .rdv-status {
                margin-top: 10px;
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
            <h1><i class="fas fa-headset"></i> Dashboard Secrétaire</h1>
            <p>Bienvenue <?php echo htmlspecialchars($user['prenom'] ?? ''); ?> - Gestion du secrétariat</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h3>Bienvenue, <?php echo htmlspecialchars($user['prenom'] ?? ''); ?>! 👋</h3>
            <p>
                Vous êtes connecté en tant que secrétaire du cabinet dentaire. 
                Gérez les rendez-vous, les patients et le planning quotidien depuis cet espace.
            </p>
        </div>
        
        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #667eea;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value"><?php echo isset($stats['patients']) ? $stats['patients'] : 0; ?></div>
                    <div class="stat-label">Patients enregistrés</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #e74c3c;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-value"><?php echo isset($stats['appointments_today']) ? $stats['appointments_today'] : 0; ?></div>
                    <div class="stat-label">Rendez-vous aujourd'hui</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon" style="color: #27ae60;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value"><?php echo isset($stats['appointments_confirmed']) ? $stats['appointments_confirmed'] : 0; ?></div>
                    <div class="stat-label">Rendez-vous confirmés</div>
                </div>
            </div>
        </div>
        
        <!-- Section Principale: Gérer les Rendez-vous -->
        <div class="main-rdv-card">
            <div class="main-rdv-header">
                <h3><i class="fas fa-calendar-check"></i> Prochains Rendez-vous</h3>
                <span class="rdv-count">
                    <i class="fas fa-list"></i> <?php echo isset($todayAppointments) ? count($todayAppointments) : 0; ?> RDV
                </span>
            </div>
            <div class="main-rdv-body">
                <?php if (empty($todayAppointments)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucun rendez-vous prévu aujourd'hui</p>
                        <a href="index.php?route=/secretaire/rendezvous/create" class="btn btn-primary-custom">
                            <i class="fas fa-plus"></i> Créer un rendez-vous
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($todayAppointments as $rdv): ?>
                        <div class="rdv-item">
                            <div class="rdv-time">
                                <div class="time"><?php echo date('H:i', strtotime($rdv['date_heure'] ?? '')); ?></div>
                                <div class="date"><?php echo date('d/m/Y', strtotime($rdv['date_heure'] ?? '')); ?></div>
                            </div>
                            <div class="rdv-info">
                                <h5><i class="fas fa-user"></i> <?php echo htmlspecialchars(($rdv['patient_prenom'] ?? '') . ' ' . ($rdv['patient_nom'] ?? '')); ?></h5>
                                <p><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')); ?> - <?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'] ?? 'Consultation')); ?></p>
                            </div>
                            <span class="rdv-status status-<?php echo $rdv['statut'] ?? 'planifie'; ?>">
                                <?php echo ucfirst($rdv['statut'] ?? 'planifié'); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                    <div class="text-center mt-3">
                        <a href="index.php?route=/secretaire/rendezvous" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> Voir tous les rendez-vous
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="index.php?route=/secretaire/patients/create" class="action-btn">
                <i class="fas fa-user-plus"></i>
                <h5>Nouveau Patient</h5>
                <p>Enregistrer un nouveau patient</p>
            </a>
            <a href="index.php?route=/secretaire/rendezvous/create" class="action-btn">
                <i class="fas fa-calendar-plus"></i>
                <h5>Nouveau Rendez-vous</h5>
                <p>Planifier un rendez-vous</p>
            </a>
            <a href="index.php?route=/secretaire/patients" class="action-btn">
                <i class="fas fa-users"></i>
                <h5>Voir Patients</h5>
                <p>Consulter la liste des patients</p>
            </a>
        </div>
        
        <!-- Bottom Navigation Cards -->
        <div class="nav-cards-grid">
            <div class="nav-card">
                <div class="nav-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h5>Gérer Rendez-vous</h5>
                <p>Planifier et suivre les rendez-vous</p>
                <a href="index.php?route=/secretaire/rendezvous" class="btn btn-nav-card">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            
            <div class="nav-card">
                <div class="nav-card-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="fas fa-users"></i>
                </div>
                <h5>Gérer Patients</h5>
                <p>Consulter et gérer les patients</p>
                <a href="index.php?route=/secretaire/patients" class="btn btn-nav-card">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            
            <div class="nav-card">
                <div class="nav-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="fas fa-user-cog"></i>
                </div>
                <h5>Profil</h5>
                <p>Voir mes informations personnelles</p>
                <button type="button" class="btn btn-nav-card" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="fas fa-arrow-right"></i> Accéder
                </button>
            </div>
            
            <div class="nav-card">
                <div class="nav-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h5>Planning</h5>
                <p>Voir le planning des rendez-vous</p>
                <a href="index.php?route=/secretaire/planning" class="btn btn-nav-card">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
        </div>
    </div>
    
    <!-- Profile Modal -->
    <div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">
                        <i class="fas fa-user-circle"></i> Mon Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="profile-detail">
                        <label><i class="fas fa-user"></i> Nom complet</label>
                        <span><?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                    </div>
                    <div class="profile-detail">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <span><?php echo htmlspecialchars($user['email'] ?? 'Non disponible'); ?></span>
                    </div>
                    <div class="profile-detail">
                        <label><i class="fas fa-building"></i> Département</label>
                        <span>Réception</span>
                    </div>
                    <div class="profile-detail">
                        <label><i class="fas fa-clock"></i> Horaires</label>
                        <span>08:00 - 17:00</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
