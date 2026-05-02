<?php
// filepath: app/views/admin/secretaire_edit.php
$secretaire = $secretaire ?? [
    'id' => '',
    'user_id' => '',
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'departement' => ''
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Secrétaire - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        .navbar-custom {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand { font-weight: 700; font-size: 20px; color: white !important; }
        .navbar-custom .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; margin-left: 15px; }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active { color: white !important; }
        .user-info { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin-right: 20px; }
        .user-info strong { color: white; font-weight: 600; }
        .role-badge { background-color: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .edit-card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?route=/admin/dashboard">
                <i class="fas fa-hospital-alt me-2"></i>Gestion Hôpital - Admin
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
                </ul>
                <div class="d-flex align-items-center">
                    <div class="user-info">
                        <i class="fas fa-user me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']); ?>
                        <span class="role-badge ms-2">ADMIN</span>
                    </div>
                    <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card edit-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier Secrétaire</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?route=/admin/secretaire/update" onsubmit="showLoading()">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($secretaire['id']); ?>">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($secretaire['user_id'] ?? ''); ?>">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="nom" 
                                           value="<?php echo htmlspecialchars($secretaire['nom']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" 
                                           value="<?php echo htmlspecialchars($secretaire['prenom']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="<?php echo htmlspecialchars($secretaire['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" name="telephone" 
                                           value="<?php echo htmlspecialchars($secretaire['telephone']); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Département</label>
                                    <input type="text" class="form-control" name="departement" 
                                           value="<?php echo htmlspecialchars($secretaire['departement'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <i class="fas fa-save me-1"></i>Enregistrer
                                </button>
                                <a href="index.php?route=/admin/secretaires" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Retour
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoading() {
            const btn = document.getElementById('submitBtn');
            const spinner = btn.querySelector('.spinner-border');
            const icon = btn.querySelector('i');
            
            // Désactiver le bouton et montrer le spinner
            btn.disabled = true;
            spinner.classList.remove('d-none');
            icon.style.display = 'none';
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement en cours...';
        }

        // Redirection automatique après succès
        <?php if (isset($_SESSION['success'])): ?>
            setTimeout(function() {
                window.location.href = 'index.php?route=/admin/secretaires';
            }, 2000); // Redirection après 2 secondes
        <?php endif; ?>
    </script>
</body>
</html>