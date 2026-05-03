<?php
// filepath: app/views/admin/register-patient.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte patient — Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --accent: #34d399;
            --accent-soft: #6ee7b7;
            --bg: #f0f9ff;
            --surface: #ffffff;
            --text: #0c1e2e;
            --muted: #5b6f82;
            --line: #c5e8f0;
            --ok: #16a34a;
            --err: #dc2626;
            --radius-xl: 22px;
            --radius-lg: 14px;
            --radius-md: 10px;
            --radius-pill: 999px;
            --shadow-lg: 0 24px 60px rgba(2, 132, 199, 0.18);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background:
                radial-gradient(1180px 500px at -12% -4%, rgba(2, 132, 199, 0.16), transparent 62%),
                radial-gradient(1000px 440px at 106% 0%, rgba(52, 211, 153, 0.14), transparent 56%),
                var(--bg);
            background-attachment: fixed;
        }

        .particles { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .particle { position: absolute; border-radius: 50%; opacity: .07; animation: float linear infinite; }
        .particle:nth-child(1) { width: 290px; height: 290px; background: var(--primary); top: -62px; left: -42px; animation-duration: 18s; }
        .particle:nth-child(2) { width: 170px; height: 170px; background: var(--accent); top: 56%; right: -28px; animation-duration: 22s; animation-delay: -7s; }
        .particle:nth-child(3) { width: 118px; height: 118px; background: var(--primary-dark); bottom: 5%; left: 12%; animation-duration: 15s; animation-delay: -3s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-26px) scale(1.04); }
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 960px;
            display: grid;
            grid-template-columns: 292px 1fr;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .panel-left {
            background: linear-gradient(145deg, #0369a1 0%, #0ea5e9 46%, #2dd4a4 100%);
            padding: 30px 26px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(580px 360px at -8% 108%, rgba(255, 255, 255, 0.18), transparent 58%);
            pointer-events: none;
        }
        .panel-left > * { position: relative; z-index: 1; }

        .brand-mark { display: flex; align-items: center; gap: 11px; }
        .brand-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.17);
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            backdrop-filter: blur(8px);
        }
        .brand-text { font-weight: 800; font-size: 15px; line-height: 1.2; }
        .brand-text small { font-weight: 500; font-size: 11px; opacity: .78; display: block; }

        .illus-center { text-align: center; }
        .illus-icon {
            font-size: 56px;
            display: block;
            margin-bottom: 8px;
            filter: drop-shadow(0 8px 22px rgba(0, 0, 0, 0.22));
            animation: pulse-icon 3.2s ease-in-out infinite;
        }
        @keyframes pulse-icon {
            0%, 100% { transform: scale(1) translateY(0); }
            50% { transform: scale(1.05) translateY(-5px); }
        }
        .illus-title { font-size: 19px; font-weight: 900; letter-spacing: -0.2px; margin-bottom: 6px; }
        .illus-sub {
            font-size: 12px;
            opacity: .84;
            line-height: 1.55;
            max-width: 232px;
            margin: 0 auto;
        }

        .chips { display: flex; flex-direction: column; gap: 6px; }
        .chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.13);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: var(--radius-pill);
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 600;
            backdrop-filter: blur(6px);
        }
        .chip i { font-size: 11px; color: var(--accent-soft); width: 14px; text-align: center; }

        .panel-right {
            background: var(--surface);
            padding: 26px 34px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
            max-height: min(96vh, 900px);
        }

        .admin-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }
        .admin-topbar .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            transition: color .2s;
        }
        .admin-topbar .back-link:hover { color: var(--primary); }
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.1), rgba(52, 211, 153, 0.1));
            color: var(--primary-dark);
            border: 1px solid rgba(2, 132, 199, 0.2);
            border-radius: var(--radius-pill);
            padding: 4px 11px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .form-hd { margin-bottom: 12px; flex-shrink: 0; }
        .form-hd h1 {
            font-size: 19px;
            font-weight: 900;
            color: var(--text);
            letter-spacing: -0.3px;
            margin-bottom: 2px;
            line-height: 1.25;
        }
        .form-hd p { font-size: 12px; color: var(--muted); font-weight: 500; }

        .al {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 14px;
            animation: slideDown .3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .al-err { background: rgba(220, 38, 38, 0.08); color: var(--err); border: 1px solid rgba(220, 38, 38, 0.2); }
        .al-ok { background: rgba(22, 163, 74, 0.08); color: var(--ok); border: 1px solid rgba(22, 163, 74, 0.2); }
        .al i { margin-top: 1px; flex-shrink: 0; }

        .section-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--muted);
            margin: 12px 0 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-label::after { content: ''; flex: 1; height: 1px; background: var(--line); }
        .section-label:first-child { margin-top: 0; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .col-full { grid-column: 1 / -1; }

        .field { display: flex; flex-direction: column; gap: 3px; }
        .field label { font-size: 11.5px; font-weight: 700; color: var(--text); }
        .field label .req { color: var(--err); margin-left: 2px; }

        .field-wrap { position: relative; }
        .field-wrap .fi {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 13px;
            pointer-events: none;
            transition: color .2s;
        }
        .field-wrap:focus-within .fi { color: var(--primary); }
        .field-wrap.textarea-wrap .fi {
            top: 12px;
            transform: none;
        }

        .fc {
            width: 100%;
            padding: 8px 12px 8px 34px;
            border: 1.5px solid var(--line);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            appearance: none;
        }
        .fc::placeholder { color: #98b4c8; }
        .fc:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
            background: #f8fcff;
        }
        .fc-textarea {
            min-height: 86px;
            padding: 10px 12px 10px 34px;
            resize: vertical;
            line-height: 1.45;
        }
        select.fc { cursor: pointer; }

        .toggle-pw {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 13px;
            padding: 0;
            transition: color .2s;
        }
        .toggle-pw:hover { color: var(--primary); }
        .fc.has-toggle { padding-right: 36px; }

        .btn-submit {
            width: 100%;
            padding: 11px;
            background: linear-gradient(90deg, #0369a1 0%, var(--primary) 48%, var(--accent) 100%);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
            box-shadow: 0 6px 20px rgba(2, 132, 199, 0.28);
            transition: transform .18s, box-shadow .18s, filter .18s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(2, 132, 199, 0.36);
            filter: brightness(1.03);
        }
        .btn-submit:active { transform: translateY(0); }

        @media (max-width: 880px) {
            .page-wrapper { grid-template-columns: 1fr; }
            .panel-left { display: none; }
            .panel-right { padding: 22px 18px; max-height: none; }
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

    <aside class="panel-left" aria-hidden="true">
        <div class="brand-mark">
            <div class="brand-icon"><i class="fas fa-tooth"></i></div>
            <div class="brand-text">Cabinet Dentaire<small>Administration</small></div>
        </div>
        <div class="illus-center">
            <i class="fas fa-heart-pulse illus-icon"></i>
            <h2 class="illus-title">Espace Patient</h2>
            <p class="illus-sub">Enregistrez un nouveau dossier avec des informations claires pour un suivi serein.</p>
        </div>
        <div class="chips">
            <div class="chip"><i class="fas fa-calendar-check"></i> Prise de rendez-vous</div>
            <div class="chip"><i class="fas fa-notes-medical"></i> Historique de soins</div>
            <div class="chip"><i class="fas fa-user-shield"></i> Données protégées</div>
            <div class="chip"><i class="fas fa-leaf"></i> Accompagnement bienveillant</div>
        </div>
    </aside>

    <main class="panel-right">

        <div class="admin-topbar">
            <a href="<?php echo BASE_URL; ?>index.php?route=/admin/patients" class="back-link">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            <span class="admin-badge"><i class="fas fa-user-shield"></i>
                <?php echo htmlspecialchars(($_SESSION['user_prenom'] ?? '') . ' ' . ($_SESSION['user_nom'] ?? '')); ?>
            </span>
        </div>

        <div class="form-hd">
            <h1><i class="fas fa-user-injured" style="color:var(--primary);margin-right:8px;"></i>Créer un compte patient</h1>
            <p>Renseignez les informations du patient : les champs marqués d’un astérisque sont obligatoires.</p>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="al al-err" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="al al-ok" role="alert">
                <i class="fas fa-check-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/admin/patients/create" novalidate>

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
                        <input type="text" name="prenom" class="fc" placeholder="Camille"
                            value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label>Email <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope fi"></i>
                        <input type="email" name="email" class="fc" placeholder="patient@exemple.com"
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
            </div>

            <div class="section-label">Santé et coordonnées</div>
            <div class="grid-2">
                <div class="field">
                    <label>Date de naissance</label>
                    <div class="field-wrap">
                        <i class="fas fa-calendar fi"></i>
                        <input type="date" name="date_naissance" class="fc"
                            value="<?php echo isset($_POST['date_naissance']) ? htmlspecialchars($_POST['date_naissance']) : ''; ?>">
                    </div>
                </div>
                <div class="field">
                    <label>Allergies</label>
                    <div class="field-wrap">
                        <i class="fas fa-notes-medical fi"></i>
                        <input type="text" name="allergies" class="fc" placeholder="Ex. pénicilline, latex…"
                            value="<?php echo isset($_POST['allergies']) ? htmlspecialchars($_POST['allergies']) : ''; ?>">
                    </div>
                </div>
                <div class="field col-full">
                    <label>Adresse</label>
                    <div class="field-wrap textarea-wrap">
                        <i class="fas fa-map-marker-alt fi"></i>
                        <textarea name="adresse" class="fc fc-textarea" rows="3" placeholder="Adresse complète"><?php echo isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : ''; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="section-label">Sécurité du compte</div>
            <div class="grid-2">
                <div class="field col-full">
                    <label>Mot de passe <span class="req">*</span></label>
                    <div class="field-wrap">
                        <i class="fas fa-lock fi"></i>
                        <input type="password" id="pw1" name="password" class="fc has-toggle" placeholder="Au moins 6 caractères" required minlength="6">
                        <button type="button" class="toggle-pw" onclick="togglePw('pw1','eye1')" aria-label="Afficher le mot de passe">
                            <i id="eye1" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-user-plus"></i> Créer le compte patient
            </button>
        </form>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePw(inputId, iconId) {
        const inp = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
    }
    document.querySelector('form').addEventListener('submit', function () {
        var btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Création en cours…';
        btn.disabled = true;
    });
</script>
</body>
</html>
