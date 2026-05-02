<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Patient - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 60px;
        }
        
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border-left: 4px solid #17a2b8;
        }
        
        .profile-card h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 20px;
        }
        
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .profile-item {
            display: flex;
            flex-direction: column;
        }
        
        .profile-item.full-width {
            grid-column: 1 / -1;
        }
        
        .profile-item label {
            color: #667eea;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .profile-item span {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .action-card {
            background: white;
            padding: 30px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .action-card:hover {
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }
        
        .action-card i {
            font-size: 36px;
            color: #667eea;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
        }
        
        .action-card h5 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 18px;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-card p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 20px;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: auto;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
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
        }
        
        /* Rendez-vous Cards */
        .rdv-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }
        
        .rdv-card:hover {
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
        }
        
        .rdv-card .rdv-date {
            font-size: 14px;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .rdv-card .rdv-doctor {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .rdv-card .rdv-type {
            font-size: 13px;
            color: #6c757d;
        }
        
        .statut-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .statut-planifie { background-color: #fff3cd; color: #856404; }
        .statut-confirme { background-color: #d4edda; color: #155724; }
        .statut-complete { background-color: #cce5ff; color: #004085; }
        .statut-annule { background-color: #f8d7da; color: #721c24; }
        .statut-absent { background-color: #e2e3e5; color: #383d41; }
        
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
        
        .no-rdv {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }
        
        .no-rdv i {
            font-size: 48px;
            color: #dee2e6;
            margin-bottom: 15px;
        }
        
        .view-all-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hospital"></i> Gestion Hôpital
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
            <h1>Dashboard Patient</h1>
            <p>Accueil de votre espace patient</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h3>Bienvenue, <?php echo htmlspecialchars($user['prenom'] ?? ''); ?>! 👋</h3>
            <p>
                Vous êtes connecté en tant que patient du système de gestion hospitalière. 
                Vous pouvez accéder à vos rendez-vous, consulter vos résultats et gérer votre dossier patient.
            </p>
        </div>
        
        <!-- Prochains Rendez-vous Section -->
        <div class="profile-card">
            <h4><i class="fas fa-calendar-alt"></i> Mes Prochains Rendez-vous</h4>
            <?php if (empty($nextRendezVous)): ?>
                <div class="no-rdv">
                    <i class="fas fa-calendar-times"></i>
                    <p>Aucun rendez-vous à venir</p>
                    <a href="index.php?route=/patient/rendez-vous/create" class="btn btn-primary-custom">
                        <i class="fas fa-plus"></i> Prendre un rendez-vous
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($nextRendezVous as $rdv): ?>
                    <?php
                    $dateHeure = new DateTime($rdv['date_heure']);
                    $now = new DateTime();
                    $diff = $now->diff($dateHeure);
                    
                    // Formater la date de manière lisible
                    $dateFormatted = '';
                    if ($diff->days == 0) {
                        $dateFormatted = 'Aujourd\'hui à ' . $dateHeure->format('H:i');
                    } elseif ($diff->days == 1) {
                        $dateFormatted = 'Demain à ' . $dateHeure->format('H:i');
                    } else {
                        $dateFormatted = $dateHeure->format('d/m/Y') . ' à ' . $dateHeure->format('H:i');
                    }
                    
                    // Classe CSS pour le statut
                    $statutClass = 'statut-' . $rdv['statut'];
                    ?>
                    <div class="rdv-card">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="rdv-date"><i class="fas fa-clock"></i> <?php echo $dateFormatted; ?></div>
                                <div class="rdv-doctor"><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars($rdv['dentiste_prenom'] . ' ' . $rdv['dentiste_nom']); ?></div>
                                <div class="rdv-type">
                                    <i class="fas fa-stethoscope"></i> 
                                    <?php echo htmlspecialchars(ucfirst($rdv['type_rendez_vous'])); ?>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="statut-badge <?php echo $statutClass; ?>">
                                    <?php echo htmlspecialchars(ucfirst($rdv['statut'])); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="view-all-link">
                    <a href="index.php?route=/patient/rendez-vous" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> Voir tous mes rendez-vous
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Actions Grid -->
        <div class="actions-grid">
            <!-- Action Card 1: Prendre Rendez-vous -->
            <div class="action-card">
                <i class="fas fa-calendar-plus"></i>
                <h5>Prendre Rendez-vous</h5>
                <p>Planifiez une consultation avec votre dentiste</p>
                <a href="index.php?route=/patient/rendez-vous/create" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            
            <!-- Action Card 2: Mes Rendez-vous -->
            <div class="action-card">
                <i class="fas fa-calendar-check"></i>
                <h5>Mes Rendez-vous</h5>
                <p>Voir tous vos rendez-vous passés et à venir</p>
                <a href="index.php?route=/patient/rendez-vous" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            
            <!-- Action Card 3: Mes Consultations -->
            <div class="action-card">
                <i class="fas fa-file-medical-alt"></i>
                <h5>Mes Consultations</h5>
                <p>Consultez vos diagnostics et traitements</p>
                <a href="index.php?route=/patient/consultations" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            
            <!-- Action Card 4: Mon Profil -->
            <div class="action-card">
                <i class="fas fa-user-cog"></i>
                <h5>Mon Profil</h5>
                <p>Gérer vos informations personnelles</p>
                <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="fas fa-arrow-right"></i> Accéder
                </button>
            </div>
        </div>
    </div>
    
    <!-- Profile Modal -->
    <div class="modal fade profile-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">
                        <i class="fas fa-user-circle"></i> Mon Profil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-user"></i> Nom complet</label>
                                <span><?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-envelope"></i> Email</label>
                                <span><?php echo htmlspecialchars($user['email'] ?? ''); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-birthday-cake"></i> Âge</label>
                                <span><?php echo htmlspecialchars($patient['age'] ?? 'Non spécifié'); ?> ans</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <label><i class="fas fa-phone"></i> Téléphone</label>
                                <span><?php echo htmlspecialchars($patient['telephone'] ?? 'Non spécifié'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="profile-detail">
                                <label><i class="fas fa-map-marker-alt"></i> Adresse</label>
                                <span><?php echo htmlspecialchars($patient['adresse'] ?? 'Non spécifiée'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Fermer
                    </button>
                    <a href="index.php?route=/patient/profile" class="btn btn-primary-custom">
                        <i class="fas fa-edit"></i> Modifier le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
