<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez-vous - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>css/secretaire-theme.css" rel="stylesheet">
</head>
<body class="secretaire-body">
<nav class="navbar navbar-expand-lg topbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/dashboard">
                <i class="fas fa-tooth me-2"></i>Cabinet Dentaire - Secrétaire
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/dashboard">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous">
                            <i class="fas fa-calendar-check me-1"></i>Rendez-vous
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients">
                            <i class="fas fa-users me-1"></i>Patients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php?route=/secretaire/planning">
                            <i class="fas fa-calendar-alt me-1"></i>Planning
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="secretary-pill">
                        <i class="fas fa-user-tie"></i>
                        <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?>
                    </div>
                    <a href="<?php echo BASE_URL; ?>index.php?route=/logout" class="btn btn-outline-light btn-sm ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard rdv-page-inner">
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-calendar-alt me-2"></i>Gestion des rendez-vous</h1>
            <p class="welcome-sub">Liste et gestion de tous les rendez-vous du cabinet.</p>
        </section>

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
                <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous&filter=all" class="btn <?php echo $filter === 'all' || $filter === '' ? 'active' : ''; ?>">
                    <i class="fas fa-list"></i> Tous
                </a>
                <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous&filter=today&date=<?php echo $dateFilter; ?>" class="btn <?php echo $filter === 'today' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-day"></i> Aujourd'hui
                </a>
                <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous&filter=upcoming" class="btn <?php echo $filter === 'upcoming' ? 'active' : ''; ?>">
                    <i class="fas fa-clock"></i> À venir
                </a>
                <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous&filter=past" class="btn <?php echo $filter === 'past' ? 'active' : ''; ?>">
                    <i class="fas fa-history"></i> Passés
                </a>
            </div>
            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/create" class="btn-new-rdv">
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
        <div class="table-container sec-table-rdv">
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
                                    <td>
                                        <span class="status-badge status-<?php echo $rdv['statut'] ?? 'planifie'; ?>">
                                            <?php echo ucfirst($rdv['statut'] ?? 'planifié'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions-cell">
                                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/edit&id=<?php echo $rdv['id']; ?>" class="btn btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if (($rdv['statut'] ?? '') !== 'annulé' && ($rdv['statut'] ?? '') !== 'complété'): ?>
                                                <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/status" class="d-inline">
                                                    <input type="hidden" name="rendezvous_id" value="<?php echo $rdv['id']; ?>">
                                                    <input type="hidden" name="statut" value="confirmé">
                                                    <button type="submit" class="btn btn-confirm" title="Confirmer">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/status" class="d-inline">
                                                    <input type="hidden" name="rendezvous_id" value="<?php echo $rdv['id']; ?>">
                                                    <input type="hidden" name="statut" value="annulé">
                                                    <button type="submit" class="btn btn-cancel" title="Annuler" onclick="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous?');">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/status" class="d-inline">
                                                    <input type="hidden" name="rendezvous_id" value="<?php echo $rdv['id']; ?>">
                                                    <input type="hidden" name="statut" value="absent">
                                                    <button type="submit" class="btn btn-absent" title="Marquer absent">
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/secretaire/rendezvous/status" class="d-inline">
                                                    <input type="hidden" name="rendezvous_id" value="<?php echo $rdv['id']; ?>">
                                                    <input type="hidden" name="statut" value="complété">
                                                    <button type="submit" class="btn btn-success" title="Marquer complété">
                                                        <i class="fas fa-check-circle"></i>
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
