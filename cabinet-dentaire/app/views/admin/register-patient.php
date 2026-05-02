<?php
// filepath: app/views/admin/register-patient.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Patient - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 60px;
        }
        
        /* Navbar */
        .navbar-custom {
            background: var(--primary-gradient);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        .user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .role-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        /* Page Header */
        .page-header {
            background: var(--primary-gradient);
            padding: 40px 0;
            margin-bottom: 30px;
        }
        .page-header h1 {
            color: white;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .page-header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }
        
        /* Form Card */
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
            max-width: 700px;
            margin: 0 auto 40px;
        }
        .form-card h2 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        
        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        .form-control::placeholder {
            color: #adb5bd;
        }
        
        /* Required Star */
        .text-danger {
            font-weight: 600;
        }
        
        /* Buttons */
        .btn-submit {
            background: var(--primary-gradient);
            border: none;
            border-radius: 30px;
            padding: 14px 35px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-cancel {
            border-radius: 30px;
            padding: 14px 35px;
            font-weight: 600;
        }
        
        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .form-card {
                padding: 25px;
                margin: 0 15px 40px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php?route=/admin/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/medecins">
                            <i class="fas fa-user-md me-1"></i>Médecins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/secretaires">
                            <i class="fas fa-user-secret me-1"></i>Secrétaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/admin/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="user-info">
                        <i class="fas fa-user-circle fa-lg"></i>
                        <span><?php echo htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']); ?></span>
                        <span class="role-badge">ADMIN</span>
                    </div>
                    <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-user-plus"></i> Ajouter un Patient</h1>
            <p>Créer un nouveau dossier patient dans le système</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="form-card">
            <h2><i class="fas fa-user-injured me-2"></i>Informations du Patient</h2>
            
            <form method="POST" action="index.php?route=/admin/patients/create">
                <div class="row g-3">
                    <!-- Nom -->
                    <div class="col-md-6">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control" required placeholder="Nom du patient">
                    </div>
                    
                    <!-- Prénom -->
                    <div class="col-md-6">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" name="prenom" class="form-control" required placeholder="Prénom du patient">
                    </div>
                    
                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required placeholder="email@exemple.com">
                    </div>
                    
                    <!-- Téléphone -->
                    <div class="col-md-6">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="tel" name="telephone" class="form-control" required placeholder="+212 6 00 00 00 00">
                    </div>
                    
                    <!-- Date de naissance -->
                    <div class="col-md-6">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" name="date_naissance" class="form-control">
                    </div>
                    
                    <!-- Âge -->
                    <div class="col-md-6">
                        <label class="form-label">Âge</label>
                        <input type="number" name="age" class="form-control" min="1" max="150" placeholder="Âge">
                    </div>
                    
                    <!-- Adresse -->
                    <div class="col-12">
                        <label class="form-label">Adresse</label>
                        <textarea name="adresse" class="form-control" rows="3" placeholder="Adresse complète du patient"></textarea>
                    </div>
                    
                    <!-- Allergies -->
                    <div class="col-12">
                        <label class="form-label">Allergies</label>
                        <input type="text" name="allergies" class="form-control" placeholder="Allergies connues (ex: pénicilline)">
                    </div>
                    
                    <!-- Mot de passe -->
                    <div class="col-12">
                        <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Mot de passe (minimum 6 caractères)">
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="index.php?route=/admin/dashboard" class="btn btn-secondary btn-cancel">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                    <button type="submit" class="btn btn-primary btn-submit">
                        <i class="fas fa-plus me-2"></i>Ajouter le Patient
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>