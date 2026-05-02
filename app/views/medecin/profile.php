<?php 
// Vérifications défensives pour les variables
$user = $user ?? [];
$medecin = $medecin ?? [];
?>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --bg:#f1f6ff;
            --surface:#ffffff;
            --surface-alt:#f8fbff;
            --text:#0b1736;
            --muted:#5d6b89;
            --line:#dbe7ff;
            --primary:#2563eb;
            --primary-dark:#1e40af;
            --cyan:#06b6d4;
            --shadow:0 16px 36px rgba(37,99,235,0.15);
            --shadow-sm:0 8px 18px rgba(37,99,235,0.12);
        }

        body{
            margin: 0;
            color: var(--text);
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
            background:
                radial-gradient(1200px 500px at -10% -5%, rgba(37,99,235,.20), transparent 60%),
                radial-gradient(1000px 420px at 100% 0%, rgba(6,182,212,.16), transparent 55%),
                var(--bg);
                background-attachment: fixed;
            padding-top: 84px;
        }

        .topbar{
            background: linear-gradient(90deg, #0f3fb5 0%, #2563eb 50%, #0ea5e9 100%);
            box-shadow: 0 8px 24px rgba(15,63,181,.28);
        }

        .topbar .navbar-brand{
            color: #fff !important;
            font-weight: 800;
            letter-spacing: .2px;
        }

        .topbar .nav-link{
            color: rgba(255,255,255,.92) !important;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 12px !important;
            margin-left: 6px;
        }

        .topbar .nav-link:hover{
            background: rgba(255,255,255,.15);
            color: #fff !important;
        }

        .doctor-pill{
            display:flex;
            align-items:center;
            gap:8px;
            color:#fff;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.28);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 13px;
            font-weight: 700;
            margin-right: 8px;
        }

        .dashboard{
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 14px 22px;
        }

        .welcome-banner{
            background:
                linear-gradient(130deg, rgba(37,99,235,.95), rgba(6,182,212,.90)),
                #2563eb;
            color:#fff;
            border-radius: 22px;
            padding: 22px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            margin-bottom: 18px;
        }

        .welcome-banner::after{
            content:"";
            position:absolute;
            right:-80px;
            top:-80px;
            width:220px;
            height:220px;
            border-radius:50%;
            background: rgba(255,255,255,.15);
        }

        .welcome-title{ margin:0; font-size: clamp(1.2rem,2.2vw,1.7rem); font-weight: 900; }
        .welcome-sub{ margin:.45rem 0 0; opacity:.94; max-width: 780px; }

        .panel{
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .panel-head{
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, #fff, var(--surface-alt));
        }

        .panel-title{ margin:0; font-weight:900; color:#10224f; }
        .form-label{ font-weight:700; color:#334155; }
        .form-control{ border-radius:10px; border:1px solid #cdddfc; padding:10px 12px; }
        .form-control:focus{ border-color: var(--primary); box-shadow: 0 0 0 .2rem rgba(37,99,235,.15); }
        .btn-primary-custom{ background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border:none; color:#fff; border-radius:10px; }
        .btn-primary-custom:hover{ color:#fff; }
        .profile-line{ margin-bottom: 10px; color:#334155; }
        .profile-line:last-child{ margin-bottom:0; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?route=/medecin/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Médecin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/medecin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/rendez-vous">
                            <i class="fas fa-calendar-alt me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/consultation/select">
                            <i class="fas fa-stethoscope me-1"></i>Consultations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/medecin/profile">
                            <i class="fas fa-user-cog me-1"></i>Mon Profil
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="doctor-pill">
                        <i class="fas fa-user-md"></i>
                        <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?>
                    </div>
                    <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard">
        <div class="welcome-banner">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="welcome-title">Mon Profil</h1>
                    <p class="welcome-sub">Consultez et modifiez vos informations personnelles et professionnelles.</p>
                </div>
                <a href="index.php?route=/medecin/dashboard" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Retour dashboard
                </a>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end mb-3">
            <button type="button" class="btn btn-primary-custom" id="editBtn" onclick="toggleEditMode()">
                    <i class="fas fa-edit"></i> Modifier mon profil
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="row gy-4">
            <div class="col-lg-8">
                <!-- Vue en lecture seule -->
                <div class="panel" id="profileView">
                    <div class="panel-head">
                        <h5 class="panel-title"><i class="fas fa-user me-2 text-primary"></i>Mes informations</h5>
                    </div>
                    <div class="p-3 p-md-4">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <p class="profile-line"><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom'] ?? ''); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="profile-line"><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom'] ?? ''); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="profile-line"><strong>Email :</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="profile-line"><strong>Téléphone :</strong> <?php echo htmlspecialchars($medecin['telephone'] ?? 'Non spécifié'); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="profile-line"><strong>Spécialité :</strong> <?php echo htmlspecialchars($medecin['specialite'] ?? 'Non spécifiée'); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="profile-line"><strong>Numéro de licence :</strong> <?php echo htmlspecialchars($medecin['numero_licence'] ?? 'Non spécifié'); ?></p>
                            </div>
                            <div class="col-12">
                                <strong>Cabinet :</strong><br>
                                <?php echo nl2br(htmlspecialchars($medecin['cabinet'] ?? 'Non spécifié')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire d'édition (caché par défaut) -->
                <div class="panel" id="profileEdit" style="display: none;">
                    <div class="panel-head d-flex justify-content-between align-items-center">
                        <h5 class="panel-title"><i class="fas fa-user-edit me-2 text-primary"></i>Modifier mes informations</h5>
                        <button type="button" class="btn btn-light btn-sm" onclick="toggleEditMode()">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </div>
                    <div class="p-3 p-md-4">
                        <form action="index.php?route=/medecin/profile/update" method="POST" id="profileForm">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($medecin['telephone'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="specialite" class="form-label">Spécialité</label>
                                    <input type="text" class="form-control" id="specialite" name="specialite" value="<?php echo htmlspecialchars($medecin['specialite'] ?? ''); ?>" placeholder="Ex: Chirurgie Dentaire">
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_licence" class="form-label">Numéro de licence</label>
                                    <input type="text" class="form-control" id="numero_licence" name="numero_licence" value="<?php echo htmlspecialchars($medecin['numero_licence'] ?? ''); ?>" placeholder="Ex: CD-001">
                                </div>
                                <div class="col-12">
                                    <label for="cabinet" class="form-label">Cabinet</label>
                                    <textarea class="form-control" id="cabinet" name="cabinet" rows="3" placeholder="Adresse et informations du cabinet"><?php echo htmlspecialchars($medecin['cabinet'] ?? ''); ?></textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-save"></i> Enregistrer les modifications
                                </button>
                                <button type="button" class="btn btn-secondary ms-2" onclick="toggleEditMode()">
                                    <i class="fas fa-times"></i> Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel">
                    <div class="panel-head">
                        <h5 class="panel-title"><i class="fas fa-info-circle me-2 text-primary"></i>Informations du compte</h5>
                    </div>
                    <div class="p-3 p-md-4">
                        <div class="mb-3">
                            <strong>Rôle :</strong> Médecin/Dentiste
                        </div>
                        <div class="mb-3">
                            <strong>Date d'inscription :</strong>
                            <?php echo htmlspecialchars(date('d/m/Y', strtotime($user['created_at'] ?? 'now'))); ?>
                        </div>
                        <div class="mb-3">
                            <strong>ID utilisateur :</strong> #<?php echo htmlspecialchars($user['id'] ?? ''); ?>
                        </div>
                        <hr>
                        <div class="alert alert-warning">
                            <small>
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Important :</strong> Les modifications de votre email nécessiteront une reconnexion.
                            </small>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleEditMode() {
            const profileView = document.getElementById('profileView');
            const profileEdit = document.getElementById('profileEdit');
            const editBtn = document.getElementById('editBtn');

            if (profileView.style.display === 'none') {
                // Passer en mode lecture
                profileView.style.display = 'block';
                profileEdit.style.display = 'none';
                editBtn.innerHTML = '<i class="fas fa-edit"></i> Modifier mon profil';
                editBtn.className = 'btn btn-primary';
            } else {
                // Passer en mode édition
                profileView.style.display = 'none';
                profileEdit.style.display = 'block';
                editBtn.innerHTML = '<i class="fas fa-eye"></i> Voir mon profil';
                editBtn.className = 'btn btn-secondary';
            }
        }
    </script>
</body>
</html>