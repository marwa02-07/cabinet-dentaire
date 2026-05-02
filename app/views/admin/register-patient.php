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
        :root{
    --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }

        .navbar-custom{
            background: linear-gradient(135deg, rgba(14,165,233,0.95) 0%, rgba(99,102,241,0.92) 55%, rgba(34,197,94,0.85) 120%);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .navbar-custom .navbar-brand{
            color: white !important;
            font-weight: 800;
            letter-spacing: .2px;
            font-size: 18px;
        }
        .navbar-custom .nav-link{
            color: rgba(255, 255, 255, 0.92) !important;
            font-weight: 600;
            margin-left: 10px;
            border-radius: 999px;
            padding: 8px 12px;
        }
        .navbar-custom .nav-link:hover{ background: rgba(255,255,255,0.16); color:#fff !important; }
        .navbar-custom .nav-link.active{ background: rgba(255,255,255,0.20); color:#fff !important; }
        .user-info{
            color: rgba(255, 255, 255, 0.92);
            font-size: 13px;
            margin-right: 12px;
            display:flex;
            align-items:center;
            gap:10px;
            white-space: nowrap;
        }
        .role-badge{
            background-color: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        body{
            background:
                radial-gradient(1100px 520px at 15% -5%, rgba(99,102,241,0.14), transparent 62%),
                radial-gradient(980px 520px at 85% 0%, rgba(14,165,233,0.16), transparent 58%),
                linear-gradient(180deg, var(--bg1) 0%, var(--bg0) 52%, #ffffff 100%);
            min-height: 100vh;
            padding: 20px;
            padding-top: 96px;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
        }

        .auth-wrap{
            min-height: calc(100vh - 96px);
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .register-card{
    max-width: 520px; /* ↓ plus petit */
    width: 100%;
    border: none;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}
.card-header-custom{
    background: var(--primary-gradient);
    border-radius: 14px 14px 0 0 !important;
    padding: 18px 20px; /* ↓ réduit */
    text-align: center;
}
        .card-header-custom h4{ color:white; font-weight:600; margin:0; }
        .card-header-custom p{ color: rgba(255,255,255,0.85); font-size:14px; margin:5px 0 0 0; }
        .card-body-custom{
    padding: 20px; /* ↓ réduit */

}
.input-group-text {
            background: #f8f9fa;
            border-radius: 8px 0 0 8px;
            border: 1px solid #ced4da;
            border-right: none;
            color:rgb(116, 38, 181);
        }
        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        .form-label{ font-weight:600; font-size:13px; color:#495057; margin-bottom:5px; }
        .form-control{
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus{
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }
        .form-control::placeholder{ color:#adb5bd; }

        .btn-submit{
    background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s;
}

.btn-submit:hover{
    background: linear-gradient(135deg, #4f46e5 0%, #9333ea 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
    color: white;
}
        .btn-cancel{
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        .login-link a {
            color: #1976d2;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .alert{ border-radius: 8px; font-size: 14px; }

        @media (max-width: 768px){
            .card-body-custom{ padding: 22px; }
        }
        .user-info{
            color: rgba(255, 255, 255, 0.92);
            font-size: 13px;
            margin-right: 12px;
            display:flex;
            align-items:center;
            gap:10px;
            white-space: nowrap;
        }

        .role-badge{
            background-color: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
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

    <div class="auth-wrap">
        <div class="card register-card">
            <div class="card-header card-header-custom">
                <h4><i class="fas fa-user-plus me-2"></i>Ajouter un Patient</h4>
                <p>Créer un nouveau dossier patient dans le système</p>
            </div>
            <div class="card-body card-body-custom">
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

                <form method="POST" action="index.php?route=/admin/patients/create">
                    <div class="row g-3">
                    <!-- Nom -->
                    <div class="col-md-6">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="nom" class="form-control" required placeholder="Nom du patient">
                        </div>
                    </div>
                    
                    <!-- Prénom -->
                    <div class="col-md-6">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="prenom" class="form-control" required placeholder="Prénom du patient">
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" required placeholder="email@exemple.com">
                        </div>
                    </div>
                    
                    <!-- Téléphone -->
                    <div class="col-md-6">
                        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" name="telephone" class="form-control" required placeholder="+212 6 00 00 00 00">
                        </div>
                    </div>
                    
                    <div class="row g-3">

<!-- Date de naissance -->
<div class="col-md-6">
    <label class="form-label">Date de naissance</label>

    <div class="input-group">
        <span class="input-group-text">
            <i class="fas fa-calendar"></i>
        </span>
        <input type="date" name="date_naissance" class="form-control">
    </div>
</div>

<!-- Allergies -->
<div class="col-md-6">
    <label class="form-label">Allergies</label>

    <div class="input-group">
        <span class="input-group-text">
            <i class="fas fa-notes-medical"></i>
        </span>
        <input type="text" name="allergies" class="form-control" placeholder="Ex: pénicilline">
    </div>
</div>

</div>
                    
                    
                    <!-- Adresse -->
                    <div class="col-12">
                        <label class="form-label">Adresse</label>
                        <div class="input-group">
        <span class="input-group-text">
            <i class="fas fa-map-marker-alt"></i>
        </span>
                        <textarea name="adresse" class="form-control" rows="3" placeholder="Adresse complète du patient"></textarea>
                        </div>
                    </div>
                    
                   
                    
                    <!-- Mot de passe -->
                    <div class="col-12">
                        <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Mot de passe (minimum 6 caractères)">
                        </div>
                    </div>
                </div>
                
                <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-submit text-white w-100">
                                <i class="fas fa-plus me-2"></i>S'inscrire
                            </button>

                    </div>
                </form>
                <div class="login-link">
                    Déjà un compte ? <a href="index.php?route=/login">Se connecter</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>