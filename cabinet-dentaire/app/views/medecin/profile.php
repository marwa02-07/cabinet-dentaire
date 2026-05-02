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
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php?route=/medecin/dashboard"><i class="fas fa-tooth"></i> Cabinet Dentaire</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?route=/medecin/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.php?route=/medecin/rendez-vous">Rendez-vous</a></li>
                </ul>
                <span class="navbar-text text-white me-3"><i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                <a href="index.php?route=/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container py-5 mt-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3">Mon Profil</h1>
                <p class="text-muted mb-0">Consultez et modifiez vos informations personnelles et professionnelles.</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" id="editBtn" onclick="toggleEditMode()">
                    <i class="fas fa-edit"></i> Modifier mon profil
                </button>
                <a href="index.php?route=/medecin/dashboard" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Retour au dashboard
                </a>
            </div>
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
                <div class="card shadow-sm" id="profileView">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Mes informations</h5>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <strong>Nom :</strong> <?php echo htmlspecialchars($user['nom'] ?? ''); ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom'] ?? ''); ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Email :</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Téléphone :</strong> <?php echo htmlspecialchars($medecin['telephone'] ?? 'Non spécifié'); ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Spécialité :</strong> <?php echo htmlspecialchars($medecin['specialite'] ?? 'Non spécifiée'); ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Numéro de licence :</strong> <?php echo htmlspecialchars($medecin['numero_licence'] ?? 'Non spécifié'); ?>
                            </div>
                            <div class="col-12">
                                <strong>Cabinet :</strong><br>
                                <?php echo nl2br(htmlspecialchars($medecin['cabinet'] ?? 'Non spécifié')); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire d'édition (caché par défaut) -->
                <div class="card shadow-sm" id="profileEdit" style="display: none;">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user-edit"></i> Modifier mes informations</h5>
                        <button type="button" class="btn btn-light btn-sm" onclick="toggleEditMode()">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </div>
                    <div class="card-body">
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
                                <button type="submit" class="btn btn-primary">
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
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informations du compte</h5>
                    </div>
                    <div class="card-body">
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

                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-shield-alt"></i> Sécurité</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">Pour changer votre mot de passe, contactez l'administrateur système.</p>
                        <button class="btn btn-outline-success btn-sm" disabled>
                            <i class="fas fa-key"></i> Changer le mot de passe
                        </button>
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