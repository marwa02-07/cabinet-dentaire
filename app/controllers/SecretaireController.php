<?php

/**
 * SecretaireController
 * Gère les pages accessibles aux secrétaires
 * Gestion des patients, rendez-vous et planning
 */

class SecretaireController extends Controller
{
    private $patientModel;
    private $rvModel;
    private $medecinModel;
    private $userModel;

    public function __construct()
    {
        $this->patientModel = new Patient();
        $this->rvModel = new RendezVous();
        $this->medecinModel = new Medecin();
        $this->userModel = new User();
    }

    /**
     * Affiche le dashboard secrétaire
     */
    public function dashboard()
    {
        Auth::role('secretaire');
        
        $user = Auth::user();
        $today = date('Y-m-d');
        $todayStart = $today . ' 00:00:00';
        $todayEnd = $today . ' 23:59:59';

        $stats = [
            'patients' => $this->patientModel->countAll() ?? 0,
            'appointments_today' => $this->rvModel->countByDate($todayStart, $todayEnd),
            'appointments_confirmed' => $this->rvModel->countByStatus('confirmé'),
        ];

        $this->view('secretaire.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    }

    /**
     * Liste tous les patients
     */
    public function patients()
    {
        Auth::role('secretaire');
        
        $search = $_GET['search'] ?? '';
        $patients = $search ? $this->patientModel->search($search) : $this->patientModel->findAll();

        $this->view('secretaire.patients', [
            'patients' => $patients,
            'search' => $search
        ]);
    }

    /**
     * Formulaire de création d'un patient
     */
    public function createPatient()
    {
        Auth::role('secretaire');
        
        $this->view('secretaire.create-patient');
    }

    /**
     * Formulaire de modification d'un patient
     */
    public function editPatient()
    {
        Auth::role('secretaire');
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        $patient = $this->patientModel->findById($id);
        if (!$patient) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        $this->view('secretaire.edit-patient', [
            'patient' => $patient
        ]);
    }

    /**
     * Voir les détails d'un patient
     */
    public function viewPatient()
    {
        Auth::role('secretaire');
        
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        $patient = $this->patientModel->findById($id);
        if (!$patient) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        // Récupérer les rendez-vous du patient
        $rendezvous = $this->rvModel->getByPatientId($id);

        $this->view('secretaire.view-patient', [
            'patient' => $patient,
            'rendezvous' => $rendezvous
        ]);
    }

    /**
     * Enregistrer un nouveau patient
     */
    public function storePatient()
    {
        Auth::role('secretaire');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=/secretaire/patients/create');
            exit;
        }

        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $date_naissance = $_POST['date_naissance'] ?? '';
        $adresse = trim($_POST['adresse'] ?? '');

        // Validation
        if (empty($nom) || empty($prenom) || empty($email)) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires';
            header('Location: index.php?route=/secretaire/patients/create');
            exit;
        }

        // Vérifier si l'email existe déjà
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Cet email est déjà utilisé';
            header('Location: index.php?route=/secretaire/patients/create');
            exit;
        }

