<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        .navbar-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-custom .navbar-brand { font-weight: 700; font-size: 20px; color: white !important; }
        .page-header { background: white; padding: 30px 0; margin-bottom: 30px; border-bottom: 1px solid #e9ecef; }
        .page-header h1 { color: #2c3e50; font-weight: 700; margin: 0; font-size: 32px; }
        .card-custom { background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px; }
        .info-label { color: #667eea; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { color: #2c3e50; font-size: 16px; font-weight: 500; }
        .btn-retour { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; }
        .btn-modifier { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; }
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
            <h1>Mon Profil</h1>
            <p>Gérez vos informations personnelles</p>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <a href="index.php?route=/patient/dashboard" class="btn btn-retour mb-4"><i class="fas fa-arrow-left"></i> Retour au dashboard</a>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Informations du compte -->
                <div class="card-custom mb-4">
                    <h4 class="mb-4"><i class="fas fa-user-circle text-primary"></i> Informations du compte</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Nom</p>
                            <p class="info-value"><?php echo htmlspecialchars($user['nom'] ?? ''); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Prénom</p>
                            <p class="info-value"><?php echo htmlspecialchars($user['prenom'] ?? ''); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Email</p>
                            <p class="info-value"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Rôle</p>
                            <p class="info-value"><span class="badge bg-primary">Patient</span></p>
                        </div>
                    </div>
                </div>
                
                <!-- Informations médicales -->
                <div class="card-custom">
                    <h4 class="mb-4"><i class="fas fa-file-medical text-primary"></i> Informations médicales</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Âge</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['age'] ?? 'Non spécifié'); ?> ans</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Téléphone</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['telephone'] ?? 'Non spécifié'); ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Date de naissance</p>
                            <p class="info-value"><?php echo !empty($patient['date_naissance']) ? date('d/m/Y', strtotime($patient['date_naissance'])) : 'Non spécifiée'; ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="info-label">Groupe sanguin</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['groupe_sanguin'] ?? 'Non spécifié'); ?></p>
                        </div>
                        <div class="col-12 mb-3">
                            <p class="info-label">Adresse</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['adresse'] ?? 'Non spécifiée'); ?></p>
                        </div>
                        <div class="col-12 mb-3">
                            <p class="info-label">Allergies</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['allergies'] ?? 'Aucune'); ?></p>
                        </div>
                        <?php if (!empty($patient['observations'])): ?>
                        <div class="col-12">
                            <p class="info-label">Observations médicales</p>
                            <p class="info-value"><?php echo htmlspecialchars($patient['observations']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>