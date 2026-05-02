<?php

/**
 * PatientController
 * Gère les pages accessibles aux patients
 */

class PatientController extends Controller
{
    /**
     * Affiche le dashboard patient
     * Protégé: seuls les patients connectés peuvent accéder
     */
    public function dashboard()
    {
        // Vérifier que l'utilisateur est connecté et qu'il est patient
        Auth::role('patient');
        
        // Récupérer les infos utilisateur
        $user = Auth::user();
        
        // Récupérer les infos patient
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        
        // Récupérer les 2 prochains rendez-vous
        $nextRendezVous = $patient ? $patientModel->getNextRendezVous($patient['id'], 2) : [];
        
        // Afficher la vue dashboard
        $this->view('patient.dashboard', [
            'user' => $user,
            'patient' => $patient,
            'nextRendezVous' => $nextRendezVous
        ]);
    }
    
    /**
     * Affiche la liste des rendez-vous du patient
     */
    public function rendezVous()
    {
        // Vérifier que l'utilisateur est connecté et qu'il est patient
        Auth::role('patient');
        
        // Récupérer les infos utilisateur
        $user = Auth::user();
        
        // Récupérer les infos patient
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        
        // Récupérer les rendez-vous du patient
        $rendezVousModel = new RendezVous();
        $rendezVous = $rendezVousModel->getByPatientId($patient['id'] ?? 0);
        
        // Afficher la vue
        $this->view('patient.mes_rendezvous', [
            'user' => $user,
            'patient' => $patient,
            'rendezVous' => $rendezVous
        ]);
    }
    
    /**
     * Affiche le formulaire pour créer un rendez-vous
     */
    public function createRendezVous()
    {
        // Vérifier que l'utilisateur est connecté et qu'il est patient
        Auth::role('patient');
        
        // Récupérer les infos utilisateur
        $user = Auth::user();
        
        // Récupérer les infos patient
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        
        // Récupérer la liste des dentistes disponibles
        $medecinModel = new Medecin();
        $dentistes = $medecinModel->getAll();
        
        // Afficher la vue
        $this->view('patient.rendezVous', [
            'user' => $user,
            'patient' => $patient,
            'dentistes' => $dentistes
        ]);
    }
    
    /**
     * Affiche les consultations du patient
     */
    public function consultations()
    {
        // Vérifier que l'utilisateur est connecté et qu'il est patient
        Auth::role('patient');
        
        // Récupérer les infos utilisateur
        $user = Auth::user();
        
        // Récupérer les infos patient
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        
        // Récupérer les consultations du patient
        $consultationModel = new Consultation();
        $consultations = $consultationModel->getByPatientId($patient['id'] ?? 0);

        // Charger les ordonnances liées aux consultations
        $ordonnanceModel = new Ordonnance();
        $ordonnanceMedModel = new OrdonnanceMedicaments();
        foreach ($consultations as &$consultation) {
            $ordonnance = $ordonnanceModel->findByConsultationId($consultation['id']);
            if ($ordonnance) {
                $ordonnance['medicaments'] = $ordonnanceMedModel->getByOrdonnanceId($ordonnance['id']);
            }
            $consultation['ordonnance'] = $ordonnance ?: null;
        }
        unset($consultation);
        
        // Afficher la vue
        $this->view('patient.resultats', [
            'user' => $user,
            'patient' => $patient,
            'consultations' => $consultations
        ]);
    }
    
    /**
     * Affiche le profil du patient
     */
    public function profile()
    {
        // Vérifier que l'utilisateur est connecté et qu'il est patient
        Auth::role('patient');
        
        // Récupérer les infos utilisateur
        $user = Auth::user();
        
        // Récupérer les infos patient
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        
        // Afficher la vue
        $this->view('patient.profil', [
            'user' => $user,
            'patient' => $patient
        ]);
    }
    
