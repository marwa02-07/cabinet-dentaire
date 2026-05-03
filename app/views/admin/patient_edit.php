<?php
// filepath: app/views/admin/patient_edit.php
$patient = $patient ?? [
    'id' => '',
    'user_id' => '',
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'date_naissance' => '',
    'adresse' => '',
    'allergies' => ''
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Patient - Administration</title>
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
            max-width: 1180px;
            margin: 0 auto;
        }

        .hero{
            border: 1px solid var(--border);
            background: linear-gradient(135deg, rgba(255,255,255,0.75), rgba(255,255,255,0.55));
            border-radius: 18px;
            box-shadow: var(--shadowSm);
            padding: 18px;
            position: relative;
            overflow:hidden;
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
        .hero-sub{ color: var(--muted); margin: 0; }

        .chip{
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.65);
            border-radius: 999px;
            padding: 8px 12px;
            font-weight: 700;
            color: var(--text);
        }

        .soft-card{
            border: 1px solid var(--border);
            background: var(--cardSolid);
            border-radius: 16px;
            box-shadow: var(--shadowSm);
        }

        .section-title{
            font-weight: 900;
            letter-spacing: -0.2px;
            margin: 0;
        }

        .form-label{
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .form-control{
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, 0.14);
            padding: 10px 14px;
        }

        .form-control:focus{
            border-color: rgba(99,102,241,0.55);
            box-shadow: 0 0 0 .2rem rgba(99,102,241,0.15);
        }

        .btn-primary-custom{
            background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%);
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 700;
            color: #fff;
        }

        .btn-primary-custom:hover{
            color: #fff;
            transform: translateY(-1px);
            box-shadow: var(--shadowSm);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php?route=/admin/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/admin/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/admin/medecins">
                            <i class="fas fa-user-md me-1"></i>Médecins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/admin/secretaires">
                            <i class="fas fa-user-secret me-1"></i>Secrétaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/admin/patients">
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
                    <a href="<?php echo BASE_URL; ?>index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="page-wrap px-2 px-md-3">
            <div class="hero mb-4">
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="chip">
                                <i class="fas fa-users me-2"></i>Gestion des patients
                            </span>
                            <span class="chip">
                                <i class="fas fa-pen-to-square me-2"></i>Edition
                            </span>
                        </div>
                        <h1 class="hero-title h3 mb-1">Modifier Patient</h1>
                        <p class="hero-sub">Mettez a jour les informations du dossier patient.</p>
                    </div>
                </div>
            </div>

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

        <!-- Edit Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="soft-card p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="section-title h5 mb-0">
                            <i class="fas fa-id-card me-2"></i>Informations du patient
                        </h2>
                    </div>
                    <div>
                        <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/admin/patients/update">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($patient['id']); ?>">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($patient['nom']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($patient['prenom']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" name="telephone" class="form-control" value="<?php echo htmlspecialchars($patient['telephone']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date de naissance</label>
                                    <input type="date" name="date_naissance" class="form-control" value="<?php echo htmlspecialchars($patient['date_naissance']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Allergies</label>
                                    <input type="text" name="allergies" class="form-control" value="<?php echo htmlspecialchars($patient['allergies']); ?>" placeholder="Allergies connues">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Adresse</label>
                                    <textarea name="adresse" class="form-control" rows="3" placeholder="Adresse complète"><?php echo htmlspecialchars($patient['adresse']); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="<?php echo BASE_URL; ?>index.php?route=/admin/patients" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary-custom text-white">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>