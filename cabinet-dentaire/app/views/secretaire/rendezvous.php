<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        
        /* Navbar */
        .navbar-custom { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .navbar-custom .navbar-brand { 
            font-weight: 700; 
            font-size: 20px; 
            color: white !important; 
        }
        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin-left: 15px;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: white !important;
        }
        .user-info {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-right: 20px;
        }
        .user-info strong {
            color: white;
            font-weight: 600;
        }
        .role-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
            font-weight: 600;
            margin-left: 10px;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            color: white;
        }
        
        /* Page Header */
        .page-header { 
            background: white; 
            padding: 30px 0; 
            margin-bottom: 30px; 
            border-bottom: 1px solid #e9ecef; 
        }
        .page-header h1 { 
            color: #2c3e50; 
            font-weight: 700; 
            margin: 0; 
            font-size: 32px; 
        }
        .page-header p {
            color: #6c757d;
            margin: 10px 0 0 0;
            font-size: 16px;
        }
        
        /* Filter Tabs */
        .filter-tabs {
            background: white;
            border-radius: 12px;
            padding: 20px 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .filter-tabs .btn-group {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        .filter-tabs .btn {
            padding: 10px 20px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        .filter-tabs .btn:hover {
            background: #f8f9fa;
        }
        .filter-tabs .btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-new-rdv {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-new-rdv:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        
        /* Table Container */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .table-container-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-container-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }
        .table-container-header .rdv-count {
            background: rgba(255,255,255,0.2);
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
        .modern-table thead th {
            padding: 18px 20px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
            text-align: left;
        }
        .modern-table thead th:first-child {
            border-radius: 0;
        }
        .modern-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        .modern-table tbody tr:hover {
            background: #f8f9ff;
        }
        .modern-table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            color: #2c3e50;
            font-size: 14px;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        /* Dentiste Cell */
        .dentiste-cell {
            color: #2c3e50;
        }
        .dentiste-cell i {
            color: #667eea;
            margin-right: 8px;
        }
        
        /* DateTime Cell */
        .datetime-cell {
            display: flex;
            flex-direction: column;
        }
        .datetime-cell .date {
            font-weight: 600;
            color: #2c3e50;
        }
        .datetime-cell .time {
            font-size: 13px;
            color: #667eea;
            font-weight: 600;
        }
        
        /* Type Badge */
        .type-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #e9ecef;
            color: #495057;
            text-transform: capitalize;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            text-transform: capitalize;
        }
        .status-pending, .status-planifie { background-color: #fff3cd; color: #856404; }
        .status-confirmed, .status-confirme { background-color: #d4edda; color: #155724; }
        .status-cancelled, .status-annule { background-color: #f8d7da; color: #721c24; }
        .status-completed, .status-complete, .status-complété { background-color: #e2e3e5; color: #383d41; }
        .status-absent { background-color: #fff3cd; color: #856404; }
        
        /* Actions */
        .actions-cell {
            display: flex;
            gap: 8px;
        }
        .actions-cell .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .actions-cell .btn:hover {
            transform: translateY(-2px);
        }
        .actions-cell .btn-edit {
            background: #e9ecef;
            color: #667eea;
            border: none;
        }
        .actions-cell .btn-edit:hover {
            background: #667eea;
            color: white;
        }
        .actions-cell .btn-confirm {
            background: #d4edda;
            color: #28a745;
            border: none;
        }
        .actions-cell .btn-confirm:hover {
            background: #28a745;
            color: white;
        }
        .actions-cell .btn-cancel {
            background: #f8d7da;
            color: #dc3545;
            border: none;
        }
        .actions-cell .btn-cancel:hover {
            background: #dc3545;
            color: white;
        }
        .actions-cell .btn-absent {
            background: #fff3cd;
            color: #856404;
            border: none;
        }
        .actions-cell .btn-absent:hover {
            background: #856404;
            color: white;
        }
        
        /* Search Bar */
        .search-bar-container {
            margin-bottom: 20px;
        }
        .search-input-wrapper {
            position: relative;
            max-width: 500px;
        }
        .search-input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 16px;
        }
        .search-input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 2px solid #e9ecef;
            border-radius: 30px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }
        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
        }
        .search-input::placeholder {
            color: #adb5bd;
        }
        
        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
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
            transition: all 0.3s ease;
        }
        .pagination li a {
            background: #fff;
            border: 2px solid #e9ecef;
            color: #2c3e50;
        }
        .pagination li a:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: #fff;
        }
        .pagination li.active span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: #fff;
        }
        .pagination li.disabled span {
            background: #f8f9fa;
            border-color: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
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
        
        /* Responsive */
        @media (max-width: 992px) {
            .filter-tabs {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-tabs .btn-group {
                width: 100%;
            }
            .filter-tabs .btn-group .btn {
                flex: 1;
            }
            .btn-new-rdv {
                width: 100%;
                justify-content: center;
            }
            .modern-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-tooth"></i> Cabinet Dentaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center">
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <strong><?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'Utilisateur'; ?></strong>
                        <span class="role-badge">Secrétaire</span>
                    </div>
                    <a href="index.php?route=/logout" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1><i class="fas fa-calendar-alt"></i> Gestion des Rendez-vous</h1>
            <p>Liste et gestion de tous les rendez-vous du cabinet</p>
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

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="btn-group" role="group">
                <a href="index.php?route=/secretaire/rendezvous&filter=all" class="btn <?php echo $filter === 'all' || $filter === '' ? 'active' : ''; ?>">
                    <i class="fas fa-list"></i> Tous
                </a>
                <a href="index.php?route=/secretaire/rendezvous&filter=today&date=<?php echo $dateFilter; ?>" class="btn <?php echo $filter === 'today' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-day"></i> Aujourd'hui
                </a>
                <a href="index.php?route=/secretaire/rendezvous&filter=upcoming" class="btn <?php echo $filter === 'upcoming' ? 'active' : ''; ?>">
                    <i class="fas fa-clock"></i> À venir
                </a>
                <a href="index.php?route=/secretaire/rendezvous&filter=past" class="btn <?php echo $filter === 'past' ? 'active' : ''; ?>">
                    <i class="fas fa-history"></i> Passés
                </a>
            </div>
            <a href="index.php?route=/secretaire/rendezvous/create" class="btn-new-rdv">
                <i class="fas fa-plus"></i> Nouveau Rendez-vous
            </a>
        </div>

        <!-- Search Bar -->
        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchRdv" class="search-input" placeholder="Rechercher par patient, dentiste ou type..." onkeyup="filterTable()">
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-container-header">
                <h3><i class="fas fa-list"></i> Liste des Rendez-vous</h3>
                <span class="rdv-count">
                    <i class="fas fa-calendar-check"></i> <?php echo count($rendezvous); ?> RDV
                </span>
            </div>
            
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Patient</th>
                            <th><i class="fas fa-user-md"></i> Dentiste</th>
                            <th><i class="fas fa-calendar"></i> Date & Heure</th>
                            <th><i class="fas fa-stethoscope"></i> Type</th>
                            <th><i class="fas fa-comment"></i> Motif</th>
                            <th><i class="fas fa-flag"></i> Statut</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rendezvous)): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-calendar-times"></i>
                                        <h4>Aucun rendez-vous trouvé</h4>
                                        <p>Aucun rendez-vous ne correspond aux critères de filtre.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($rendezvous as $rdv): ?>
                                <tr>
                                    <td>
                                        <div class="patient-cell">
                                            <div class="patient-avatar">
                                                <?php echo strtoupper(substr($rdv['patient_prenom'] ?? 'P', 0, 1)); ?>
                                            </div>
                                            <span class="patient-name">
                                                <?php echo htmlspecialchars(($rdv['patient_prenom'] ?? '') . ' ' . ($rdv['patient_nom'] ?? '')); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="dentiste-cell">
                                            <i class="fas fa-user-md"></i> Dr. <?php echo htmlspecialchars(($rdv['dentiste_prenom'] ?? '') . ' ' . ($rdv['dentiste_nom'] ?? '')); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="datetime-cell">
                                            <span class="date"><?php echo $rdv['date_heure'] ? htmlspecialchars(date('d/m/Y', strtotime($rdv['date_heure']))) : '-'; ?></span>
                                            <span class="time"><?php echo $rdv['date_heure'] ? htmlspecialchars(date('H:i', strtotime($rdv['date_heure']))) : ''; ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="type-badge"><?php echo htmlspecialchars($rdv['type_rendez_vous'] ?? 'Consultation'); ?></span>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($rdv['motif'] ?? '-'); ?>
                                    </td>
                                    <?php $currentStatus = $rdv['status'] ?? ($rdv['statut'] ?? 'pending'); ?>
                                    <td>
                                        <span class="status-badge status-<?php echo htmlspecialchars(str_replace('é', 'e', strtolower($currentStatus))); ?>">
                                            <?php echo htmlspecialchars(ucfirst($currentStatus)); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions-cell">
                                            <a href="index.php?route=/secretaire/rendezvous/edit&id=<?php echo $rdv['id']; ?>" class="btn btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($currentStatus !== 'cancelled' && $currentStatus !== 'annulé' && $currentStatus !== 'complété'): ?>
                                                <?php if ($currentStatus !== 'confirmed' && $currentStatus !== 'confirmé'): ?>
                                                    <form method="POST" action="index.php?route=/secretaire/rendezvous/status" class="d-inline">
                                                        <input type="hidden" name="rendezvous_id" value="<?php echo $rdv['id']; ?>">
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="btn btn-confirm" title="Confirmer">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <form method="POST" action="index.php?route=/secretaire/rendezvous/status" class="d-inline">
                                                    <input type="hidden" name="rendezvous_id" value="<?php echo $rdv['id']; ?>">
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-cancel" title="Annuler" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous?');">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
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
                    Affichage 1 à 10 sur <?php echo count($rendezvous); ?> rendez-vous
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
        let filteredRows = [];
        
        function filterTable() {
            const input = document.getElementById('searchRdv');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.modern-table');
            const rows = table.querySelectorAll('tbody tr');
            
            filteredRows = [];
            
            rows.forEach((row, index) => {
                const patientCell = row.querySelector('.patient-name');
                const dentisteCell = row.querySelector('.dentiste-cell');
                const typeCell = row.querySelector('.type-badge');
                const motifCell = row.cells[4];
                const statusCell = row.querySelector('.status-badge');
                
                const patientText = patientCell ? patientCell.textContent.toLowerCase() : '';
                const dentisteText = dentisteCell ? dentisteCell.textContent.toLowerCase() : '';
                const typeText = typeCell ? typeCell.textContent.toLowerCase() : '';
                const motifText = motifCell ? motifCell.textContent.toLowerCase() : '';
                const statusText = statusCell ? statusCell.textContent.toLowerCase() : '';
                
                if (patientText.includes(filter) || dentisteText.includes(filter) || 
                    typeText.includes(filter) || motifText.includes(filter) || statusText.includes(filter)) {
                    row.style.display = '';
                    filteredRows.push(index);
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Reset to first page when filtering
            currentPage = 1;
            showPage(1);
            updatePaginationInfo();
        }
        
        function showPage(page) {
            currentPage = page;
            const table = document.querySelector('.modern-table');
            const rows = table.querySelectorAll('tbody tr');
            const searchTerm = document.getElementById('searchRdv').value.toLowerCase();
            
            let visibleRows = [];
            rows.forEach((row, index) => {
                if (searchTerm === '') {
                    visibleRows.push(index);
                } else {
                    const patientCell = row.querySelector('.patient-name');
                    const dentisteCell = row.querySelector('.dentiste-cell');
                    const typeCell = row.querySelector('.type-badge');
                    const motifCell = row.cells[4];
                    const statusCell = row.querySelector('.status-badge');
                    
                    const patientText = patientCell ? patientCell.textContent.toLowerCase() : '';
                    const dentisteText = dentisteCell ? dentisteCell.textContent.toLowerCase() : '';
                    const typeText = typeCell ? typeCell.textContent.toLowerCase() : '';
                    const motifText = motifCell ? motifCell.textContent.toLowerCase() : '';
                    const statusText = statusCell ? statusCell.textContent.toLowerCase() : '';
                    
                    if (patientText.includes(searchTerm) || dentisteText.includes(searchTerm) || 
                        typeText.includes(searchTerm) || motifText.includes(searchTerm) || statusText.includes(searchTerm)) {
                        visibleRows.push(index);
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
                    info.innerHTML = 'Affichage 0 à 0 sur 0 rendez-vous';
                } else {
                    info.innerHTML = 'Affichage ' + start + ' à ' + end + ' sur ' + totalRows + ' rendez-vous';
                }
            }
        }
        
        function updatePaginationInfo() {
            const table = document.querySelector('.modern-table');
            const rows = table.querySelectorAll('tbody tr');
            const searchTerm = document.getElementById('searchRdv').value.toLowerCase();
            
            let visibleCount = 0;
            rows.forEach((row) => {
                if (row.style.display !== 'none') {
                    const patientCell = row.querySelector('.patient-name');
                    const dentisteCell = row.querySelector('.dentiste-cell');
                    const typeCell = row.querySelector('.type-badge');
                    const motifCell = row.cells[4];
                    const statusCell = row.querySelector('.status-badge');
                    
                    const patientText = patientCell ? patientCell.textContent.toLowerCase() : '';
                    const dentisteText = dentisteCell ? dentisteCell.textContent.toLowerCase() : '';
                    const typeText = typeCell ? typeCell.textContent.toLowerCase() : '';
                    const motifText = motifCell ? motifCell.textContent.toLowerCase() : '';
                    const statusText = statusCell ? statusCell.textContent.toLowerCase() : '';
                    
                    if (searchTerm === '' || patientText.includes(searchTerm) || dentisteText.includes(searchTerm) || 
                        typeText.includes(searchTerm) || motifText.includes(searchTerm) || statusText.includes(searchTerm)) {
                        visibleCount++;
                    }
                }
            });
            
            showPage(1);
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            showPage(1);
        });
    </script>
</body>
</html>