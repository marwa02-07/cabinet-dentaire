<?php
// filepath: app/views/admin/patients.php
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
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
        }
        body { background-color: #f8f9fa; padding-top: 60px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navbar */
        .navbar-custom {
            background: var(--primary-gradient);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand { font-weight: 700; font-size: 20px; color: white !important; }
        .navbar-custom .nav-link { color: rgba(255, 255, 255, 0.9) !important; font-weight: 500; margin-left: 15px; }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active { color: white !important; background: rgba(255,255,255,0.1); border-radius: 8px; }
        .user-info { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin-right: 20px; }
        .user-info strong { color: white; font-weight: 600; }
        .role-badge { background-color: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        
        /* Page Header */
        .page-header {
            background: var(--primary-gradient);
            padding: 30px 0;
            margin-bottom: 30px;
            margin-top: 60px;
        }
        .page-header h1 { color: white; font-weight: 700; margin-bottom: 5px; }
        .page-header p { color: rgba(255,255,255,0.8); margin: 0; }
        
        /* Cards */
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        
        /* Search Box */
        .search-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .search-box {
            max-width: 400px;
            border-radius: 30px;
            padding-left: 45px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }
        .search-box:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
        }
        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-gradient);
            border: none;
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
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
                        <a class="nav-link" href="index.php?route=/admin/secretaires">
                            <i class="fas fa-user-secret me-1"></i>Secrétaires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/admin/patients">
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

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-users"></i> Gestion des Patients</h1>
            <p>Liste et gestion de tous les patients du cabinet</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
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

        <!-- Search & Actions Bar -->
        <div class="search-container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="position-relative" style="flex: 1; max-width: 450px;">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchPatient" class="form-control search-box" 
                        placeholder="Rechercher par nom, prénom, email ou téléphone..." onkeyup="filterTable()">
                </div>
                <button class="btn btn-primary-custom text-white" data-bs-toggle="modal" data-bs-target="#createPatientModal">
                    <i class="fas fa-plus me-2"></i>Ajouter un Patient
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="custom-card">
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
                                                <a href="index.php?route=/admin/patients/view/<?php echo $patient['id']; ?>" class="btn btn-view" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="index.php?route=/admin/patients/edit/<?php echo $patient['id']; ?>" class="btn btn-edit" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="index.php?route=/admin/patients/delete" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient?');">
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

    <!-- Modal: Ajouter un Patient -->
    <div class="modal fade" id="createPatientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Ajouter un Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="index.php?route=/admin/patients/create">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" name="nom" class="form-control" required placeholder="Nom du patient">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" name="prenom" class="form-control" required placeholder="Prénom du patient">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required placeholder="email@exemple.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" name="telephone" class="form-control" required placeholder="+212 6 00 00 00 00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" name="date_naissance" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Âge</label>
                                <input type="number" name="age" class="form-control" min="1" max="150" placeholder="Âge">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Adresse</label>
                                <textarea name="adresse" class="form-control" rows="2" placeholder="Adresse complète"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Allergies</label>
                                <input type="text" name="allergies" class="form-control" placeholder="Allergies connues">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required minlength="6" placeholder="Mot de passe (min 6 caractères)">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary-custom text-white">
                            <i class="fas fa-plus me-2"></i>Ajouter
                        </button>
                    </div>
                </form>
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