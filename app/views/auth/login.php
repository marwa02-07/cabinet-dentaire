<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Cabinet Dentaire</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background:
                radial-gradient(1200px 500px at -10% -5%, rgba(37,99,235,.20), transparent 60%),
                radial-gradient(1000px 420px at 100% 0%, rgba(6,182,212,.16), transparent 55%),
                var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 22px;
            box-shadow: var(--shadow);
            overflow: hidden;
            min-height: 600px;
        }

        .login-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100%;
        }

        /* SECTION GAUCHE - VISUELLE */
        .login-visual {
            background: linear-gradient(130deg, rgba(37,99,235,.95), rgba(6,182,212,.90)), var(--primary);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-visual::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-visual::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .login-visual-content {
            position: relative;
            z-index: 1;
        }

        .login-visual-icon {
            font-size: 80px;
            margin-bottom: 30px;
            opacity: 0.95;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .login-visual h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .login-visual p {
            font-size: 16px;
            opacity: 0.95;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .visual-features {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 40px;
            font-size: 14px;
            opacity: 0.9;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
        }

        .feature-item i {
            font-size: 20px;
        }

        /* SECTION DROITE - FORMULAIRE */
        .login-form-section {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-header {
            margin-bottom: 40px;
        }

        .security-badge {
            display: inline-block;
            background: var(--surface-alt);
            color: var(--primary);
            border: 1px solid var(--line);
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-form-header h1 {
            font-size: 32px;
            color: var(--text);
            margin-bottom: 10px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .login-form-header p {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
        }

        .login-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--text);
            font-weight: 700;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            color: var(--primary);
            font-size: 18px;
        }

        .form-control {
            padding: 14px 15px 14px 45px !important;
            border: 2px solid var(--line);
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
            background-color: var(--surface-alt);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
            background-color: #fff;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .btn-login-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .btn-login-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.35);
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
        }

        .btn-login-submit:active {
            transform: translateY(0);
        }

        .alert {
            border: none;
            border-radius: 10px;
            margin-bottom: 25px;
            padding: 15px 20px;
            font-size: 14px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background-color: #ffe5e5;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .login-wrapper {
                min-height: auto;
            }

            .login-content {
                grid-template-columns: 1fr;
            }

            .login-visual {
                padding: 40px 30px;
                min-height: 300px;
            }

            .login-visual h2 {
                font-size: 24px;
            }

            .login-visual p {
                font-size: 14px;
            }

            .login-form-section {
                padding: 40px 30px;
            }

            .login-form-header h1 {
                font-size: 26px;
            }

            .visual-features {
                margin-top: 25px;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .login-wrapper {
                border-radius: 15px;
            }

            .login-visual {
                padding: 35px 20px;
            }

            .login-visual-icon {
                font-size: 60px;
            }

            .login-form-section {
                padding: 30px 20px;
            }

            .login-form-header h1 {
                font-size: 22px;
            }

            .login-form-header p {
                font-size: 13px;
            }

            body {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-content">
            <!-- SECTION GAUCHE - VISUELLE -->
            <div class="login-visual">
                <div class="login-visual-content">
                    <div class="login-visual-icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h2>Gestion Hôpital</h2>
                    <p>Bienvenue dans votre espace hospitalier</p>
                    <p style="font-size: 14px; opacity: 0.85;">Connectez-vous pour accéder à votre espace sécurisé et gérer vos services médicaux.</p>
                    
                    <div class="visual-features">
                        <div class="feature-item">
                            <i class="fas fa-lock"></i>
                            <span>Sécurité maximale</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-bolt"></i>
                            <span>Accès rapide et fiable</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <span>Gestion moderne et efficace</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION DROITE - FORMULAIRE -->
            <div class="login-form-section">
                <!-- Messages d'erreur -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <!-- Messages de succès -->
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <!-- Header du formulaire -->
                <div class="login-form-header">
                    <span class="security-badge">
                        <i class="fas fa-lock"></i> Connexion sécurisée
                    </span>
                    <h1>Se connecter</h1>
                    <p>Veuillez entrer vos identifiants pour continuer</p>
                    <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: center;">
                        <a href="index.php" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 600; padding: 8px 16px; transition: all 0.2s;">
                            <i class="fas fa-arrow-left"></i> Retour à l'accueil
                        </a>
                        <a href="<?php echo BASE_URL; ?>index.php?route=/register" class="btn btn-primary" style="background: var(--cyan); border: none; border-radius: 8px; font-weight: 600; padding: 8px 16px; transition: all 0.2s;">
                            <i class="fas fa-user-plus"></i> S'inscrire
                        </a>
                    </div>
                </div>

                <!-- Formulaire de connexion -->
                <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/login" class="login-form">
                    <!-- Champ Identifiant -->
                    <div class="form-group">
                        <label for="email">Email ou nom d'utilisateur</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" class="form-control" id="email" name="email" 
                                   placeholder="email ou nom d'utilisateur" required autocomplete="username">
                        </div>
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key"></i>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Entrez votre mot de passe" required autocomplete="current-password">
                        </div>
                    </div>

                    <!-- Bouton de connexion -->
                    <button type="submit" class="btn-login-submit">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