    /**
     * Enregistrer un nouveau rendez-vous
     */
    public function storeRendezVous()
    {
        // Vérifier que l'utilisateur est connecté et qu'il est patient
        Auth::role('patient');
        
        // Vérifier que c'est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Erreur de requête';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }
        
        // Récupérer les données
        $dentiste_id = isset($_POST['dentiste_id']) ? (int)$_POST['dentiste_id'] : 0;
        $date = isset($_POST['date']) ? trim($_POST['date']) : '';
        $heure = isset($_POST['heure']) ? trim($_POST['heure']) : '';
        $type_rendez_vous = isset($_POST['type_rendez_vous']) ? trim($_POST['type_rendez_vous']) : '';
        $motif = isset($_POST['motif']) ? trim($_POST['motif']) : '';
        $allowedDuree = [30, 45, 60];
        $duree_minutes = isset($_POST['duree_minutes']) ? (int) $_POST['duree_minutes'] : 30;
        if (!in_array($duree_minutes, $allowedDuree, true)) {
            $duree_minutes = 30;
        }

        // Validation
        if (empty($dentiste_id) || empty($date) || empty($heure) || empty($type_rendez_vous) || empty($motif)) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }
        
        // Récupérer l'ID du patient
        $user = Auth::user();
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        
        if (!$patient) {
            $_SESSION['error'] = 'Erreur: profil patient non trouvé';
            header('Location: index.php?route=/patient/dashboard');
            exit();
        }

        // Vérifier que le dentiste correspond bien au type choisi
        $medecinModel = new Medecin();
        $dentiste = $medecinModel->getById($dentiste_id);
        if (!$dentiste) {
            $_SESSION['error'] = 'Dentiste introuvable.';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }

        if (!$this->dentisteMatchesType($dentiste, $type_rendez_vous)) {
            $_SESSION['error'] = 'Le dentiste sélectionné ne correspond pas au type de consultation.';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }
        
        // Normaliser l'heure (HH:MM)
        $heureTrim = trim($heure);
        $heureObj = DateTime::createFromFormat('H:i', $heureTrim);
        if (!$heureObj) {
            $_SESSION['error'] = 'Heure invalide.';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }
        $heureNorm = $heureObj->format('H:i');

        // Créer la date/heure complète
        $date_heure = $date . ' ' . $heureNorm . ':00';

        $rendezVousModel = new RendezVous();

        // Créneau doit être parmi les créneaux réellement libres (cohérent avec l'API de réservation)
        $slotStarts = $rendezVousModel->getPatientBookingSlots($dentiste_id, $patient['id'], $date, $duree_minutes);
        if (!in_array($heureNorm, $slotStarts, true)) {
            $_SESSION['error'] = 'Ce créneau n\'est plus disponible. Veuillez choisir une autre date ou un autre horaire.';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }

        // VÉRIFICATION ANTI-CONFLIT : vérifier si le patient a déjà un rendez-vous à cette heure
        
        // Vérification simple (même heure exacte)
        $conflict = $rendezVousModel->checkConflict($patient['id'], $date_heure);
        
        if ($conflict) {
            $_SESSION['error'] = 'Vous avez déjà un rendez-vous à cette date et heure. Veuillez choisir un autre créneau.';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }
        
        // VÉRIFICATION ANTI-CONFLIT DENTISTE : vérifier si le dentiste a déjà un rendez-vous à cette heure
        $dentisteConflict = $rendezVousModel->checkDentistConflict($dentiste_id, $date_heure, null, $duree_minutes);
        
        if ($dentisteConflict) {
            $_SESSION['error'] = 'Ce créneau est déjà réservé pour ce dentiste. Veuillez choisir un autre horaire.';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }
        
        // BONUS : Vérification avancée des chevauchements (si durée utilisée)
        $overlap = $rendezVousModel->checkOverlap($patient['id'], $date_heure, $duree_minutes);
        
        if ($overlap) {
            $_SESSION['error'] = 'Ce créneau chevauche avec un de vos rendez-vous existants. Veuillez choisir un autre horaire.';
            header('Location: index.php?route=/patient/rendez-vous/create');
            exit();
        }
        
        // Créer le rendez-vous (pas de conflit détecté)
        $result = $rendezVousModel->create([
            'patient_id' => $patient['id'],
            'dentiste_id' => $dentiste_id,
            'secretaire_id' => null, // Pas de secrétaire assigné
            'date_heure' => $date_heure,
            'duree_minutes' => $duree_minutes,
            'motif' => $motif,
            'type_rendez_vous' => $type_rendez_vous
        ]);
        
