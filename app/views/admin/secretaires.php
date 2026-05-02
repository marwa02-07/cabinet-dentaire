<?php
// filepath: app/views/admin/secretaires.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Secrétaires - Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root{
            --bg0:#f6f8fb;
            --bg1:#eef3ff;
            --cardSolid:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:rgba(15, 23, 42, 0.08);
            --shadow: 0 18px 50px rgba(15, 23, 42, 0.10);
            --shadowSm: 0 8px 24px rgba(15, 23, 42, 0.10);
        }

        body{
            color: var(--text);
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
            background:
        radial-gradient(1100px 520px at 15% -5%, rgba(99,102,241,0.18), transparent 65%),
        radial-gradient(980px 520px at 85% 0%, rgba(14,165,233,0.20), transparent 60%),
        radial-gradient(800px 500px at 50% 100%, rgba(34,197,94,0.08), transparent 70%),
        linear-gradient(180deg,
            #eef3ff 0%,
            #f6f8fb 35%,
            #f8fafc 70%,
            #ffffff 100%
        );

    background-attachment: fixed;
            padding-top: 76px;
        }

        .navbar-custom{
            background: linear-gradient(135deg, rgba(14,165,233,0.95) 0%, rgba(99,102,241,0.92) 55%, rgba(34,197,94,0.85) 120%);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .navbar-custom .navbar-brand{
            font-weight: 800;
            letter-spacing: .2px;
            font-size: 18px;
            color: white !important;
        }

        .navbar-custom .nav-link{
            color: rgba(255, 255, 255, 0.92) !important;
            font-weight: 600;
            margin-left: 10px;
            border-radius: 999px;
            padding: 8px 12px;
        }

        .navbar-custom .nav-link:hover{
            background: rgba(255,255,255,0.16);
            color: #fff !important;
        }

        .navbar-custom .nav-link.active{
            background: rgba(255,255,255,0.20);
            color: #fff !important;
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

        .page-wrap{
            max-width: 1280px;
            margin: 0 auto;
        }

        .hero{
            border: 1px solid var(--border);
            background: linear-gradient(135deg, rgba(255,255,255,0.75), rgba(255,255,255,0.55));
            border-radius: 18px;
            box-shadow: var(--shadowSm);
            padding: 18px 18px;
            position: relative;
            overflow:hidden;
            margin-bottom: 16px;
        }

        .hero:before{
            content:"";
            position:absolute;
            inset:-2px;
            background:
                radial-gradient(700px 280px at 10% 20%, rgba(14,165,233,0.20), transparent 60%),
                radial-gradient(700px 280px at 85% 30%, rgba(99,102,241,0.18), transparent 55%);
            pointer-events:none;
        }

        .hero > *{ position: relative; }
        .hero-title{ font-weight: 900; letter-spacing: -0.4px; margin: 0; }
        .hero-sub{ color: var(--muted); margin: 0; font-weight: 600; }

        .soft-card{
            border: 1px solid var(--border);
            background: var(--cardSolid);
            border-radius: 16px;
            box-shadow: var(--shadowSm);
        }

        .search{
            border-radius: 999px;
            padding-left: 42px;
            border: 1px solid rgba(15,23,42,0.10);
            background: rgba(255,255,255,0.85);
        }

        .search:focus{
            border-color: rgba(99,102,241,0.45);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.20);
            background: #fff;
        }

        .btn-hero{
            border-radius: 999px;
            padding: 10px 16px;
            font-weight: 800;
        }

        .btn-gradient{
            border: none;
            color: #fff;
            background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 55%, #22c55e 120%);
            box-shadow: 0 10px 22px rgba(15,23,42,0.14);
        }

        .btn-gradient:hover{ filter: brightness(0.98); color:#fff; }

        .table-card{ overflow:hidden; }

        /* Table secrétaires (style modern dashboard identique) */
#tableSecretaires {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

/* Header */
#tableSecretaires thead {
    background: #f8f9fa;
}

#tableSecretaires thead th {
    padding: 15px 20px;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e9ecef;
    vertical-align: middle;
}

/* Icônes header */
#tableSecretaires thead th i {
    margin-right: 8px;
    color: #667eea;
}

