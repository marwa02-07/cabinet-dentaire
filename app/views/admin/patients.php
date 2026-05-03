<?php 
// Vérifications défensives pour les variables
?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Patients - Administration</title>
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
            --primary-gradient: linear-gradient(135deg, rgba(14,165,233,0.95) 0%, rgba(99,102,241,0.92) 55%, rgba(34,197,94,0.85) 120%);
            --primary-color: #6366f1;
        }
        body{
            color: var(--text);
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
        
        /* Navbar */
        .navbar-custom {
            background: var(--primary-gradient);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .navbar-custom .navbar-brand { font-weight: 800; letter-spacing: .2px; font-size: 18px; color: white !important; }
        .navbar-custom .nav-link { color: rgba(255, 255, 255, 0.92) !important; font-weight: 600; margin-left: 10px; border-radius: 999px; padding: 8px 12px; }
        .navbar-custom .nav-link:hover { color: white !important; background: rgba(255,255,255,0.16); }
        .navbar-custom .nav-link.active { color: white !important; background: rgba(255,255,255,0.20); }
        .user-info { color: rgba(255, 255, 255, 0.92); font-size: 13px; margin-right: 12px; display:flex; align-items:center; gap:10px; white-space: nowrap; }
        .user-info strong { color: white; font-weight: 700; }
        .role-badge { background-color: rgba(255, 255, 255, 0.18); border: 1px solid rgba(255,255,255,0.25); padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 800; letter-spacing: .5px; }
        
        /* Page Header */
        .page-header {
            background: var(--primary-gradient);
            padding: 30px 0;
            margin-bottom: 30px;
            margin-top: 0;
        }
        .page-header h1 { color: white; font-weight: 700; margin-bottom: 5px; }
        .page-header p { color: rgba(255,255,255,0.8); margin: 0; }
        
        /* Cards */
        .custom-card {
            border: 1px solid var(--border);
            border-radius: 15px;
            box-shadow: var(--shadowSm);
            margin-bottom: 20px;
        }
        
        /* Search Box */
        .search-container {
            background: rgba(255,255,255,0.92);
            border: 1px solid var(--border);
            padding: 20px;
            border-radius: 15px;
            box-shadow: var(--shadowSm);
            margin-bottom: 20px;
        }
        .search-box {
            max-width: 400px;
            border-radius: 30px;
            padding-left: 45px;
            border: 1px solid rgba(15,23,42,0.10);
            transition: all 0.3s;
        }
        .search-box:focus {
            outline: none;
            border-color: rgba(99,102,241,0.45);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.20);
        }
        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-gradient);
            border: none;
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 10px 22px rgba(15,23,42,0.14);
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            color: white;
        }
        
        /* Table */
        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }
        .modern-table thead {
            background: #f8f9fa;
        }
        .modern-table th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }
        .modern-table th i { margin-right: 8px; color: #667eea; }
        .modern-table th i { color: var(--primary-color); }
        .modern-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        .modern-table tbody tr {
            transition: all 0.3s;
        }
        .modern-table tbody tr:hover {
            background: #f8f9ff;
        }
        
        /* Patient Cell */
        .patient-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .patient-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        .patient-name {
            font-weight: 600;
            color: #2c3e50;
        }
        
        /* Info Cell */
        .info-cell {
            display: flex;
            flex-direction: column;
        }
        .info-cell .main { color: #2c3e50; }
        .info-cell .secondary { font-size: 12px; color: #6c757d; }
        
        /* Date Cell */
        .date-cell { color: #2c3e50; }
        
        /* Actions */
        .actions-cell {
            display: flex;
            gap: 8px;
        }
        .actions-cell .btn {
            width: 35px;
            height: 35px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-view {
            background: #e9ecef;
            color: #667eea;
            border: none;
        }
        .btn-view:hover { background: #667eea; color: white; }
        .btn-edit {
            background: #fff3cd;
            color: #ffc107;
            border: none;
        }
        .btn-edit:hover { background: #ffc107; color: white; }
        .btn-delete {
            background: #f8d7da;
            color: #dc3545;
            border: none;
        }
        .btn-delete:hover { background: #dc3545; color: white; }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state i { font-size: 64px; color: #dee2e6; margin-bottom: 20px; }
        .empty-state h4 { color: #2c3e50; font-weight: 600; margin-bottom: 10px; }
        .empty-state p { color: #6c757d; }
        
        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            border-top: 1px solid #e9ecef;
            flex-wrap: wrap;
            gap: 15px;
        }
        .pagination-info { color: #6c757d; font-size: 14px; }
        .pagination-info strong { color: #667eea; }
        .pagination { margin: 0; padding: 0; list-style: none; display: flex; gap: 8px; }
        .pagination li a, .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .pagination li a {
            background: #fff;
            border: 2px solid #e9ecef;
            color: #2c3e50;
        }
        .pagination li a:hover {
            background: var(--primary-gradient);
            border-color: #667eea;
            color: #fff;
        }
        .pagination li.active span {
            background: var(--primary-gradient);
            border-color: #667eea;
            color: #fff;
        }
        .pagination li.disabled span {
            background: #f8f9fa;
            border-color: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
        }
        
        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
        }
        
        /* Modal */
        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .modal-header .btn-close { filter: invert(1); }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .modern-table { display: block; overflow-x: auto; }
            .pagination-container { flex-direction: column; text-align: center; }
        }

        /* Structure like medecins.php */
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

        .table-card{ overflow:hidden; }

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
            background: var(--primary-gradient);
            box-shadow: 0 10px 22px rgba(15,23,42,0.14);
        }

        .btn-gradient:hover{ filter: brightness(0.98); color:#fff; }
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

    <div class="container-fluid mt-4">
        <div class="page-wrap px-2 px-md-3">
            <!-- Hero / Header -->
            <div class="hero">
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                    <div>
                        <h1 class="hero-title h4 mb-1">
                            <i class="fas fa-users me-2"></i>Gestion des Patients
                        </h1>
                        <p class="hero-sub">Rechercher, ajouter, modifier ou supprimer un patient.</p>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="position-relative" style="min-width: min(520px, 90vw);">
                            <i class="fas fa-magnifying-glass position-absolute text-muted" style="left: 16px; top: 50%; transform: translateY(-50%); z-index: 10;"></i>
                            <input type="text" id="searchPatient" class="form-control search"
                                placeholder="Rechercher par nom, prénom, email ou téléphone..." onkeyup="filterTable()">
                        </div>
                        <a href="<?php echo BASE_URL; ?>index.php?route=/register-patient" class="btn btn-hero btn-gradient">
                            <i class="fas fa-plus me-2"></i>Ajouter un patient
                        </a>
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

            <!-- Table -->
            <div class="soft-card table-card mt-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="modern-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user"></i> Patient</th>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <th><i class="fas fa-phone"></i> Téléphone</th>
                                <th><i class="fas fa-birthday-cake"></i> Date de naissance</th>
                                <th><i class="fas fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($patients)): ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <i class="fas fa-user-slash"></i>
                                            <h4>Aucun patient trouvé</h4>
                                            <p>Aucun patient ne correspond aux critères de recherche.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($patients as $patient): ?>
                                    <tr>
                                        <td>
                                            <div class="patient-cell">
                                                <div class="patient-avatar">
                                                    <?php echo strtoupper(substr($patient['prenom'] ?? 'P', 0, 1)); ?>
                                                </div>
                                                <span class="patient-name">
                                                    <?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-cell">
                                                <span class="main"><?php echo htmlspecialchars($patient['email'] ?? '-'); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-cell">
                                                <span class="main"><?php echo htmlspecialchars($patient['telephone'] ?? '-'); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="date-cell">
                                                <?php echo $patient['date_naissance'] ? htmlspecialchars(date('d/m/Y', strtotime($patient['date_naissance']))) : '-'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions-cell">
                                               
                                                <a href="<?php echo BASE_URL; ?>index.php?route=/admin/patients/edit/<?php echo $patient['id']; ?>" class="btn btn-edit" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/admin/patients/delete" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient?');">
                                                    <input type="hidden" name="patient_id" value="<?php echo $patient['id']; ?>">
                                                    <button type="submit" class="btn btn-delete" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info" id="paginationInfo">
                        Affichage 1 à <?php echo min(10, count($patients)); ?> sur <?php echo count($patients); ?> patients
                    </div>
                    <ul class="pagination" id="pagination">
                        <!-- JavaScript will populate this -->
                    </ul>
                </div>
            </div>
            </div>
        </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pagination
        const rowsPerPage = 10;
        let currentPage = 1;
        
        function filterTable() {
            const input = document.getElementById('searchPatient');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.modern-table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const patientCell = row.querySelector('.patient-name');
                const emailCell = row.cells[1];
                const phoneCell = row.cells[2];
                const dateCell = row.cells[3];
                
                const patientText = patientCell ? patientCell.textContent.toLowerCase() : '';
                const emailText = emailCell ? emailCell.textContent.toLowerCase() : '';
                const phoneText = phoneCell ? phoneCell.textContent.toLowerCase() : '';
                const dateText = dateCell ? dateCell.textContent.toLowerCase() : '';
                
                if (patientText.includes(filter) || emailText.includes(filter) || 
                    phoneText.includes(filter) || dateText.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            currentPage = 1;
            showPage(1);
        }
        
        function showPage(page) {
            currentPage = page;
            const table = document.querySelector('.modern-table');
            const rows = table.querySelectorAll('tbody tr');
            const searchTerm = document.getElementById('searchPatient').value.toLowerCase();
            
            let visibleRows = [];
            rows.forEach((row, index) => {
                if (row.style.display !== 'none') {
                    if (searchTerm === '') {
                        visibleRows.push(index);
                    } else {
                        const patientCell = row.querySelector('.patient-name');
                        const emailCell = row.cells[1];
                        const phoneCell = row.cells[2];
                        const dateCell = row.cells[3];
                        
                        const patientText = patientCell ? patientCell.textContent.toLowerCase() : '';
                        const emailText = emailCell ? emailCell.textContent.toLowerCase() : '';
                        const phoneText = phoneCell ? phoneCell.textContent.toLowerCase() : '';
                        const dateText = dateCell ? dateCell.textContent.toLowerCase() : '';
                        
                        if (patientText.includes(searchTerm) || emailText.includes(searchTerm) || 
                            phoneText.includes(searchTerm) || dateText.includes(searchTerm)) {
                            visibleRows.push(index);
                        }
                    }
                }
            });
            
            const totalRows = visibleRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            
            rows.forEach((row, index) => {
                if (visibleRows.includes(index)) {
                    const rowIndex = visibleRows.indexOf(index);
                    if (rowIndex >= start && rowIndex < end) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                } else {
                    row.style.display = 'none';
                }
            });
            
            renderPagination(page, totalPages, totalRows, start + 1, Math.min(end, totalRows));
        }
        
        function renderPagination(currentPage, totalPages, totalRows, start, end) {
            const pagination = document.getElementById('pagination');
            if (!pagination) return;
            
            let html = '';
            
            // Previous
            if (currentPage === 1) {
                html += '<li class="disabled"><span><i class="fas fa-chevron-left"></i></span></li>';
            } else {
                html += '<li><a href="javascript:void(0)" onclick="showPage(' + (currentPage - 1) + ')"><i class="fas fa-chevron-left"></i></a></li>';
            }
            
            // Pages
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    html += '<li class="active"><span>' + i + '</span></li>';
                } else {
                    html += '<li><a href="javascript:void(0)" onclick="showPage(' + i + ')">' + i + '</a></li>';
                }
            }
            
            // Next
            if (currentPage === totalPages) {
                html += '<li class="disabled"><span><i class="fas fa-chevron-right"></i></span></li>';
            } else {
                html += '<li><a href="javascript:void(0)" onclick="showPage(' + (currentPage + 1) + ')"><i class="fas fa-chevron-right"></i></a></li>';
            }
            
            pagination.innerHTML = html;
            
            const info = document.getElementById('paginationInfo');
            if (info) {
                if (totalRows === 0) {
                    info.innerHTML = 'Affichage 0 à 0 sur 0 patient';
                } else {
                    info.innerHTML = 'Affichage ' + start + ' à ' + end + ' sur ' + totalRows + ' patients';
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            showPage(1);
        });
    </script>
</body>
</html>