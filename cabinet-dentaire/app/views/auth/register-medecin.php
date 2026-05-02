<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Médecin - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            max-width: 600px;
            width: 100%;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
        .card-header-custom {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            border-radius: 15px 15px 0 0 !important;
            padding: 25px 30px;
            text-align: center;
        }
        .card-header-custom h4 {
            color: white;
            font-weight: 600;
            margin: 0;
        }
        .card-header-custom p {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .card-body-custom {
            padding: 30px;
        }
        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: #495057;
            margin-bottom: 5px;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.15);
        }
        .input-group-text {
            background: #f8f9fa;
            border-radius: 8px 0 0 8px;
            border: 1px solid #ced4da;
            border-right: none;
            color: #1976d2;
        }
        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }
        .btn-submit {
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #1565c0 0%, #0d47a1 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(25, 118, 210, 0.4);
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
        .alert {
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card register-card">
        <div class="card-header card-header-custom">
            <h4><i class="fas fa-user-md me-2"></i>Inscription Médecin</h4>
            <p>Créez votre compte pour accéder au système</p>
        </div>
        <div class="card-body card-body-custom">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?route=/register-medecin">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="nom" placeholder="Nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" name="prenom" placeholder="Prénom" value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="email@exemple.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="tel" class="form-control" name="telephone" placeholder="+212 6 XX XX XX XX" value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Spécialité <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                            <select class="form-select" name="specialite" required>
                                <option value="">Sélectionner...</option>
                                <option value="Médecin Généraliste" <?php echo (isset($_POST['specialite']) && $_POST['specialite'] === 'Médecin Généraliste') ? 'selected' : ''; ?>>Médecin Généraliste</option>
                                <option value="Orthodontiste" <?php echo (isset($_POST['specialite']) && $_POST['specialite'] === 'Orthodontiste') ? 'selected' : ''; ?>>Orthodontiste</option>
                                <option value="Chirurgien dentiste" <?php echo (isset($_POST['specialite']) && $_POST['specialite'] === 'Chirurgien dentiste') ? 'selected' : ''; ?>>Chirurgien Dentiste</option>
                                <option value="Parodontiste" <?php echo (isset($_POST['specialite']) && $_POST['specialite'] === 'Parodontiste') ? 'selected' : ''; ?>>Parodontiste</option>
                                <option value="Endodontiste" <?php echo (isset($_POST['specialite']) && $_POST['specialite'] === 'Endodontiste') ? 'selected' : ''; ?>>Endodontiste</option>
                                <option value="Implantologue" <?php echo (isset($_POST['specialite']) && $_POST['specialite'] === 'Implantologue') ? 'selected' : ''; ?>>Implantologue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Numéro Licence <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                            <input type="text" class="form-control" name="numero_licence" placeholder="N° licence" value="<?php echo isset($_POST['numero_licence']) ? htmlspecialchars($_POST['numero_licence']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Min. 6 caractères" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirmer <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirmer" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Cabinet/Adresse</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" class="form-control" name="cabinet" placeholder="Adresse du cabinet" value="<?php echo isset($_POST['cabinet']) ? htmlspecialchars($_POST['cabinet']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-submit text-white w-100">
                            <i class="fas fa-user-plus me-2"></i>S'inscrire
                        </button>
                    </div>
                </div>
            </form>
            <div class="login-link">
                Déjà un compte ? <a href="index.php?route=/login">Se connecter</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
