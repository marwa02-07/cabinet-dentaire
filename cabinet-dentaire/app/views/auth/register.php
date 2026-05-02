<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-wrapper {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            min-height: 700px;
        }

        .register-content {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .register-form-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .register-badge {
            display: inline-block;
            background: #e8f4f8;
            color: #20c997;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .register-form-header h1 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .register-form-header p {
            color: #6c757d;
            font-size: 15px;
            line-height: 1.6;
        }

        .register-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
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
            color: #20c997;
            font-size: 18px;
        }

        .form-control {
            padding: 12px 15px 12px 45px !important;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            outline: none;
            border-color: #20c997;
            box-shadow: 0 0 0 4px rgba(32, 201, 151, 0.1);
            background-color: #f9fffe;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .btn-register-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 20px rgba(32, 201, 151, 0.3);
        }

        .btn-register-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(32, 201, 151, 0.4);
            background: linear-gradient(135deg, #19b385 0%, #16919d 100%);
        }

        .btn-register-submit:active {
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

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .login-link a {
            color: #20c997;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE */
        @media (max-width: 480px) {
            .register-wrapper {
                border-radius: 15px;
            }

            .register-content {
                padding: 30px 20px;
            }

            .register-form-header h1 {
                font-size: 26px;
            }

            body {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-content">
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
            <div class="register-form-header">
                <span class="register-badge">
                    <i class="fas fa-user-plus"></i> Inscription patient
                </span>
                <h1>S'inscrire</h1>
                <p>Créez votre compte patient pour accéder aux services</p>
            </div>

            <!-- Formulaire d'inscription -->
            <form method="POST" action="index.php?route=/register" class="register-form">
                <!-- Champ Nom -->
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="nom" name="nom"
                               placeholder="Votre nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
                    </div>
                </div>

                <!-- Champ Prénom -->
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="prenom" name="prenom"
                               placeholder="Votre prénom" value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
                    </div>
                </div>

                <!-- Champ Email -->
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="votre.email@exemple.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                </div>

                <!-- Champ Mot de passe -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-key"></i>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Choisissez un mot de passe (min. 6 caractères)" required>
                    </div>
                </div>

                <!-- Champ Confirmer mot de passe -->
                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-key"></i>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                               placeholder="Confirmez votre mot de passe" required>
                    </div>
                </div>

                <!-- Champ Âge -->
                <div class="form-group">
                    <label for="age">Âge</label>
                    <div class="input-wrapper">
                        <i class="fas fa-birthday-cake"></i>
                        <input type="number" class="form-control" id="age" name="age"
                               placeholder="Votre âge" min="1" max="120" value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?>" required>
                    </div>
                </div>

                <!-- Champ Téléphone -->
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="tel" class="form-control" id="telephone" name="telephone"
                               placeholder="+212 6 XX XX XX XX" value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>" required>
                    </div>
                </div>

                <!-- Champ Adresse -->
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <div class="input-wrapper">
                        <i class="fas fa-map-marker-alt"></i>
                        <textarea class="form-control" id="adresse" name="adresse"
                                  placeholder="Votre adresse complète" rows="3" required><?php echo isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : ''; ?></textarea>
                    </div>
                </div>

                <!-- Bouton d'inscription -->
                <button type="submit" class="btn-register-submit">
                    <i class="fas fa-user-plus"></i> S'inscrire
                </button>
            </form>

            <!-- Lien vers connexion -->
            <div class="login-link">
                Déjà un compte ? <a href="index.php?route=/login">Se connecter</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
