<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Navbar */
        .navbar-custom {
            background: var(--primary-gradient);
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            margin-left: 20px;
        }
        .user-info i {
            font-size: 24px;
        }
        .role-badge {
            background: rgba(255,255,255,0.2);
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 12px;
        }
        .logout-btn {
            color: white;
            margin-left: 15px;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        /* Page Header */
        .page-header {
            background: var(--primary-gradient);
            padding: 40px 0;
            margin-bottom: 30px;
            margin-top: 70px;
        }
        .page-header h1 {
            color: white;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .page-header p {
            color: rgba(255,255,255,0.8);
            margin: 0;
        }
        
        /* Filter & Actions Bar */
        .actions-bar {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .search-box {
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 2px solid #e9ecef;
            border-radius: 30px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
        }
        .search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
        }
        .btn-new-patient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-new-patient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        /* Table Container */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .table-container-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-container-header h3 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }
        .patient-count {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        /* Modern Table */
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
        .modern-table th i {
            margin-right: 8px;
            color: #667eea;
        }
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
        
        /* Patient Info */
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
        
        /* Email & Phone */
        .info-cell {
            display: flex;
            flex-direction: column;
        }
        .info-cell .main {
            color: #2c3e50;
        }
        .info-cell .secondary {
            font-size: 12px;
            color: #6c757d;
        }
        
        /* Date Cell */
        .date-cell {
            color: #2c3e50;
        }
        
        /* Actions Cell */
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
        .btn-view:hover {
            background: #667eea;
            color: white;
        }
        .btn-edit {
            background: #fff3cd;
            color: #ffc107;
            border: none;
        }
        .btn-edit:hover {
            background: #ffc107;
            color: white;
        }
        .btn-delete {
            background: #f8d7da;
            color: #dc3545;
            border: none;
        }
        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        .empty-state h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .empty-state p {
            color: #6c757d;
        }
        
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
        .pagination-info {
            color: #6c757d;
            font-size: 14px;
        }
        .pagination-info strong {
            color: #667eea;
        }
        .pagination {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            gap: 8px;
        }
        .pagination li a,
        .pagination li span {
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
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .actions-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box {
                max-width: 100%;
            }
            .btn-new-patient {
                justify-content: center;
            }
        }
        
        @media (max-width: 768px) {
            .modern-table {
                display: block;
                overflow-x: auto;
            }
            .pagination-container {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-tooth"></i> Cabinet Dentaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/dashboard">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?route=/secretaire/patients">
                            <i class="fas fa-users"></i> Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/rendezvous">
                            <i class="fas fa-calendar-alt"></i> Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=/secretaire/planning">
                            <i class="fas fa-clock"></i> Planning
                        </a>
                    </li>
                </ul>
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <strong><?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'Utilisateur'; ?></strong>
                    <span class="role-badge">Secrétaire</span>
                    <a href="index.php?route=/logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
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
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Actions Bar -->
        <div class="actions-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchPatient" class="form-control" placeholder="Rechercher par nom, prénom, email ou téléphone..." onkeyup="filterTable()">
            </div>
            <a href="index.php?route=/secretaire/patients/create" class="btn btn-new-patient">
                <i class="fas fa-plus"></i> Nouveau Patient
            </a>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-container-header">
                <h3><i class="fas fa-list"></i> Liste des Patients</h3>
                <span class="patient-count">
                    <i class="fas fa-user-friends"></i> <?php echo count($patients); ?> Patients
                </span>
            </div>
            
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
                                            <div class="patient-info">
                                                <span class="patient-name">
                                                    <?php echo htmlspecialchars(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="info-cell">
                                            <span class="main"><?php echo htmlspecialchars($patient['email'] ?? '-'); ?></span>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="info-cell">
                                            <span class="main"><?php echo htmlspecialchars($patient['telephone'] ?? '-'); ?></span>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="date-cell">
                                            <?php echo $patient['date_naissance'] ? htmlspecialchars(date('d/m/Y', strtotime($patient['date_naissance']))) : '-'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions-cell">
                                            <a href="index.php?route=/secretaire/patients/view&id=<?php echo $patient['id']; ?>" class="btn btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="index.php?route=/secretaire/patients/edit&id=<?php echo $patient['id']; ?>" class="btn btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="index.php?route=/secretaire/patients/delete" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient?');">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pagination variables
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
            
            // Reset to first page when filtering
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
            
            // Previous button
            if (currentPage === 1) {
                html += '<li class="disabled"><span><i class="fas fa-chevron-left"></i></span></li>';
            } else {
                html += '<li><a href="javascript:void(0)" onclick="showPage(' + (currentPage - 1) + ')"><i class="fas fa-chevron-left"></i></a></li>';
            }
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    html += '<li class="active"><span>' + i + '</span></li>';
                } else {
                    html += '<li><a href="javascript:void(0)" onclick="showPage(' + i + ')">' + i + '</a></li>';
                }
            }
            
            // Next button
            if (currentPage === totalPages) {
                html += '<li class="disabled"><span><i class="fas fa-chevron-right"></i></span></li>';
            } else {
                html += '<li><a href="javascript:void(0)" onclick="showPage(' + (currentPage + 1) + ')"><i class="fas fa-chevron-right"></i></a></li>';
            }
            
            pagination.innerHTML = html;
            
            // Update info text
            const info = document.getElementById('paginationInfo');
            if (info) {
                if (totalRows === 0) {
                    info.innerHTML = 'Affichage 0 à 0 sur 0 patient';
                } else {
                    info.innerHTML = 'Affichage ' + start + ' à ' + end + ' sur ' + totalRows + ' patients';
                }
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            showPage(1);
        });
    </script>
</body>
</html>