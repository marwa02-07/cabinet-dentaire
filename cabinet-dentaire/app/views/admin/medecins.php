<?php
// filepath: app/views/admin/medecins.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Médecins - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        .navbar-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand { font-weight: 700; font-size: 20px; color: white !important; }
        .navbar-custom .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; margin-left: 15px; }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active { color: white !important; }
        .user-info { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin-right: 20px; }
        .user-info strong { color: white; font-weight: 600; }
        .role-badge { background-color: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .table-card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .specialite-badge { font-size: 11px; padding: 4px 8px; }
        .action-btn { transition: all 0.3s; }
        .action-btn:hover { transform: scale(1.1); }
        .search-box {
            max-width: 350px;
            border-radius: 25px;
            padding-left: 40px;
        }
        .search-box:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            border-color: #dc3545;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
        }
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71d2a 100%);
        }
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
                        <a class="nav-link active" href="index.php?route=/admin/medecins">
                            <i class="fas fa-user-md me-1"></i>Médecins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/secretaires">
                            <i class="fas fa-user-secret me-1"></i>Secrétaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/admin/patients">
                            <i class="fas fa-users me-1"></i>Patients
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

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11">
                <!-- En-tête avec recherche -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                    <h1 class="h4 mb-0">
                        <i class="fas fa-user-md me-2 text-primary"></i>Gestion des Médecins
                    </h1>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Barre de recherche -->
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute text-muted" style="left: 15px; top: 50%; transform: translateY(-50%); z-index: 10;"></i>
                            <input type="text" class="form-control search-box" id="searchMedecin" 
                                placeholder="Rechercher par nom ou email...">
                        </div>
                        <button class="btn btn-primary-custom text-white" data-bs-toggle="modal" data-bs-target="#createMedecinModal">
                            <i class="fas fa-plus me-1"></i>Nouveau
                        </button>
                    </div>
                </div>

                <!-- Messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Tableau -->
                <div class="card table-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="tableMedecins">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4"><i class="fas fa-hashtag me-1"></i>ID</th>
                                        <th><i class="fas fa-user me-1"></i>Nom</th>
                                        <th><i class="fas fa-user me-1"></i>Prénom</th>
                                        <th><i class="fas fa-stethoscope me-1"></i>Spécialité</th>
                                        <th><i class="fas fa-envelope me-1"></i>Email</th>
                                        <th><i class="fas fa-phone me-1"></i>Téléphone</th>
                                        <th class="text-end pe-4"><i class="fas fa-cogs me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($medecins)): ?>
                                        <?php foreach ($medecins as $medecin): ?>
                                            <tr class="medecin-row">
                                                <td class="ps-4"><?php echo htmlspecialchars($medecin['id']); ?></td>
                                                <td><strong><?php echo htmlspecialchars($medecin['nom']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($medecin['prenom']); ?></td>
                                                <td>
                                                    <span class="badge bg-info specialite-badge">
                                                        <?php echo htmlspecialchars($medecin['specialite']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo htmlspecialchars($medecin['email']); ?></td>
                                                <td><?php echo htmlspecialchars($medecin['telephone']); ?></td>
                                                <td class="text-end pe-4">
                                                    <a href="index.php?route=/admin/medecin/edit/<?php echo $medecin['id']; ?>" 
                                                       class="btn btn-sm btn-outline-primary action-btn" 
                                                       title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="index.php?route=/admin/medecin/delete" 
                                                          style="display: inline;" 
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce médecin ?');">
                                                        <input type="hidden" name="id" value="<?php echo $medecin['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                <i class="fas fa-user-md fa-2x mb-2 d-block"></i>
                                                Aucun médecin enregistré
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Création Médecin - Design compact -->
    <div class="modal fade" id="createMedecinModal" tabindex="-1" aria-labelledby="createMedecinModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fs-6" id="createMedecinModalLabel">
                        <i class="fas fa-user-md me-2"></i>Nouveau Médecin
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="index.php?route=/admin/medecin/store" method="POST">
                    <div class="modal-body py-3">
                        <div class="row g-2">
                            <!-- Nom -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="nom" required placeholder="Nom">
                            </div>
                            <!-- Prénom -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="prenom" required placeholder="Prénom">
                            </div>
                            <!-- Email -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm" name="email" required placeholder="email@exemple.com">
                            </div>
                            <!-- Téléphone -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-sm" name="telephone" required placeholder="06 12 34 56 78">
                            </div>
                            <!-- Numéro de licence -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Numéro de licence <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="numero_licence" required placeholder="N° licence">
                            </div>
                            <!-- Cabinet -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Cabinet</label>
                                <input type="text" class="form-control form-control-sm" name="cabinet" placeholder="Adresse du cabinet">
                            </div>
                            <!-- Spécialité -->
                            <div class="col-12">
                                <label class="form-label small fw-bold">Spécialité <span class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" name="specialite" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="Médecin Généraliste">Médecin Généraliste</option>
                                    <option value="Orthodontiste">Orthodontiste</option>
                                    <option value="Chirurgien dentiste">Chirurgien Dentiste</option>
                                    <option value="Parodontiste">Parodontiste</option>
                                    <option value="Endodontiste">Endodontiste</option>
                                    <option value="Implantologue">Implantologue</option>
                                    <option value="Pédodontiste">Pédodontiste (enfants)</option>
                                </select>
                            </div>
                            <!-- Mot de passe -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" name="password" required placeholder="Mot de passe">
                            </div>
                            <!-- Confirmation -->
                            <div class="col-6">
                                <label class="form-label small fw-bold">Confirmer <span class="text-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" name="password_confirm" required placeholder="Confirmer">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-save me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fermer automatiquement le modal après une soumission réussie
        <?php if (isset($_SESSION['success'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                // Fermer le modal de création
                const createModal = document.getElementById('createMedecinModal');
                if (createModal) {
                    const modal = bootstrap.Modal.getInstance(createModal);
                    if (modal) {
                        modal.hide();
                    }
                }
            });
        <?php endif; ?>

        // Recherche en temps réel
        document.getElementById('searchMedecin').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.medecin-row');
            
            rows.forEach(row => {
                const nom = row.cells[1].textContent.toLowerCase();
                const prenom = row.cells[2].textContent.toLowerCase();
                const email = row.cells[4].textContent.toLowerCase();
                
                if (nom.includes(searchTerm) || prenom.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>