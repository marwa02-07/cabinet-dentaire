<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte Secrétaire — Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f766e; --primary-dark: #0d5f58;
            --accent:  #06b6d4; --bg: #f0fdfb;
            --surface: #ffffff; --text: #0b2622;
            --muted:   #5d7a76; --line: #ccf0eb;
            --ok:      #16a34a; --err: #dc2626;
            --radius-xl: 22px;  --radius-lg: 14px;
            --radius-md: 10px;  --radius-pill: 999px;
            --shadow-lg: 0 24px 60px rgba(15,118,110,.20);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 16px;
            background:
                radial-gradient(1100px 480px at -10% -5%, rgba(15,118,110,.18), transparent 60%),
                radial-gradient(900px 400px at 105% 0%,  rgba(6,182,212,.15),   transparent 58%),
                var(--bg);
            background-attachment: fixed;
        }

        .particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .particle  { position: absolute; border-radius: 50%; opacity: .07; animation: float linear infinite; }
        .particle:nth-child(1) { width:280px; height:280px; background:var(--primary);     top:-60px;  left:-40px;  animation-duration:18s; }
        .particle:nth-child(2) { width:160px; height:160px; background:var(--accent);      top:58%;    right:-30px; animation-duration:22s; animation-delay:-7s; }
        .particle:nth-child(3) { width:110px; height:110px; background:var(--primary-dark);bottom:6%;  left:14%;    animation-duration:14s; animation-delay:-3s; }
        @keyframes float { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-26px) scale(1.04)} }

        /* Wrapper */
        .page-wrapper {
            position: relative; z-index: 1;
            width: 100%; max-width: 920px;
            display: grid; grid-template-columns: 280px 1fr;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        /* Panel gauche */
        .panel-left {
            background: linear-gradient(145deg, #0a5c56 0%, #0f766e 50%, #0891b2 100%);
            padding: 30px 26px;
            display: flex; flex-direction: column; justify-content: space-between;
            color: #fff; position: relative; overflow: hidden;
        }
        .panel-left::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(560px 360px at -10% 110%, rgba(6,182,212,.32), transparent 58%);
            pointer-events: none;
        }
        .panel-left > * { position: relative; z-index: 1; }

        .brand-mark { display: flex; align-items: center; gap: 10px; }
        .brand-icon {
            width: 44px; height: 44px; flex-shrink: 0;
            background: rgba(255,255,255,.16); border: 1.5px solid rgba(255,255,255,.28);
            border-radius: var(--radius-lg);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; backdrop-filter: blur(8px);
        }
        .brand-text { font-weight: 800; font-size: 14.5px; line-height: 1.2; }
        .brand-text small { font-weight: 500; font-size: 11px; opacity: .75; display: block; }

        .illus-center { text-align: center; }
        .illus-icon {
            font-size: 54px; display: block; margin-bottom: 8px;
            filter: drop-shadow(0 6px 20px rgba(0,0,0,.25));
            animation: pulse-icon 3.2s ease-in-out infinite;
        }
        @keyframes pulse-icon { 0%,100%{transform:scale(1) translateY(0)} 50%{transform:scale(1.05) translateY(-5px)} }
        .illus-title { font-size: 19px; font-weight: 900; letter-spacing: -.2px; margin-bottom: 6px; }
        .illus-sub   { font-size: 12px; opacity: .80; line-height: 1.55; max-width: 220px; margin: 0 auto; }

        .chips { display: flex; flex-direction: column; gap: 6px; }
        .chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.20);
            border-radius: var(--radius-pill); padding: 6px 11px;
            font-size: 11px; font-weight: 600; backdrop-filter: blur(6px);
        }
        .chip i { font-size: 11px; color: #6ee7e7; width: 14px; text-align: center; }

        /* Panel droit */
        .panel-right {
            background: var(--surface);
            padding: 26px 34px;
            display: flex; flex-direction: column; justify-content: center;
            overflow-y: auto;
        }

        .admin-topbar {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px; padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }
        .admin-topbar .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12.5px; font-weight: 600; color: var(--muted);
            text-decoration: none; transition: color .2s;
        }
        .admin-topbar .back-link:hover { color: var(--primary); }
        .admin-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: linear-gradient(135deg, rgba(15,118,110,.10), rgba(6,182,212,.08));
            color: var(--primary); border: 1px solid rgba(15,118,110,.20);
            border-radius: var(--radius-pill); padding: 4px 11px;
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
        }

        .form-hd { margin-bottom: 12px; }
        .form-hd h1 { font-size: 19px; font-weight: 900; color: var(--text); letter-spacing: -.3px; margin-bottom: 2px; }
        .form-hd p  { font-size: 12px; color: var(--muted); font-weight: 500; }

        .al {
            display: flex; align-items: flex-start; gap: 8px;
            padding: 10px 14px; border-radius: var(--radius-md);
            font-size: 13px; font-weight: 500; margin-bottom: 14px;
            animation: slideDown .3s ease;
        }
        @keyframes slideDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .al-err { background:rgba(220,38,38,.08);  color:var(--err); border:1px solid rgba(220,38,38,.2); }
        .al-ok  { background:rgba(22,163,74,.08);  color:var(--ok);  border:1px solid rgba(22,163,74,.2); }
        .al i   { margin-top: 1px; flex-shrink: 0; }

        .section-label {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .8px; color: var(--muted);
            margin: 12px 0 7px; display: flex; align-items: center; gap: 8px;
        }
        .section-label::after { content:''; flex:1; height:1px; background:var(--line); }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .col-full { grid-column: 1 / -1; }

        .field { display: flex; flex-direction: column; gap: 3px; }
        .field label { font-size: 11.5px; font-weight: 700; color: var(--text); }
        .field label .req { color: var(--err); margin-left: 2px; }

        .field-wrap { position: relative; }
        .field-wrap .fi {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: var(--muted); font-size: 13px; pointer-events: none; transition: color .2s;
        }
        .field-wrap:focus-within .fi { color: var(--primary); }
        .fc {
            width: 100%; padding: 8px 12px 8px 34px;
            border: 1.5px solid var(--line); border-radius: var(--radius-md);
            font-size: 13px; font-family: inherit; color: var(--text);
            background: var(--surface); outline: none;
            transition: border-color .2s, box-shadow .2s; appearance: none;
        }
        .fc::placeholder { color: #b0c4c1; }
        .fc:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15,118,110,.10);
            background: #f9fffe;
        }
        .toggle-pw {
            position: absolute; right: 11px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--muted);
            cursor: pointer; font-size: 13px; padding: 0; transition: color .2s;
        }
        .toggle-pw:hover { color: var(--primary); }
        .fc.has-toggle { padding-right: 36px; }

        .btn-submit {
            width: 100%; padding: 11px;
            background: linear-gradient(90deg, #0a5c56 0%, var(--primary) 50%, var(--accent) 100%);
            color: #fff; border: none; border-radius: var(--radius-md);
            font-size: 13.5px; font-weight: 700; font-family: inherit;
            cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 14px;
            box-shadow: 0 6px 20px rgba(15,118,110,.30);
            transition: transform .18s, box-shadow .18s, filter .18s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 26px rgba(15,118,110,.38); filter: brightness(1.04); }
        .btn-submit:active { transform: translateY(0); }

        @media (max-width: 800px) {
            .page-wrapper { grid-template-columns: 1fr; }
            .panel-left { display: none; }
            .panel-right { padding: 22px 18px; }
        }
        @media (max-width: 500px) { .grid-2 { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="particles" aria-hidden="true">
    <div class="particle"></div><div class="particle"></div><div class="particle"></div>
</div>

<div class="page-wrapper">

    <!-- PANEL GAUCHE -->
    <aside class="panel-left" aria-hidden="true">
        <div class="brand-mark">
            <div class="brand-icon"><i class="fas fa-tooth"></i></div>
            <div class="brand-text">Cabinet Dentaire<small>Administration</small></div>
        </div>
        <div class="illus-center">
            <i class="fas fa-user-nurse illus-icon"></i>
            <h2 class="illus-title">Nouvelle Secrétaire</h2>
            <p class="illus-sub">Créez un compte secrétaire pour gérer l'accueil et les rendez-vous.</p>
        </div>
        <div class="chips">
            <div class="chip"><i class="fas fa-calendar-alt"></i> Gestion des rendez-vous</div>
            <div class="chip"><i class="fas fa-users"></i> Suivi des patients</div>
            <div class="chip"><i class="fas fa-clipboard-list"></i> Planning quotidien</div>
            <div class="chip"><i class="fas fa-shield-alt"></i> Espace sécurisé dédié</div>
        </div>
    </aside>

    <!-- PANEL DROIT -->
    <main class="panel-right">

        <div class="admin-topbar">
            <a href="<?php echo BASE_URL; ?>index.php?route=/admin/secretaires" class="back-link">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <span class="admin-badge"><i class="fas fa-user-shield"></i>
                <?php echo htmlspecialchars(($_SESSION['user_prenom'] ?? '') . ' ' . ($_SESSION['user_nom'] ?? '')); ?>
            </span>
        </div>

        <div class="form-hd">
            <h1><i class="fas fa-user-nurse" style="color:var(--primary);margin-right:8px;"></i>Créer un compte Secrétaire</h1>
            <p>Remplissez tous les champs obligatoires pour enregistrer une nouvelle secrétaire.</p>
        </div>

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

        <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/register-secretaire" novalidate>

            <div class="section-label">Informations personnelles</div>
            <div class="grid-2">
                <div class="field">
                    <label>Nom <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-user fi"></i>
                        <input type="text" name="nom" class="fc" placeholder="Dupont"
                            value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label>Prénom <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-user fi"></i>
                        <input type="text" name="prenom" class="fc" placeholder="Marie"
                            value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label>Email <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope fi"></i>
                        <input type="email" name="email" class="fc" placeholder="secretaire@cabinet.com"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label>Téléphone</label>
                    <div class="field-wrap">
                        <i class="fas fa-phone fi"></i>
                        <input type="tel" name="telephone" class="fc" placeholder="+212 6 XX XX XX XX"
                            value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>">
                    </div>
                </div>
                <div class="field col-full">
                    <label>Département</label>
                    <div class="field-wrap">
                        <i class="fas fa-building fi"></i>
                        <input type="text" name="departement" class="fc" placeholder="Ex : Réception, Accueil..."
                            value="<?php echo isset($_POST['departement']) ? htmlspecialchars($_POST['departement']) : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="section-label">Sécurité du compte</div>
            <div class="grid-2">
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
                <i class="fas fa-user-plus"></i> Créer le compte secrétaire
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
