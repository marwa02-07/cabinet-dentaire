<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte Médecin — Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb; --primary-dark: #1e40af;
            --cyan: #06b6d4;   --bg: #f1f6ff;
            --surface: #ffffff; --text: #0b1736;
            --muted: #5d6b89;  --line: #dbe7ff;
            --ok: #16a34a;     --err: #dc2626;
            --radius-xl: 22px; --radius-lg: 14px;
            --radius-md: 10px; --radius-pill: 999px;
            --shadow-lg: 0 24px 60px rgba(37,99,235,.22);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 16px;
            background:
                radial-gradient(1200px 500px at -10% -5%, rgba(37,99,235,.22), transparent 62%),
                radial-gradient(1000px 420px at 105% 0%, rgba(6,182,212,.18), transparent 58%),
                var(--bg);
            background-attachment: fixed;
        }

        /* Particles */
        .particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .particle  { position: absolute; border-radius: 50%; opacity: .07; animation: float linear infinite; }
        .particle:nth-child(1) { width:300px; height:300px; background:var(--primary);     top:-70px;  left:-50px;  animation-duration:18s; }
        .particle:nth-child(2) { width:180px; height:180px; background:var(--cyan);        top:58%;    right:-30px; animation-duration:22s; animation-delay:-7s; }
        .particle:nth-child(3) { width:120px; height:120px; background:var(--primary-dark);bottom:6%;  left:14%;    animation-duration:14s; animation-delay:-3s; }
        @keyframes float {
            0%,100% { transform: translateY(0)    scale(1); }
            50%      { transform: translateY(-28px) scale(1.04); }
        }

        /* Wrapper */
        .page-wrapper {
            position: relative; z-index: 1;
            width: 100%; max-width: 960px;
            display: grid; grid-template-columns: 300px 1fr;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        /* Panel gauche */
        .panel-left {
            background: linear-gradient(145deg, #0f3fb5 0%, #2563eb 50%, #0ea5e9 100%);
            padding: 32px 28px;
            display: flex; flex-direction: column; justify-content: space-between;
            color: #fff; position: relative; overflow: hidden;
        }
        .panel-left::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(600px 380px at -10% 110%, rgba(6,182,212,.35), transparent 60%);
            pointer-events: none;
        }
        .panel-left > * { position: relative; z-index: 1; }

        .brand-mark { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 48px; height: 48px; flex-shrink: 0;
            background: rgba(255,255,255,.18); border: 1.5px solid rgba(255,255,255,.3);
            border-radius: var(--radius-lg);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; backdrop-filter: blur(8px);
        }
        .brand-text { font-weight: 800; font-size: 16px; line-height: 1.2; }
        .brand-text small { font-weight: 500; font-size: 11.5px; opacity: .75; display: block; }

        .illus-center { text-align: center; }
        .illus-icon {
            font-size: 58px; display: block; margin-bottom: 8px;
            filter: drop-shadow(0 8px 24px rgba(0,0,0,.25));
            animation: pulse-icon 3.2s ease-in-out infinite;
        }
        @keyframes pulse-icon {
            0%,100% { transform: scale(1) translateY(0); }
            50%      { transform: scale(1.05) translateY(-6px); }
        }
        .illus-title { font-size: 20px; font-weight: 900; letter-spacing: -.3px; margin-bottom: 6px; }
        .illus-sub   { font-size: 12.5px; opacity: .82; line-height: 1.55; max-width: 240px; margin: 0 auto; }

        .chips { display: flex; flex-direction: column; gap: 6px; }
        .chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.13); border: 1px solid rgba(255,255,255,.22);
            border-radius: var(--radius-pill); padding: 6px 12px;
            font-size: 11.5px; font-weight: 600; backdrop-filter: blur(6px);
        }
        .chip i { font-size: 12px; color: #7dd3fc; width: 14px; text-align: center; }

        /* Panel droit */
        .panel-right {
            background: var(--surface);
            padding: 28px 36px;
            display: flex; flex-direction: column; justify-content: center;
            overflow-y: auto;
        }

        /* Navbar admin en haut du panel droit */
        .admin-topbar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }
        .admin-topbar .back-link {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 13px; font-weight: 600; color: var(--muted);
            text-decoration: none; transition: color .2s;
        }
        .admin-topbar .back-link:hover { color: var(--primary); }
        .admin-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, rgba(37,99,235,.10), rgba(6,182,212,.10));
            color: var(--primary); border: 1px solid rgba(37,99,235,.2);
            border-radius: var(--radius-pill); padding: 4px 12px;
            font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
        }

        /* Form header */
        .form-hd { margin-bottom: 14px; }
        .form-hd h1 { font-size: 20px; font-weight: 900; color: var(--text); letter-spacing: -.3px; margin-bottom: 2px; }
        .form-hd p  { font-size: 12.5px; color: var(--muted); font-weight: 500; }

        /* Alerts */
        .al {
            display: flex; align-items: flex-start; gap: 9px;
            padding: 11px 15px; border-radius: var(--radius-md);
            font-size: 13.5px; font-weight: 500; margin-bottom: 20px;
            animation: slideDown .3s ease;
        }
        @keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .al-err { background:rgba(220,38,38,.08);  color:var(--err); border:1px solid rgba(220,38,38,.2); }
        .al-ok  { background:rgba(22,163,74,.08);  color:var(--ok);  border:1px solid rgba(22,163,74,.2); }
        .al i   { margin-top: 1px; flex-shrink: 0; }

        /* Section title */
        .section-label {
            font-size: 10.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .8px; color: var(--muted);
            margin: 14px 0 8px; display: flex; align-items: center; gap: 8px;
        }
        .section-label::after { content:''; flex:1; height:1px; background:var(--line); }

        /* Grid 2 cols */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .col-full { grid-column: 1 / -1; }

        /* Field */
        .field { display: flex; flex-direction: column; gap: 3px; }
        .field label { font-size: 11.5px; font-weight: 700; color: var(--text); }
        .field label .req { color: var(--err); margin-left: 2px; }

        .field-wrap { position: relative; }
        .field-wrap .fi {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: var(--muted); font-size: 14px; pointer-events: none; transition: color .2s;
        }
        .field-wrap:focus-within .fi { color: var(--primary); }
        .fc {
            width: 100%; padding: 8px 13px 8px 36px;
            border: 1.5px solid var(--line); border-radius: var(--radius-md);
            font-size: 13px; font-family: inherit; color: var(--text);
            background: var(--surface); outline: none;
            transition: border-color .2s, box-shadow .2s;
            appearance: none;
        }
        .fc::placeholder { color: #b0bbd4; }
        .fc:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,.10);
            background: #fafcff;
        }
        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--muted);
            cursor: pointer; font-size: 14px; padding: 0; transition: color .2s;
        }
        .toggle-pw:hover { color: var(--primary); }
        .fc.has-toggle { padding-right: 38px; }

        /* Submit */
        .btn-submit {
            width: 100%; padding: 11px;
            background: linear-gradient(90deg, #0f3fb5 0%, var(--primary) 50%, var(--cyan) 100%);
            color: #fff; border: none; border-radius: var(--radius-md);
            font-size: 13.5px; font-weight: 700; font-family: inherit;
            cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 14px;
            box-shadow: 0 6px 20px rgba(37,99,235,.32);
            transition: transform .18s, box-shadow .18s, filter .18s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,.40); filter: brightness(1.04); }
        .btn-submit:active { transform: translateY(0); }

        /* Responsive */
        @media (max-width: 900px) {
            .page-wrapper { grid-template-columns: 1fr; }
            .panel-left { display: none; }
            .panel-right { padding: 24px 20px; }
        }
        @media (max-width: 540px) {
            .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="particles" aria-hidden="true">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
</div>

<div class="page-wrapper">

    <!-- ===== PANEL GAUCHE ===== -->
    <aside class="panel-left" aria-hidden="true">
        <div class="brand-mark">
            <div class="brand-icon"><i class="fas fa-tooth"></i></div>
            <div class="brand-text">Cabinet Dentaire<small>Administration</small></div>
        </div>

        <div class="illus-center">
            <i class="fas fa-user-md illus-icon"></i>
            <h2 class="illus-title">Nouveau Médecin</h2>
            <p class="illus-sub">Créez un compte médecin pour lui donner accès au système de gestion du cabinet.</p>
        </div>

        <div class="chips">
            <div class="chip"><i class="fas fa-calendar-check"></i> Accès aux rendez-vous</div>
            <div class="chip"><i class="fas fa-notes-medical"></i> Rédaction d'ordonnances</div>
            <div class="chip"><i class="fas fa-users"></i> Gestion des patients</div>
            <div class="chip"><i class="fas fa-shield-alt"></i> Espace sécurisé dédié</div>
        </div>
    </aside>

    <!-- ===== PANEL DROIT ===== -->
    <main class="panel-right">

        <!-- Barre admin -->
        <div class="admin-topbar">
            <a href="index.php?route=/admin/medecins" class="back-link">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <div>
                <span class="admin-badge"><i class="fas fa-user-shield"></i>
                    <?php echo htmlspecialchars(($_SESSION['user_prenom'] ?? '') . ' ' . ($_SESSION['user_nom'] ?? '')); ?>
                </span>
            </div>
        </div>

        <!-- Titre -->
        <div class="form-hd">
            <h1><i class="fas fa-user-md" style="color:var(--primary);margin-right:10px;"></i>Créer un compte Médecin</h1>
            <p>Remplissez tous les champs obligatoires pour enregistrer un nouveau médecin.</p>
        </div>

        <!-- Alertes -->
        <?php if (!empty($error)): ?>
            <div class="al al-err" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="al al-ok" role="alert">
                <i class="fas fa-check-circle"></i>
                <span><?php echo htmlspecialchars($success); ?></span>
            </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <form method="POST" action="index.php?route=/register-medecin" novalidate>

            <div class="section-label">Informations personnelles</div>
            <div class="grid-2">
                <!-- Nom -->
                <div class="field">
                    <label>Nom <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-user fi"></i>
                        <input type="text" name="nom" class="fc" placeholder="Dupont"
                            value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
                    </div>
                </div>
                <!-- Prénom -->
                <div class="field">
                    <label>Prénom <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-user fi"></i>
                        <input type="text" name="prenom" class="fc" placeholder="Jean"
                            value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
                    </div>
                </div>
                <!-- Email -->
                <div class="field">
                    <label>Email <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope fi"></i>
                        <input type="email" name="email" class="fc" placeholder="medecin@cabinet.com"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                </div>
                <!-- Téléphone -->
                <div class="field">
                    <label>Téléphone</label>
                    <div class="field-wrap">
                        <i class="fas fa-phone fi"></i>
                        <input type="tel" name="telephone" class="fc" placeholder="+212 6 XX XX XX XX"
                            value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="section-label">Informations professionnelles</div>
            <div class="grid-2">
                <!-- Spécialité -->
                <div class="field">
                    <label>Spécialité <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-stethoscope fi"></i>
                        <select name="specialite" class="fc" required>
                            <option value="">Sélectionner...</option>
                            <?php
                            $specs = ['Médecin Généraliste','Orthodontiste','Chirurgien dentiste','Parodontiste','Endodontiste','Implantologue'];
                            foreach ($specs as $s):
                                $sel = (isset($_POST['specialite']) && $_POST['specialite'] === $s) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $s; ?>" <?php echo $sel; ?>><?php echo $s; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <!-- Numéro Licence -->
                <div class="field">
                    <label>Numéro de licence</label>
                    <div class="field-wrap">
                        <i class="fas fa-certificate fi"></i>
                        <input type="text" name="numero_licence" class="fc" placeholder="CD-001"
                            value="<?php echo isset($_POST['numero_licence']) ? htmlspecialchars($_POST['numero_licence']) : ''; ?>">
                    </div>
                </div>
                <!-- Cabinet -->
                <div class="field col-full">
                    <label>Cabinet / Adresse</label>
                    <div class="field-wrap">
                        <i class="fas fa-map-marker-alt fi"></i>
                        <input type="text" name="cabinet" class="fc" placeholder="Adresse du cabinet ou clinique"
                            value="<?php echo isset($_POST['cabinet']) ? htmlspecialchars($_POST['cabinet']) : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="section-label">Sécurité du compte</div>
            <div class="grid-2">
                <!-- Mot de passe -->
                <div class="field">
                    <label>Mot de passe <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-lock fi"></i>
                        <input type="password" id="pw1" name="password" class="fc has-toggle"
                            placeholder="Min. 6 caractères" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('pw1','eye1')">
                            <i id="eye1" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <!-- Confirmer -->
                <div class="field">
                    <label>Confirmer <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-lock fi"></i>
                        <input type="password" id="pw2" name="confirm_password" class="fc has-toggle"
                            placeholder="Répéter le mot de passe" required>
                        <button type="button" class="toggle-pw" onclick="togglePw('pw2','eye2')">
                            <i id="eye2" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-user-plus"></i> Créer le compte médecin
            </button>

        </form>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePw(inputId, iconId) {
        const inp  = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const show = inp.type === 'password';
        inp.type   = show ? 'text' : 'password';
        icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
    }
    document.querySelector('form').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Création en cours…';
        btn.disabled = true;
    });
</script>
</body>
</html>