        // Générer mot de passe temporaire
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Créer l'utilisateur
            $userId = $this->userModel->create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => 'patient'
            ]);

            if (!$userId) {
                throw new Exception('Erreur lors de la création de l\'utilisateur');
            }

            // Calculer l'âge si date de naissance fournie
            $age = null;
            if ($date_naissance) {
                $age = date('Y') - date('Y', strtotime($date_naissance));
            }

            // Créer le patient
            $patientId = $this->patientModel->create([
                'user_id' => $userId,
                'age' => $age,
                'telephone' => $telephone,
                'adresse' => $adresse,
                'date_naissance' => $date_naissance,
                'groupe_sanguin' => $_POST['groupe_sanguin'] ?? null,
                'allergies' => $_POST['allergies'] ?? null,
                'observations' => $_POST['observations'] ?? null
            ]);

            if (!$patientId) {
                throw new Exception('Erreur lors de la création du patient');
            }

            $_SESSION['success'] = 'Patient créé avec succès. Mot de passe temporaire: ' . $password;
            header('Location: index.php?route=/secretaire/patients');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: index.php?route=/secretaire/patients/create');
            exit;
        }
    }

    /**
     * Mettre à jour un patient
     */
    public function updatePatient()
    {
        Auth::role('secretaire');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        $id = $_POST['patient_id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        $patient = $this->patientModel->findById($id);
        if (!$patient) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        try {
            // Mettre à jour le patient
            $this->patientModel->update($id, [
                'telephone' => $_POST['telephone'] ?? '',
                'adresse' => $_POST['adresse'] ?? '',
                'date_naissance' => $_POST['date_naissance'] ?? null,
                'groupe_sanguin' => $_POST['groupe_sanguin'] ?? null,
                'allergies' => $_POST['allergies'] ?? null,
                'observations' => $_POST['observations'] ?? null
            ]);

            // Mettre à jour l'utilisateur associé
            $this->userModel->update($patient['user_id'], [
                'nom' => $_POST['nom'] ?? '',
                'prenom' => $_POST['prenom'] ?? '',
                'email' => $_POST['email'] ?? ''
            ]);

            $_SESSION['success'] = 'Patient mis à jour avec succès';
            header('Location: index.php?route=/secretaire/patients');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: index.php?route=/secretaire/patients/edit?id=' . $id);
            exit;
        }
    }

    /**
     * Supprimer un patient
     */
    public function deletePatient()
    {
        Auth::role('secretaire');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        $id = $_POST['patient_id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        $patient = $this->patientModel->findById($id);
        if (!$patient) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }

        try {
            // Supprimer le patient (la cascade supprimera l'utilisateur)
            $this->patientModel->delete($id);
            
            $_SESSION['success'] = 'Patient supprimé avec succès';
            header('Location: index.php?route=/secretaire/patients');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: index.php?route=/secretaire/patients');
            exit;
        }
    }

    /**
     * Liste tous les rendez-vous
     */
    public function rendezVous()
    {
        Auth::role('secretaire');
        
        $filter = $_GET['filter'] ?? 'all';
        $dateFilter = $_GET['date'] ?? date('Y-m-d');

        switch ($filter) {
            case 'today':
                $startDate = $dateFilter . ' 00:00:00';
                $endDate = $dateFilter . ' 23:59:59';
                $rdvs = $this->rvModel->getByDateRange($startDate, $endDate);
                break;
            case 'upcoming':
                $rdvs = $this->rvModel->getUpcoming();
                break;
            case 'past':
                $rdvs = $this->rvModel->getPast();
                break;
            default:
                $rdvs = $this->rvModel->getAll();
        }

        $patients = $this->patientModel->findAll();
        $dentistes = $this->medecinModel->findAll();

        $this->view('secretaire.rendezvous', [
            'rendezvous' => $rdvs,
            'patients' => $patients,
            'dentistes' => $dentistes,
            'filter' => $filter,
            'dateFilter' => $dateFilter
        ]);
    }

    /**
     * Formulaire de création d'un rendez-vous
     */
    public function createRdv()
    {
        Auth::role('secretaire');
        
        $patients = $this->patientModel->findAll();
        $dentistes = $this->medecinModel->findAll();

        $prefillPatientId = isset($_GET['patient_id']) ? (int) $_GET['patient_id'] : 0;

        $this->view('secretaire.create-rendezvous', [
            'patients' => $patients,
            'dentistes' => $dentistes,
            'prefillPatientId' => $prefillPatientId,
        ]);
    }

    /**
     * Formulaire de modification d'un rendez-vous
     */
    public function editRdv()
    {
        Auth::role('secretaire');
        
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Rendez-vous non trouvé';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $rdv = $this->rvModel->getById($id);
        if (!$rdv) {
            $_SESSION['error'] = 'Rendez-vous non trouvé';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $patients = $this->patientModel->findAll();
        $dentistes = $this->medecinModel->findAll();

        $this->view('secretaire.edit-rendezvous', [
            'rendezvous' => $rdv,
            'patients' => $patients,
            'dentistes' => $dentistes
        ]);
    }

    /**
     * Enregistrer un nouveau rendez-vous
     */
    public function storeRdv()
    {
        Auth::role('secretaire');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        $patient_id = isset($_POST['patient_id']) ? (int) $_POST['patient_id'] : 0;
        $dentiste_id = isset($_POST['dentiste_id']) ? (int) $_POST['dentiste_id'] : 0;
        $date = isset($_POST['date']) ? trim($_POST['date']) : '';
        $heure = isset($_POST['heure']) ? trim($_POST['heure']) : '';
        $type_rendez_vous = ConsultationTypeCatalog::normalize($_POST['type_rendez_vous'] ?? '');
        $motif = $_POST['motif'] ?? '';
        $allowedDuree = [15, 30, 45, 60];
        $duree_minutes = isset($_POST['duree_minutes']) ? (int) $_POST['duree_minutes'] : 30;
        if (!in_array($duree_minutes, $allowedDuree, true)) {
            $duree_minutes = 30;
        }

        // Validation
        if ($patient_id <= 0 || $dentiste_id <= 0 || $date === '' || $heure === '' || $type_rendez_vous === '') {
            $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        if (!$this->patientModel->findById($patient_id)) {
            $_SESSION['error'] = 'Patient introuvable';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $_SESSION['error'] = 'Date invalide';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        $heureObj = DateTime::createFromFormat('H:i', trim($heure));
        if (!$heureObj) {
            $_SESSION['error'] = 'Heure invalide';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }
        $heureNorm = $heureObj->format('H:i');
        $date_heure = $date . ' ' . $heureNorm . ':00';

        $slotStarts = $this->rvModel->getPatientBookingSlots($dentiste_id, $patient_id, $date, $duree_minutes);
        if (!in_array($heureNorm, $slotStarts, true)) {
            $_SESSION['error'] = 'Ce créneau n\'est plus disponible. Veuillez choisir une autre date ou un autre horaire.';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        // Vérifier les conflits de rendez-vous
        if ($this->rvModel->checkConflict($patient_id, $date_heure)) {
            $_SESSION['error'] = 'Ce patient a déjà un rendez-vous à cette date/heure';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        // Vérifier les conflits de dentiste (avec durée)
        if ($this->rvModel->checkDentistConflict($dentiste_id, $date_heure, null, $duree_minutes)) {
            $_SESSION['error'] = 'Ce créneau est déjà réservé pour ce dentiste. Veuillez choisir un autre horaire.';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        if ($this->rvModel->checkOverlap($patient_id, $date_heure, $duree_minutes)) {
            $_SESSION['error'] = 'Ce créneau chevauche avec un rendez-vous existant de ce patient.';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        // VALIDATION BACKEND: Vérifier que le dentiste correspond à la spécialité
        if (!$this->medecinModel->verifySpecialite($dentiste_id, $type_rendez_vous)) {
            $_SESSION['error'] = 'Le dentiste sélectionné ne correspond pas au type de rendez-vous';
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }

        try {
            // Récupérer l'ID du secrétaire à partir de la table secretaires
            $userId = $_SESSION['user_id'] ?? null;
            $secretaire_id = null;
            
            if ($userId) {
                $secretaireModel = new Secretaire();
                $secretaire = $secretaireModel->findByUserId($userId);
                $secretaire_id = $secretaire['id'] ?? null;
            }

            $rdvId = $this->rvModel->create([
                'patient_id' => $patient_id,
                'dentiste_id' => $dentiste_id,
                'secretaire_id' => $secretaire_id,
                'date_heure' => $date_heure,
                'duree_minutes' => $duree_minutes,
                'motif' => $motif,
                'type_rendez_vous' => $type_rendez_vous,
                'statut' => 'planifié'
            ]);

            if (!$rdvId) {
                throw new Exception('Erreur lors de la création du rendez-vous');
            }

            $_SESSION['success'] = 'Rendez-vous créé avec succès';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: index.php?route=/secretaire/rendezvous/create');
            exit;
        }
    }

    /**
     * Mettre à jour un rendez-vous
     */
    public function updateRdv()
    {
        Auth::role('secretaire');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $id = $_POST['rendezvous_id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Rendez-vous non trouvé';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $rdv = $this->rvModel->getById($id);
        if (!$rdv) {
            $_SESSION['error'] = 'Rendez-vous non trouvé';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $patient_id = $_POST['patient_id'] ?? $rdv['patient_id'];
        $dentiste_id = $_POST['dentiste_id'] ?? $rdv['dentiste_id'];
        $date_heure = $_POST['date_heure'] ?? $rdv['date_heure'];
        $type_rendez_vous = ConsultationTypeCatalog::normalize($_POST['type_rendez_vous'] ?? $rdv['type_rendez_vous']);

        if ($type_rendez_vous === '') {
            $_SESSION['error'] = 'Type de rendez-vous invalide';
            header('Location: index.php?route=/secretaire/rendezvous/edit?id=' . $id);
            exit;
        }

        if (!$this->medecinModel->verifySpecialite((int) $dentiste_id, $type_rendez_vous)) {
            $_SESSION['error'] = 'Le dentiste sélectionné ne correspond pas au type de rendez-vous';
            header('Location: index.php?route=/secretaire/rendezvous/edit?id=' . $id);
            exit;
        }

        // Vérifier les conflits si la date a changé
        if ($date_heure !== $rdv['date_heure']) {
            if ($this->rvModel->checkConflict($patient_id, $date_heure, $id)) {
                $_SESSION['error'] = 'Ce patient a déjà un rendez-vous à cette date/heure';
                header('Location: index.php?route=/secretaire/rendezvous/edit?id=' . $id);
                exit;
            }

            if ($this->rvModel->checkDentistConflict($dentiste_id, $date_heure, $id)) {
                $_SESSION['error'] = 'Ce dentiste a déjà un rendez-vous à cette date/heure';
                header('Location: index.php?route=/secretaire/rendezvous/edit?id=' . $id);
                exit;
            }
        }

        try {
            $this->rvModel->update($id, [
                'patient_id' => $patient_id,
                'dentiste_id' => $dentiste_id,
                'date_heure' => $date_heure,
                'duree_minutes' => $_POST['duree_minutes'] ?? $rdv['duree_minutes'],
                'motif' => $_POST['motif'] ?? '',
                'type_rendez_vous' => $type_rendez_vous
            ]);

            $_SESSION['success'] = 'Rendez-vous mis à jour avec succès';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: index.php?route=/secretaire/rendezvous/edit?id=' . $id);
            exit;
        }
    }

    /**
     * Supprimer un rendez-vous
     */
    public function deleteRdv()
    {
        Auth::role('secretaire');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $id = $_POST['rendezvous_id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Rendez-vous non trouvé';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        try {
            $this->rvModel->delete($id);
            
            $_SESSION['success'] = 'Rendez-vous supprimé avec succès';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }
    }

    /**
     * Mettre à jour le statut d'un rendez-vous
     */
    public function updateStatus()
    {
        Auth::role('secretaire');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $id = $_POST['rendezvous_id'] ?? null;
        $status = $_POST['statut'] ?? null;

        if (!$id || !$status) {
            $_SESSION['error'] = 'Paramètres invalides';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        $validStatuses = ['planifié', 'confirmé', 'annulé', 'complété', 'absent'];
        if (!in_array($status, $validStatuses)) {
            $_SESSION['error'] = 'Statut invalide';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }

        try {
            $this->rvModel->updateStatus($id, $status);
            
            $_SESSION['success'] = 'Statut mis à jour avec succès';
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: index.php?route=/secretaire/rendezvous');
            exit;
        }
    }

    /**
     * Afficher le planning
     */
    public function planning()
    {
        Auth::role('secretaire');
        
        $dateFilter = $_GET['date'] ?? date('Y-m-d');
        $dentisteFilter = $_GET['dentiste'] ?? '';

        $startDate = $dateFilter . ' 00:00:00';
        $endDate = $dateFilter . ' 23:59:59';

        if ($dentisteFilter) {
            $rdvs = $this->rvModel->getByDentisteAndDate($dentisteFilter, $startDate, $endDate);
        } else {
            $rdvs = $this->rvModel->getByDateRange($startDate, $endDate);
        }

        $dentistes = $this->medecinModel->findAll();

        $this->view('secretaire.planning', [
            'rendezvous' => $rdvs,
            'dentistes' => $dentistes,
            'dateFilter' => $dateFilter,
            'dentisteFilter' => $dentisteFilter
        ]);
    }

    /**
     * Imprimer le planning du jour
     */
    public function printPlanning()
    {
        Auth::role('secretaire');
        
        $today = date('Y-m-d');
        $todayStart = $today . ' 00:00:00';
        $todayEnd = $today . ' 23:59:59';

        // Récupérer les rendez-vous du jour
        $rdvs = $this->rvModel->getByDateRange($todayStart, $todayEnd);

        // Charger les modèles nécessaires pour les jointures
        $patients = $this->patientModel->findAll();
        $dentistes = $this->medecinModel->findAll();

        // Créer des tableaux indexés pour un accès rapide
        $patientsMap = [];
        foreach ($patients as $p) {
            $patientsMap[$p['id']] = $p;
        }

        $dentistesMap = [];
        foreach ($dentistes as $d) {
            $dentistesMap[$d['id']] = $d;
        }

        $this->view('secretaire.print-planning', [
            'rendezvous' => $rdvs,
            'patientsMap' => $patientsMap,
            'dentistesMap' => $dentistesMap,
            'date' => $today
        ]);
    }

    /**
     * API JSON : dates avec au moins un créneau libre (dentiste + évitement chevauchement pour le patient choisi).
     */
    public function availableBookingDates()
    {
        Auth::role('secretaire');
        header('Content-Type: application/json; charset=utf-8');

        $dentiste_id = isset($_GET['dentiste_id']) ? (int) $_GET['dentiste_id'] : 0;
        $patient_id = isset($_GET['patient_id']) ? (int) $_GET['patient_id'] : 0;
        $duree_minutes = isset($_GET['duree_minutes']) ? (int) $_GET['duree_minutes'] : 30;
        $allowedDuree = [15, 30, 45, 60];
        if (!in_array($duree_minutes, $allowedDuree, true)) {
            $duree_minutes = 30;
        }

        if ($dentiste_id <= 0 || $patient_id <= 0) {
            echo json_encode(['ok' => false, 'error' => 'Patient et dentiste requis']);
            exit;
        }

        if (!$this->medecinModel->getById($dentiste_id)) {
            echo json_encode(['ok' => false, 'error' => 'Dentiste introuvable']);
            exit;
        }

        if (!$this->patientModel->findById($patient_id)) {
            echo json_encode(['ok' => false, 'error' => 'Patient introuvable']);
            exit;
        }

        $dates = $this->rvModel->getPatientBookingDatesWithAvailability($dentiste_id, $patient_id, $duree_minutes, 90);

        echo json_encode(['ok' => true, 'dates' => $dates]);
        exit;
    }

    /**
     * API JSON : heures libres pour une date, un dentiste et un patient donnés.
     */
    public function availableBookingSlots()
    {
        Auth::role('secretaire');
        header('Content-Type: application/json; charset=utf-8');

        $dentiste_id = isset($_GET['dentiste_id']) ? (int) $_GET['dentiste_id'] : 0;
        $patient_id = isset($_GET['patient_id']) ? (int) $_GET['patient_id'] : 0;
        $date = isset($_GET['date']) ? trim($_GET['date']) : '';
        $duree_minutes = isset($_GET['duree_minutes']) ? (int) $_GET['duree_minutes'] : 30;
        $allowedDuree = [15, 30, 45, 60];
        if (!in_array($duree_minutes, $allowedDuree, true)) {
            $duree_minutes = 30;
        }

        if ($dentiste_id <= 0 || $patient_id <= 0 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            echo json_encode(['ok' => false, 'error' => 'Paramètres invalides']);
            exit;
        }

        if (!$this->medecinModel->getById($dentiste_id)) {
            echo json_encode(['ok' => false, 'error' => 'Dentiste introuvable']);
            exit;
        }

        if (!$this->patientModel->findById($patient_id)) {
            echo json_encode(['ok' => false, 'error' => 'Patient introuvable']);
            exit;
        }

        $slots = $this->rvModel->getPatientBookingSlots($dentiste_id, $patient_id, $date, $duree_minutes);

        echo json_encode(['ok' => true, 'slots' => $slots]);
        exit;
    }

    /**
     * API: Récupérer les dentistes par spécialité (AJAX)
     */
    public function getDentistesBySpecialite()
    {
        // Pas de vérification de rôle pour API publique
        header('Content-Type: application/json');
        
        try {
            $type = ConsultationTypeCatalog::normalize($_GET['type'] ?? '');
            $specialite = $type;
            if ($specialite === '') {
                echo json_encode([
                    'success' => false,
                    'error' => 'Type de consultation invalide',
                    'dentistes' => []
                ]);
                exit;
            }

            $dentistes = $this->medecinModel->getBySpecialite($specialite);
            
            echo json_encode([
                'success' => true,
                'dentistes' => $dentistes,
                'specialite' => $specialite,
                'debug' => [
                    'type_requested' => $type,
                    'specialite_mapped' => $specialite,
                    'count' => count($dentistes)
                ]
            ]);
            exit;
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'dentistes' => []
            ]);
            exit;
        }
    }
}
