<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Cabinet Dentaire</title>
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

    <div class="dashboard">
        <section class="welcome-banner">
            <h1 class="welcome-title"><i class="fas fa-users me-2"></i>Gestion des patients</h1>
            <p class="welcome-sub">Liste et gestion de tous les patients du cabinet.</p>
        </section>
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
            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients/create" class="btn btn-new-patient">
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
                                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients/view&id=<?php echo $patient['id']; ?>" class="btn btn-view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients/edit&id=<?php echo $patient['id']; ?>" class="btn btn-edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=/secretaire/patients/delete" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce patient?');">
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