        if ($result) {
            $_SESSION['success'] = 'Rendez-vous créé avec succès !';
            header('Location: index.php?route=/patient/rendez-vous');
        } else {
            $_SESSION['error'] = 'Erreur lors de la création du rendez-vous';
            header('Location: index.php?route=/patient/rendez-vous/create');
        }
        exit();
    }

    /**
     * Vérifie que le dentiste choisi correspond au type de rendez-vous
     */
    private function dentisteMatchesType($dentiste, $type_rendez_vous)
    {
        $specialite = strtolower(trim($dentiste['specialite'] ?? ''));
        $type = strtolower(trim($type_rendez_vous));

        if ($type === 'consultation' || $type === 'autre' || $specialite === '') {
            return true;
        }

        $keywords = [];
        switch ($type) {
            case 'nettoyage':
                $keywords = ['nettoyage', 'hygiene', 'hygiène', 'prophylaxie'];
                break;
            case 'extraction':
                $keywords = ['extraction', 'chirurgie', 'orale'];
                break;
            case 'traitement':
                $keywords = ['traitement', 'endodontie', 'restauration'];
                break;
            case 'blanchiment':
                $keywords = ['blanchiment', 'esthétique', 'esthetique', 'cosmétique', 'cosmetique'];
                break;
            case 'radio':
                $keywords = ['radio', 'imagerie', 'radiologie'];
                break;
            default:
                return true;
        }

        foreach ($keywords as $keyword) {
            if (strpos($specialite, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * API JSON : dates ayant au moins un créneau libre (dentiste + évitement chevauchement patient).
     */
    public function availableBookingDates()
    {
        Auth::role('patient');
        header('Content-Type: application/json; charset=utf-8');

        $dentiste_id = isset($_GET['dentiste_id']) ? (int) $_GET['dentiste_id'] : 0;
        $duree_minutes = isset($_GET['duree_minutes']) ? (int) $_GET['duree_minutes'] : 30;
        $allowedDuree = [30, 45, 60];
        if (!in_array($duree_minutes, $allowedDuree, true)) {
            $duree_minutes = 30;
        }

        if ($dentiste_id <= 0) {
            echo json_encode(['ok' => false, 'error' => 'Dentiste requis']);
            exit();
        }

        $medecinModel = new Medecin();
        if (!$medecinModel->getById($dentiste_id)) {
            echo json_encode(['ok' => false, 'error' => 'Dentiste introuvable']);
            exit();
        }

        $user = Auth::user();
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        if (!$patient) {
            echo json_encode(['ok' => false, 'error' => 'Patient introuvable']);
            exit();
        }

        $model = new RendezVous();
        $dates = $model->getPatientBookingDatesWithAvailability($dentiste_id, (int) $patient['id'], $duree_minutes, 90);

        echo json_encode(['ok' => true, 'dates' => $dates]);
        exit();
    }

    /**
     * API JSON : heures libres pour une date et un dentiste donnés.
     */
    public function availableBookingSlots()
    {
        Auth::role('patient');
        header('Content-Type: application/json; charset=utf-8');

        $dentiste_id = isset($_GET['dentiste_id']) ? (int) $_GET['dentiste_id'] : 0;
        $date = isset($_GET['date']) ? trim($_GET['date']) : '';
        $duree_minutes = isset($_GET['duree_minutes']) ? (int) $_GET['duree_minutes'] : 30;
        $allowedDuree = [30, 45, 60];
        if (!in_array($duree_minutes, $allowedDuree, true)) {
            $duree_minutes = 30;
        }

        if ($dentiste_id <= 0 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            echo json_encode(['ok' => false, 'error' => 'Paramètres invalides']);
            exit();
        }

        $medecinModel = new Medecin();
        if (!$medecinModel->getById($dentiste_id)) {
            echo json_encode(['ok' => false, 'error' => 'Dentiste introuvable']);
            exit();
        }

        $user = Auth::user();
        $patientModel = new Patient();
        $patient = $patientModel->findByUserId($user['id']);
        if (!$patient) {
            echo json_encode(['ok' => false, 'error' => 'Patient introuvable']);
            exit();
        }

        $model = new RendezVous();
        $slots = $model->getPatientBookingSlots($dentiste_id, (int) $patient['id'], $date, $duree_minutes);

        echo json_encode(['ok' => true, 'slots' => $slots]);
        exit();
    }
}
