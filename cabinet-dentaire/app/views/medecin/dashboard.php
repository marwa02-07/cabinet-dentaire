<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Médecin - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/medecin-dashboard.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-hospital"></i> Cabinet Dentaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/rendez-vous">
                            <i class="fas fa-calendar-alt"></i> Mes Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/rendez-vous">
                            <i class="fas fa-stethoscope"></i> Consultations
                        </a>
                    </li>
                </ul>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <strong><?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'Utilisateur'; ?></strong>
                    <span class="role-badge">Médecin</span>
                    <a href="index.php?route=/logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <!-- Header du Dashboard -->
        <section class="dashboard-header">
            <h1>
                <i class="fas fa-stethoscope"></i> Tableau de Bord Médecin
            </h1>
           <div class="welcome-card">
            <h3>Bienvenue, Dr. <?php echo htmlspecialchars($user['nom'] ?? ''); ?>! 👋</h3>
            <p>
                Vous êtes connecté en tant que médecin du système de gestion hospitalière. 
                Vous pouvez consulter vos patients, gérer vos rendez-vous et accéder aux dossiers médicaux.
            </p>
        </div>
        </section>

        <!-- Statistiques -->
        <div class="row mb-4">
    

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon" style="color: #43a047;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value"><?php echo isset($stats['patients']) ? $stats['patients'] : 0; ?></div>
            <div class="stat-label">Patients</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon" style="color: #f9a825;">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-value"><?php echo isset($stats['appointments_total']) ? $stats['appointments_total'] : 0; ?></div>
            <div class="stat-label">Rendez-vous totaux</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); color: white;">
                <i class="fas fa-calendar-alt"></i> Mes Rendez-vous
            </div>
            <div class="card-body">
                <ul class="rendez-vous-list">
                    <?php if (empty($nextRendezVous)): ?>
                        <li class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                            Aucun rendez-vous planifié
                        </li>
                    <?php else: ?>
                        <?php foreach ($nextRendezVous as $rdv): ?>
                            <?php
                                $dateHeure = new DateTime($rdv['date_heure']);
                                $now = new DateTime();
                                $diff = $now->diff($dateHeure);

                                $dateFormatted = '';
                                if ($diff->days == 0) {
                                    $dateFormatted = 'Aujourd\'hui, ' . $dateHeure->format('H:i');
                                } elseif ($diff->days == 1) {
                                    $dateFormatted = 'Demain, ' . $dateHeure->format('H:i');
                                } else {
                                    $dateFormatted = $dateHeure->format('d/m/Y') . ' à ' . $dateHeure->format('H:i');
                                }

                                $badgeClass = 'badge-confirme';
                                if ($rdv['statut'] === 'planifié') {
                                    $badgeClass = 'badge-planifie';
                                }
                            ?>
                            <li class="rendez-vous-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="rendez-vous-patient">
                                            <?php echo htmlspecialchars($rdv['patient_prenom'] . ' ' . $rdv['patient_nom']); ?>
                                        </div>
                                        <div class="rendez-vous-date">
                                            <i class="fas fa-clock"></i> <?php echo $dateFormatted; ?>
                                        </div>
                                    </div>
                                    <span class="badge-status <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars(ucfirst($rdv['statut'])); ?>
                                    </span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <div class="text-center mt-3">
                    <a href="index.php?route=/medecin/rendez-vous" class="btn btn-custom btn-primary-custom">
                        <i class="fas fa-arrow-right"></i> Voir tous les rendez-vous
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
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
                        <i class="fas fa-user-md"></i>
                        <strong><?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></strong>
                        <span class="role-badge">Médecin</span>
                    </div>
                    <a href="index.php?route=/logout" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        

        
        <!-- Actions Grid -->
        <div class="actions-grid">
            
            <!-- Action Card 2 -->
            <div class="action-card">
                <i class="fas fa-calendar-alt"></i>
                <h5>Rendez-vous</h5>
                <p>Gérez vos rendez-vous et votre emploi du temps</p>
                <a href="index.php?route=/medecin/rendez-vous" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            
            <!-- Action Card 3 -->
            <div class="action-card">
                <i class="fas fa-stethoscope"></i>
                <h5>Consultations</h5>
                <p>Enregistrez et suivez les consultations de vos patients</p>
                <a href="index.php?route=/medecin/consultation/select" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            
            <!-- Action Card 4 -->
            <div class="action-card">
                <i class="fas fa-file-prescription"></i>
                <h5>Ordonnances</h5>
                <p>Créez et gérez les ordonnances pour vos patients</p>
                <a href="index.php?route=/medecin/ordonnance/select" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
            <div class="action-card">
                <i class="fas fa-user-cog"></i>
                <h5>Mon Profil</h5>
                <p>Gérer vos informations personnelles</p>
                <a href="index.php?route=/medecin/profile" class="btn btn-primary-custom">
                    <i class="fas fa-arrow-right"></i> Accéder
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
