<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Consultations - Cabinet Dentaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 60px; }
        .navbar-custom { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-custom .navbar-brand { font-weight: 700; font-size: 20px; color: white !important; }
        .page-header { background: white; padding: 30px 0; margin-bottom: 30px; border-bottom: 1px solid #e9ecef; }
        .page-header h1 { color: #2c3e50; font-weight: 700; margin: 0; font-size: 32px; }
        .card-custom { background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 25px; margin-bottom: 20px; }
        .card-custom:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .diagnostic-badge { background-color: #e7f1ff; color: #0d6efd; padding: 8px 15px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .prix-badge { background-color: #d4edda; color: #155724; padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 700; }
        .btn-retour { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 10px 25px; border-radius: 6px; font-weight: 600; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-tooth"></i> Cabinet Dentaire</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="text-white me-3"><i class="fas fa-user"></i> <?php echo htmlspecialchars(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')); ?></span>
                <a href="index.php?route=/logout" class="btn btn-sm btn-danger"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </nav>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Mes Consultations</h1>
                    <p>Consultez vos diagnostics, traitements et ordonnances</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success p-3"><i class="fas fa-prescription-bottle-alt me-2"></i>Ordonnances incluses</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <a href="index.php?route=/patient/dashboard" class="btn btn-retour mb-4"><i class="fas fa-arrow-left"></i> Retour au dashboard</a>
        
        <?php if (empty($consultations)): ?>
            <div class="card-custom text-center py-5">
                <i class="fas fa-file-medical-alt fa-3x text-muted mb-3"></i>
                <h4>Aucune consultation</h4>
                <p class="text-muted">Vous n'avez pas encore de consultations enregistrées.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($consultations as $consultation): ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card-custom">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1"><i class="fas fa-user-md text-primary"></i> Dr. <?php echo htmlspecialchars(($consultation['dentiste_prenom'] ?? '') . ' ' . ($consultation['dentiste_nom'] ?? '')); ?></h5>
                                    <p class="text-muted mb-0"><?php echo htmlspecialchars($consultation['dentiste_specialite'] ?? 'Chirurgie Dentaire'); ?></p>
                                </div>
                                <?php if (!empty($consultation['prix'])): ?>
                                    <span class="prix-badge"><?php echo number_format($consultation['prix'], 2); ?> DH</span>
                                <?php endif; ?>
                            </div>
                            
                            <hr>
                            
                            <!-- Date -->
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-calendar-alt text-primary"></i> <strong>Date:</strong> <?php echo date('d/m/Y', strtotime($consultation['date_heure'] ?? '')); ?></p>
                                <p class="mb-0"><i class="fas fa-stethoscope text-primary"></i> <strong>Type:</strong> <?php echo htmlspecialchars(ucfirst($consultation['type_rendez_vous'] ?? 'Consultation')); ?></p>
                            </div>
                            
                            <!-- Diagnostic -->
                            <?php if (!empty($consultation['diagnostic'])): ?>
                                <div class="mb-3">
                                    <span class="diagnostic-badge"><i class="fas fa-search"></i> Diagnostic</span>
                                    <p class="mt-2 mb-0"><?php echo htmlspecialchars($consultation['diagnostic']); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Traitement effectué -->
                            <?php if (!empty($consultation['traitement_effectue'])): ?>
                                <div class="mb-3">
                                    <span class="diagnostic-badge" style="background-color: #d4edda; color: #155724;"><i class="fas fa-check-circle"></i> Traitement</span>
                                    <p class="mt-2 mb-0"><?php echo htmlspecialchars($consultation['traitement_effectue']); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Dents traitées -->
                            <?php if (!empty($consultation['dents_traitees'])): ?>
                                <div class="mb-3">
                                    <p class="mb-0"><i class="fas fa-tooth text-primary"></i> <strong>Dents traitées:</strong> <?php echo htmlspecialchars($consultation['dents_traitees']); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Badge Ordonnance -->
                            <?php if (!empty($consultation['ordonnance'])): ?>
                                <div class="mb-3">
                                    <span class="badge bg-success"><i class="fas fa-prescription-bottle-alt me-1"></i> Ordonnance disponible</span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Notes -->
                            <?php if (!empty($consultation['notes'])): ?>
                                <div class="mt-3 pt-3 border-top">
                                    <p class="mb-0 text-muted"><i class="fas fa-sticky-note"></i> <?php echo htmlspecialchars($consultation['notes']); ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Ordonnance -->
                            <?php if (!empty($consultation['ordonnance'])): ?>
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0"><i class="fas fa-prescription-bottle-alt text-success"></i> <strong>Ordonnance</strong></h6>
                                        <small class="text-muted"><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($consultation['ordonnance']['date_creation'] ?? '')); ?></small>
                                    </div>
                                    
                                    <?php if (!empty($consultation['ordonnance']['medicaments'])): ?>
                                        <div class="mb-3 p-3 bg-light rounded">
                                            <strong><i class="fas fa-pills me-2"></i>Médicaments :</strong>
                                            <ul class="mt-2 mb-0">
                                                <?php foreach ($consultation['ordonnance']['medicaments'] as $med): ?>
                                                    <li class="mb-2">
                                                        <strong><?php echo htmlspecialchars($med['nom_medicament']); ?></strong>
                                                        <?php if (!empty($med['dosage'])): ?> - <?php echo htmlspecialchars($med['dosage']); ?><?php endif; ?>
                                                        <?php if (!empty($med['frequence'])): ?>, <?php echo htmlspecialchars($med['frequence']); ?><?php endif; ?>
                                                        <?php if (!empty($med['duree'])): ?> <span class="badge bg-info text-dark"><?php echo htmlspecialchars($med['duree']); ?></span><?php endif; ?>
                                                        <?php if (!empty($med['instructions_medicament'])): ?><br><small class="text-muted">→ <?php echo htmlspecialchars($med['instructions_medicament']); ?></small><?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($consultation['ordonnance']['recommandations'])): ?>
                                        <div class="mb-2">
                                            <strong><i class="fas fa-list-ol me-2"></i>Posologie :</strong>
                                            <p class="mb-0 text-dark"><?php echo nl2br(htmlspecialchars($consultation['ordonnance']['recommandations'])); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($consultation['ordonnance']['instructions'])): ?>
                                        <div class="p-2 bg-warning bg-opacity-10 rounded">
                                            <strong><i class="fas fa-info-circle me-2"></i>Instructions :</strong>
                                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($consultation['ordonnance']['instructions'])); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>