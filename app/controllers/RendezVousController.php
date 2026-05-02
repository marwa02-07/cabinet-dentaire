<?php

/**
 * RendezVousController
 * Gère les rendez-vous et les consultations côté médecin
 */

class RendezVousController extends Controller
{
    /**
     * Affiche la liste des rendez-vous du médecin connecté
     */
    public function index()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);

        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $rendezVousModel = new RendezVous();
        $rendezVous = $rendezVousModel->getByMedecinId($medecin['id']);

        $this->view('medecin.rendez_vous', [
            'user' => $user,
            'medecin' => $medecin,
            'rendezVous' => $rendezVous
        ]);
    }

    /**
     * Affiche les détails d'un patient pour le médecin
     */
    public function patientDetail()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $patient_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$patient_id) {
            die("✗ Erreur : patient invalide.");
        }

        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);
        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $rendezVousModel = new RendezVous();
        if (!$rendezVousModel->existsForMedecinPatient($medecin['id'], $patient_id)) {
            die("✗ Accès refusé : patient non associé à ce médecin.");
        }

        $patientModel = new Patient();
        $patient = $patientModel->findById($patient_id);
        if (!$patient) {
            die("✗ Erreur : patient introuvable.");
        }

        $patientRendezVous = $patientModel->getRendezVous($patient_id);

        $this->view('medecin.patient', [
            'user' => $user,
            'medecin' => $medecin,
            'patient' => $patient,
            'patientRendezVous' => $patientRendezVous
        ]);
    }

    /**
     * Affiche le formulaire de création de consultation
     */
    public function createConsultation()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $rendez_vous_id = isset($_GET['rendez_vous_id']) ? (int)$_GET['rendez_vous_id'] : 0;
        if (!$rendez_vous_id) {
            die("✗ Erreur : rendez-vous invalide.");
        }

        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);
        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $rendezVousModel = new RendezVous();
        $rendezVous = $rendezVousModel->getById($rendez_vous_id);
        if (!$rendezVous || $rendezVous['dentiste_id'] !== $medecin['id']) {
            die("✗ Erreur : rendez-vous introuvable ou accès refusé.");
        }

        $patientModel = new Patient();
        $patient = $patientModel->findById($rendezVous['patient_id']);

        $this->view('medecin.consultation_create', [
            'user' => $user,
            'medecin' => $medecin,
            'rendezVous' => $rendezVous,
            'patient' => $patient
        ]);
    }

    /**
     * Enregistre une nouvelle consultation
     */
    public function storeConsultation()
    {
        Auth::role('medecin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Méthode invalide.';
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        }

        $rendez_vous_id = isset($_POST['rendez_vous_id']) ? (int)$_POST['rendez_vous_id'] : 0;
        $diagnostic = trim($_POST['diagnostic'] ?? '');
        $traitement_effectue = trim($_POST['traitement_effectue'] ?? '');
        $traitement_prevu = trim($_POST['traitement_prevu'] ?? '');
        $dents_traitees = trim($_POST['dents_traitees'] ?? '');
        $prix = trim($_POST['prix'] ?? '0');
        $notes = trim($_POST['notes'] ?? '');

        if (!$rendez_vous_id || empty($diagnostic) || empty($traitement_effectue) || empty($traitement_prevu) || empty($dents_traitees)) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires de la consultation.';
            header('Location: index.php?route=/medecin/consultation/create&rendez_vous_id=' . $rendez_vous_id);
            exit();
        }

        $prix = is_numeric($prix) ? number_format((float)$prix, 2, '.', '') : '0.00';

        $user = Auth::user();
        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);
        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $rendezVousModel = new RendezVous();
        $rendezVous = $rendezVousModel->getById($rendez_vous_id);
        if (!$rendezVous || $rendezVous['dentiste_id'] !== $medecin['id']) {
            die("✗ Erreur : rendez-vous introuvable ou accès refusé.");
        }

        $consultationModel = new Consultation();
        $consultationId = $consultationModel->create([
            'rendez_vous_id' => $rendez_vous_id,
            'dentiste_id' => $medecin['id'],
            'patient_id' => $rendezVous['patient_id'],
            'diagnostic' => $diagnostic,
            'traitement_effectue' => $traitement_effectue,
            'traitement_prevu' => $traitement_prevu,
            'dents_traitees' => $dents_traitees,
            'prix' => $prix,
            'notes' => $notes
        ]);

        if ($consultationId) {
            $rendezVousModel->updateStatus($rendez_vous_id, 'complété');
            $_SESSION['success'] = 'Consultation enregistrée avec succès.';
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        }

        $_SESSION['error'] = 'Erreur lors de l’enregistrement de la consultation.';
        header('Location: index.php?route=/medecin/consultation/create&rendez_vous_id=' . $rendez_vous_id);
        exit();
    }

    /**
     * Met à jour le statut d'un rendez-vous
     */
    public function updateStatus()
    {
        Auth::role('medecin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Méthode invalide.';
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        }

        $rendez_vous_id = isset($_POST['rendez_vous_id']) ? (int)$_POST['rendez_vous_id'] : 0;
        $status = trim($_POST['status'] ?? '');
        $allowed = ['confirmé', 'complété', 'annulé'];

        error_log("=== updateStatus DEBUG ===");
        error_log("rendez_vous_id: " . $rendez_vous_id);
        error_log("status reçu: " . $status);
        error_log("POST data: " . print_r($_POST, true));

        if (!$rendez_vous_id || !in_array($status, $allowed, true)) {
            $_SESSION['error'] = 'Statut invalide. ID: ' . $rendez_vous_id . ', Status: ' . $status;
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        }

        $user = Auth::user();
        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);
        
        error_log("medecin trouvé: " . print_r($medecin, true));
        
        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $rendezVousModel = new RendezVous();
        $rendezVous = $rendezVousModel->getById($rendez_vous_id);

        error_log("rendez-vous trouvé: " . print_r($rendezVous, true));

        if (!$rendezVous || $rendezVous['dentiste_id'] !== $medecin['id']) {
            $_SESSION['error'] = 'Rendez-vous introuvable ou accès refusé.';
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        }

        $result = $rendezVousModel->updateStatus($rendez_vous_id, $status);
        error_log("Résultat updateStatus: " . ($result ? 'SUCCESS' : 'FAILED'));

        // Créer automatiquement une consultation quand le statut est "complété"
        if ($result && $status === 'complété') {
            $this->createAutoConsultation($rendezVous, $medecin);
        }

        if ($result) {
            $_SESSION['success'] = 'Statut mis à jour: ' . $status;
        } else {
            $_SESSION['error'] = 'Impossible de mettre à jour le statut.';
        }

        header('Location: index.php?route=/medecin/rendez-vous');
        exit();
    }

    /**
     * Crée automatiquement une consultation lors de la complétion d'un rendez-vous
     */
    private function createAutoConsultation($rendezVous, $medecin)
    {
        // Récupérer l'ID du rendez-vous (gère les deux formats de clé)
        $rdvId = $rendezVous['rdv_id'] ?? $rendezVous['id'] ?? 0;
        
        if (!$rdvId) {
            error_log("Erreur: ID du rendez-vous introuvable");
            return false;
        }

        // Vérifier si une consultation existe déjà pour ce rendez-vous
        $consultationModel = new Consultation();
        $existing = $consultationModel->getByRendezVousId($rdvId);
        
        if ($existing) {
            error_log("Consultation déjà existante pour ce rendez-vous: " . $existing['id']);
            return $existing['id'];
        }

        // Récupérer l'ID du patient (gère les deux formats de clé)
        $patientId = $rendezVous['rdv_patient_id'] ?? $rendezVous['patient_id'] ?? 0;
        
        if (!$patientId) {
            error_log("Erreur: ID du patient introuvable");
            return false;
        }

        // Créer une consultation par défaut
        $consultationData = [
            'rendez_vous_id' => $rdvId,
            'dentiste_id' => $medecin['id'],
            'patient_id' => $patientId,
            'diagnostic' => 'Consultation terminée - ' . ($rendezVous['motif'] ?? 'Rendez-vous'),
            'traitement_effectue' => 'Traitement effectué lors du rendez-vous',
            'traitement_prevu' => 'Aucun traitement prévu',
            'dents_traitees' => 'N/A',
            'prix' => '0.00',
            'notes' => 'Consultation créée automatiquement lors de la complétion du rendez-vous'
        ];

        $consultationId = $consultationModel->create($consultationData);
        error_log("Consultation auto-créée ID: " . $consultationId);
        return $consultationId;
    }
}