/* Body */
#tableSecretaires tbody td {
    padding: 15px 20px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
    font-size: 14px;
    color: #333;
}

/* Hover effect */
#tableSecretaires tbody tr {
    transition: all 0.3s ease;
}

#tableSecretaires tbody tr:hover {
    background: #f8f9ff;
    transform: scale(1.01);
}

/* Align actions */
#tableSecretaires .text-end {
    text-align: right;
}

/* Padding fixes */
#tableSecretaires .ps-4 {
    padding-left: 25px !important;
}

#tableSecretaires .pe-4 {
    padding-right: 25px !important;
}

        .action-btn{
            transition: transform .15s ease, box-shadow .15s ease;
            border-radius: 12px;
        }

        .action-btn:hover{
            transform: translateY(-2px);
            box-shadow: 0 10px 18px rgba(15,23,42,0.10);
        }

        .modal-content{
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow:hidden;
            box-shadow: var(--shadow);
        }

        .modal-header.gradient-head{
            background: linear-gradient(135deg, rgba(14,165,233,0.98) 0%, rgba(99,102,241,0.95) 65%, rgba(34,197,94,0.88) 130%);
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
                        <a class="nav-link active" href="index.php?route=/admin/secretaires">
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
        <div class="page-wrap px-2 px-md-3">
            <!-- Hero / Header -->
            <div class="hero">
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                    <div>
                        <h1 class="hero-title h4 mb-1">
                            <i class="fas fa-user-secret me-2"></i>Gestion des Secrétaires
                        </h1>
                        <p class="hero-sub">Rechercher, ajouter, modifier ou supprimer une secrétaire.</p>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="position-relative" style="min-width: min(420px, 90vw);">
                            <i class="fas fa-magnifying-glass position-absolute text-muted" style="left: 16px; top: 50%; transform: translateY(-50%); z-index: 10;"></i>
                            <input type="text" class="form-control search" id="searchSecretaire"
                                placeholder="Rechercher par nom ou email...">
                        </div>
                        <a href="index.php?route=/register-secretaire" class="btn btn-hero btn-gradient">
                            <i class="fas fa-plus me-2"></i>Nouvelle secrétaire
                        </a>
                    </div>
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
                <div class="soft-card table-card mt-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="tableSecretaires">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4"><i class="fas fa-hashtag me-1"></i>ID</th>
                                        <th><i class="fas fa-user me-1"></i>Nom</th>
                                        <th><i class="fas fa-user me-1"></i>Prénom</th>
                                        <th><i class="fas fa-envelope me-1"></i>Email</th>
                                        <th><i class="fas fa-phone me-1"></i>Téléphone</th>
                                        <th class="text-end pe-4"><i class="fas fa-cogs me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($secretaires)): ?>
                                        <?php foreach ($secretaires as $secretaire): ?>
                                            <tr class="secretaire-row">
                                                <td class="ps-4"><?php echo htmlspecialchars($secretaire['id']); ?></td>
                                                <td><strong><?php echo htmlspecialchars($secretaire['nom']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($secretaire['prenom']); ?></td>
                                                <td><?php echo htmlspecialchars($secretaire['email']); ?></td>
                                                <td><?php echo htmlspecialchars($secretaire['telephone']); ?></td>
                                                <td class="text-end pe-4">
                                                    <a href="index.php?route=/admin/secretaire/edit/<?php echo $secretaire['id']; ?>" 
                                                       class="btn btn-sm btn-outline-primary action-btn" 
                                                       title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="index.php?route=/admin/secretaire/delete" 
                                                          style="display: inline;" 
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette secrétaire ?');">
                                                        <input type="hidden" name="id" value="<?php echo $secretaire['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Supprimer">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="fas fa-user-secret fa-2x mb-2 d-block"></i>
                                                Aucune secrétaire enregistrée
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

 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Recherche en temps réel
        document.getElementById('searchSecretaire').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.secretaire-row');
            
            rows.forEach(row => {
                const nom = row.cells[1].textContent.toLowerCase();
                const prenom = row.cells[2].textContent.toLowerCase();
                const email = row.cells[3].textContent.toLowerCase();
                
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