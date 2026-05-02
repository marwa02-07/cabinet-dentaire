<?php

/**
 * MedecinController
 * Gère les pages accessibles aux médecins
 */

class MedecinController extends Controller
{
    /**
     * Affiche le dashboard médecin
     * Protégé: seuls les médecins connectés peuvent accéder
     */
    public function dashboard()
    {
        // Vérifier que l'utilisateur est connecté et qu'il est médecin
        Auth::role('medecin');
        
        // Récupérer les infos utilisateur
        $user = Auth::user();

        // Préparer les modèles nécessaires
        $medecinModel = new Medecin();
        $rvModel = new RendezVous();
        $consultModel = new Consultation();

        // retrouver l'identifiant du médecin (table medecins)
        $medecin = $medecinModel->findByUserId($user['id']);
        $medecin_id = $medecin ? $medecin['id'] : null;

        // définir la période de la semaine en cours
        $startWeek = date('Y-m-d 00:00:00', strtotime('monday this week'));
        $endWeek   = date('Y-m-d 23:59:59', strtotime('sunday this week'));

        // calcul des statistiques
        $stats = [
            'appointments_week' => $medecin_id ? $rvModel->countByMedecinBetween($medecin_id, $startWeek, $endWeek) : 0,
            'appointments_total' => $medecin_id ? $rvModel->countByMedecin($medecin_id) : 0,
            'patients'          => $medecin_id ? $rvModel->countDistinctPatientsByMedecin($medecin_id) : 0,
            'consultations_week'=> $medecin_id ? $consultModel->countThisWeekByMedecin($medecin_id, $startWeek, $endWeek) : 0,
        ];

        // Récupérer les 2 prochains rendez-vous
        $nextRendezVous = $medecin_id ? $medecinModel->getNextRendezVous($medecin_id, 2) : [];

        // Afficher la vue dashboard
        $this->view('medecin.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'medecin' => $medecin,
            'nextRendezVous' => $nextRendezVous
        ]);
    }

    /**
     * Affiche la liste des rendez-vous du médecin connecté
     */
    public function rendezVous()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);

        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $rendezVous = $medecinModel->getRendezVous($medecin['id']);

        $this->view('medecin.rendez_vous', [
            'user' => $user,
            'medecin' => $medecin,
            'rendezVous' => $rendezVous
        ]);
    }

    /**
     * Affiche les détails du patient pour le médecin
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
     * Affiche la page de sélection du patient et rendez-vous pour une consultation
     */
    public function selectConsultation()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);

        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        // Récupérer tous les rendez-vous du médecin (non annulés)
        $rendezVousModel = new RendezVous();
        $rendezVous = $rendezVousModel->getByMedecinId($medecin['id']);

        $this->view('medecin.select-consultation', [
            'user' => $user,
            'medecin' => $medecin,
            'rendezVous' => $rendezVous
        ]);
    }

    /**
     * Affiche la page de sélection du patient et du rendez-vous pour rédiger une ordonnance
     */
    public function selectOrdonnance()
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

        $this->view('medecin.ordonnance_select', [
            'user' => $user,
            'medecin' => $medecin,
            'rendezVous' => $rendezVous
        ]);
    }

    /**
     * Affiche le formulaire de création d'une ordonnance pour un rendez-vous
     */
    public function createOrdonnance()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $rendez_vous_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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

        // Récupérer la dernière consultation du patient pour liaison automatique
        $consultationModel = new Consultation();
        $consultation = $consultationModel->getLastByPatientId($rendezVous['patient_id']);

        $this->view('medecin.ordonnance_create', [
            'user' => $user,
            'medecin' => $medecin,
            'rendezVous' => $rendezVous,
            'patient' => $patient,
            'consultation' => $consultation,
            'date_creation' => date('Y-m-d')
        ]);
    }

    /**
     * Enregistre une nouvelle ordonnance
     */
    public function storeOrdonnance()
    {
        Auth::role('medecin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Méthode invalide.';
            header('Location: index.php?route=/medecin/ordonnance/select');
            exit();
        }

        $rendez_vous_id = isset($_POST['rendez_vous_id']) ? (int)$_POST['rendez_vous_id'] : 0;
        $patient_id = isset($_POST['patient_id']) ? (int)$_POST['patient_id'] : 0;
        $consultation_id = isset($_POST['consultation_id']) ? (int)$_POST['consultation_id'] : 0;
        $date_creation = trim($_POST['date_creation'] ?? '');
        $posologie = trim($_POST['posologie'] ?? '');
        $instructions = trim($_POST['instructions'] ?? '');
        $medicaments = $_POST['medicaments'] ?? [];

        if (!$rendez_vous_id || !$patient_id || empty($date_creation)) {
            $_SESSION['error'] = 'Veuillez renseigner la date de création de l’ordonnance.';
            header('Location: index.php?route=/medecin/ordonnance/select');
            exit();
        }

        if (empty($medicaments) || !is_array($medicaments)) {
            $_SESSION['error'] = 'Veuillez ajouter au moins un médicament valide.';
            header('Location: index.php?route=/medecin/ordonnance/select');
            exit();
        }

        if (empty($posologie)) {
            $_SESSION['error'] = 'La posologie est requise pour l’ordonnance.';
            header('Location: index.php?route=/medecin/ordonnance/select');
            exit();
        }

        $validMedicaments = [];
        foreach ($medicaments as $medicament) {
            $nom = trim($medicament['nom_medicament'] ?? '');
            $dosage = trim($medicament['dosage'] ?? '');
            $frequence = trim($medicament['frequence'] ?? '');
            if (empty($nom) || empty($dosage) || empty($frequence)) {
                continue;
            }
            $validMedicaments[] = [
                'nom_medicament' => $nom,
                'dosage' => $dosage,
                'frequence' => $frequence,
                'duree' => trim($medicament['duree'] ?? ''),
                'instructions_medicament' => trim($medicament['instructions_medicament'] ?? '')
            ];
        }

        if (empty($validMedicaments)) {
            $_SESSION['error'] = 'Veuillez renseigner nom, dosage et fréquence pour chaque médicament.';
            header('Location: index.php?route=/medecin/ordonnance/select');
            exit();
        }

        $db = new Database();
        $pdo = $db->getPdo();

        $ordonnanceModel = new Ordonnance();
        $ordonnanceMedModel = new OrdonnanceMedicaments();
        $medecinModel = new Medecin();
        $consultationModel = new Consultation();

        $ordonnanceModel->setPdo($pdo);
        $ordonnanceMedModel->setPdo($pdo);
        $medecinModel->setPdo($pdo);
        $consultationModel->setPdo($pdo);

        try {
            $pdo->beginTransaction();

            $user = Auth::user();
            $medecin = $medecinModel->findByUserId($user['id']);
            if (!$medecin) {
                throw new Exception('Profil médecin introuvable.');
            }

            // Logique de liaison automatique à la consultation
            $linkedConsultationId = $consultation_id;
            $linkMessage = '';
            
            if (!$linkedConsultationId) {
                // Pas de consultation_id fourni → chercher la dernière consultation du patient
                $lastConsultation = $consultationModel->getLastByPatientId($patient_id);
                if ($lastConsultation) {
                    $linkedConsultationId = $lastConsultation['id'];
                    $linkMessage = ' (liée automatiquement à la dernière consultation)';
                }
            }

            $ordonnanceId = $ordonnanceModel->create([
                'patient_id' => $patient_id,
                'dentiste_id' => $medecin['id'],
                'rendez_vous_id' => $rendez_vous_id,
                'consultation_id' => $linkedConsultationId ?: null,
                'date_creation' => $date_creation,
                'instructions' => $instructions,
                'recommandations' => $posologie,
            ]);

            if (!$ordonnanceId) {
                throw new Exception('Échec de la création de l’ordonnance.');
            }

            if (!$ordonnanceMedModel->createMany($ordonnanceId, $validMedicaments)) {
                throw new Exception('Échec de l’enregistrement des médicaments de l’ordonnance.');
            }

            $pdo->commit();
            $_SESSION['success'] = 'Ordonnance enregistrée avec succès.' . $linkMessage;
            header('Location: index.php?route=/medecin/ordonnance/select');
            exit();
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Médecin storeOrdonnance erreur: ' . $e->getMessage());
            $_SESSION['error'] = 'Erreur lors de l’enregistrement de l’ordonnance : ' . $e->getMessage();
            header('Location: index.php?route=/medecin/ordonnance/select');
            exit();
        }
    }

    /**
     * Affiche le formulaire de création de consultation pour un rendez-vous
     */
    public function createConsultation()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $rendez_vous_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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
     * Enregistre une consultation créée par le médecin
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
        // medicaments peut être un tableau (nouveau format) ou une chaîne (ancien format)
        $medicamentsInput = $_POST['medicaments'] ?? '';
        $medicaments = is_array($medicamentsInput) ? $medicamentsInput : trim($medicamentsInput);
        $posologie = is_array($_POST['posologie'] ?? '') ? trim($_POST['posologie'] ?? '') : trim($_POST['posologie'] ?? '');
        $instructions = is_array($_POST['instructions'] ?? '') ? trim($_POST['instructions'] ?? '') : trim($_POST['instructions'] ?? '');

        if (!$rendez_vous_id || empty($diagnostic) || empty($traitement_effectue) || empty($dents_traitees)) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires de la consultation.';
            header('Location: index.php?route=/medecin/consultation/create/' . $rendez_vous_id);
            exit();
        }

        // Vérifier si des médicaments sont présents (tableau ou chaîne)
        $hasMedicamentsArray = is_array($medicaments) && count(array_filter($medicaments, function($m) {
            return !empty(trim($m['nom_medicament'] ?? ''));
        })) > 0;
        $hasMedicamentsString = is_string($medicaments) && !empty(trim($medicaments));
        
        if (($hasMedicamentsArray || $hasMedicamentsString) && empty($posologie)) {
            $_SESSION['error'] = 'La posologie est requise lorsque vous ajoutez une ordonnance.';
            header('Location: index.php?route=/medecin/consultation/create/' . $rendez_vous_id);
            exit();
        }

        if (!empty($posologie) && !$hasMedicamentsArray && !$hasMedicamentsString) {
            $_SESSION['error'] = 'Veuillez ajouter au moins un médicament pour l’ordonnance.';
            header('Location: index.php?route=/medecin/consultation/create/' . $rendez_vous_id);
            exit();
        }

        $db = new Database();
        $pdo = $db->getPdo();

        $consultationModel = new Consultation();
        $rendezVousModel = new RendezVous();
        $ordonnanceModel = new Ordonnance();
        $ordonnanceMedModel = new OrdonnanceMedicaments();
        $medecinModel = new Medecin();

        $consultationModel->setPdo($pdo);
        $rendezVousModel->setPdo($pdo);
        $ordonnanceModel->setPdo($pdo);
        $ordonnanceMedModel->setPdo($pdo);
        $medecinModel->setPdo($pdo);

        try {
            $pdo->beginTransaction();

            $user = Auth::user();
            $medecin = $medecinModel->findByUserId($user['id']);
            if (!$medecin) {
                throw new Exception('Profil médecin introuvable.');
            }

            $rendezVous = $rendezVousModel->getById($rendez_vous_id);
            if (!$rendezVous || $rendezVous['dentiste_id'] !== $medecin['id']) {
                throw new Exception('Rendez-vous introuvable ou accès refusé.');
            }

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

            // ========== LOGS DÉTAILLÉS ==========
            error_log("╔════════════════════════════════════════════════╗");
            error_log("║ 🔵 BACKEND: Après création consultation         ║");
            error_log("╚════════════════════════════════════════════════╝");
            error_log("► consultationId brut: " . var_export($consultationId, true));
            error_log("► Type: " . gettype($consultationId));
            error_log("► is_numeric: " . (is_numeric($consultationId) ? 'OUI' : 'NON'));
            error_log("► intval: " . intval($consultationId));
            error_log("► !empty: " . (!empty($consultationId) ? 'OUI' : 'NON'));

            if (!$consultationId || !is_numeric($consultationId) || intval($consultationId) <= 0) {
                error_log("╔════════════════════════════════════════════════╗");
                error_log("║ ❌ ERREUR: consultationId invalide             ║");
                error_log("╚════════════════════════════════════════════════╝");
                throw new Exception('La consultation n\'a pas pu être créée ou ID invalide.');
            }
            
            // Forcer en entier
            $consultationId = intval($consultationId);
            error_log("► consultationId converti: " . $consultationId);

            // ========== DEBUG: Vérifier le type et la valeur ==========
            error_log("========================================");
            error_log("STEP 1: Création consultation... OK");
            error_log("Réponse consultation ID: " . var_export($consultationId, true));
            error_log("Type: " . gettype($consultationId));
            error_log("Valeur entière: " . intval($consultationId));
            error_log("========================================");

            $ordonnanceCreated = false;
            // Vérifier si des médicaments sont présents (tableau ou chaîne)
            $hasMedicamentsArray = is_array($medicaments) && count(array_filter($medicaments, function($m) {
                return !empty(trim($m['nom_medicament'] ?? ''));
            })) > 0;
            $hasMedicamentsString = is_string($medicaments) && !empty(trim($medicaments));
            $hasOrdonnanceData = !empty($posologie) || !empty($instructions);

            if ($hasOrdonnanceData || $hasMedicamentsArray || $hasMedicamentsString) {
                // 🔴 VALIDATION STRICTE: Vérifier que consultation_id est valide AVANT de créer l'ordonnance
                if (!$consultationId || !is_numeric($consultationId) || $consultationId <= 0) {
                    error_log("=== ERREUR: consultation_id invalide ===");
                    error_log("consultationId = " . var_export($consultationId, true));
                    throw new Exception('consultation_id manquant ou invalide. L\'ordonnance ne peut pas être créée.');
                }

                // Validation des champs ordonnance
                if ($hasMedicamentsArray && empty($posologie)) {
                    throw new Exception('La posologie est requise lorsqu\'un médicament est ajouté.');
                }
                
                // ========== STEP 2 & 3: Création ordonnance avec ID ==========
                error_log("========================================");
                error_log("STEP 2: consultation_id = " . $consultationId);
                error_log("STEP 3: Création ordonnance avec ID...");
                error_log("========================================");

                $ordonnanceData = [
                    'patient_id' => $rendezVous['patient_id'],
                    'dentiste_id' => $medecin['id'],
                    'rendez_vous_id' => $rendez_vous_id,
                    'consultation_id' => $consultationId,
                    'date_creation' => date('Y-m-d'),
                    'instructions' => $instructions,
                    'recommandations' => $posologie,
                ];

                error_log("Payload ordonnance: " . json_encode($ordonnanceData));

                $ordonnanceId = $ordonnanceModel->create($ordonnanceData);
                if (!$ordonnanceId) {
                    error_log("Échec création ordonnance - données: " . json_encode($ordonnanceData));
                    throw new Exception('Échec de la création de l\'ordonnance. consultation_id=' . $consultationId);
                }

                error_log("Ordonnance créée avec ID: " . $ordonnanceId);

                // Traiter les médicaments (tableau structuré ou chaîne simple)
                $medicamentsToSave = [];
                if ($hasMedicamentsArray) {
                    // Nouveau format: tableau structuré
                    foreach ($medicaments as $med) {
                        $nom = trim($med['nom_medicament'] ?? '');
                        if (empty($nom)) continue;
                        $medicamentsToSave[] = [
                            'nom_medicament' => $nom,
                            'dosage' => trim($med['dosage'] ?? '') ?: 'Non précisé',
                            'frequence' => trim($med['frequence'] ?? '') ?: 'Non précisé',
                            'duree' => trim($med['duree'] ?? '') ?: null,
                            'instructions_medicament' => trim($med['instructions_medicament'] ?? '') ?: null
                        ];
                    }
                } elseif ($hasMedicamentsString) {
                    // Ancien format: une ligne par médicament
                    $medicamentLines = array_filter(array_map('trim', preg_split('/\r?\n/', $medicaments)));
                    foreach ($medicamentLines as $line) {
                        if (empty($line)) continue;
                        $medicamentsToSave[] = [
                            'nom_medicament' => $line,
                            'dosage' => 'Non précisé',
                            'frequence' => 'Non précisé',
                            'duree' => null,
                            'instructions_medicament' => null
                        ];
                    }
                }

                if (!empty($medicamentsToSave)) {
                    $saved = $ordonnanceMedModel->createMany($ordonnanceId, $medicamentsToSave);
                    if (!$saved) {
                        throw new Exception('Impossible d’enregistrer les médicaments de l’ordonnance.');
                    }
                }

                $ordonnanceCreated = true;
            }

            $updated = $rendezVousModel->updateStatus($rendez_vous_id, 'complété');
            if (!$updated) {
                throw new Exception('Impossible de mettre à jour le statut du rendez-vous.');
            }

            $pdo->commit();

            $_SESSION['success'] = 'Consultation enregistrée avec succès.';
            if ($ordonnanceCreated) {
                $_SESSION['success'] .= ' Ordonnance rattachée.';
            }
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('=== ERREUR storeConsultation ===');
            error_log('Message: ' . $e->getMessage());
            error_log('Trace: ' . $e->getTraceAsString());
            
            $errorMsg = $e->getMessage();
            if (strpos($errorMsg, 'consultation_id') !== false) {
                $_SESSION['error'] = 'Erreur: consultation_id manquant ou invalide.';
            } elseif (strpos($errorMsg, 'ordonnance') !== false) {
                $_SESSION['error'] = 'Erreur lors de la création de l\'ordonnance: ' . $errorMsg;
            } else {
                $_SESSION['error'] = 'Erreur lors de l\'enregistrement: ' . $errorMsg;
            }
            header('Location: index.php?route=/medecin/consultation/create/' . $rendez_vous_id);
            exit();
        }
    }

    /**
     * Met à jour le statut d'un rendez-vous (complété / annulé)
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

        if (!$rendez_vous_id || !in_array($status, $allowed, true)) {
            $_SESSION['error'] = 'Statut invalide.';
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        }

        $user = Auth::user();
        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);

        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $rendezVousModel = new RendezVous();
        $rendezVous = $rendezVousModel->getById($rendez_vous_id);

        if (!$rendezVous || $rendezVous['dentiste_id'] !== $medecin['id']) {
            $_SESSION['error'] = 'Rendez-vous introuvable ou accès refusé.';
            header('Location: index.php?route=/medecin/rendez-vous');
            exit();
        }

        if ($rendezVousModel->updateStatus($rendez_vous_id, $status)) {
            $_SESSION['success'] = 'Statut mis à jour avec succès.';
        } else {
            $_SESSION['error'] = 'Impossible de mettre à jour le statut.';
        }

        header('Location: index.php?route=/medecin/rendez-vous');
        exit();
    }

    /**
     * Affiche le profil du médecin connecté
     */
    public function profile()
    {
        Auth::role('medecin');
        $user = Auth::user();

        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);

        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        $this->view('medecin.profile', [
            'user' => $user,
            'medecin' => $medecin
        ]);
    }

    /**
     * Met à jour le profil du médecin
     */
    public function updateProfile()
    {
        Auth::role('medecin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Méthode invalide.';
            header('Location: index.php?route=/medecin/profile');
            exit();
        }

        $user = Auth::user();
        $medecinModel = new Medecin();
        $medecin = $medecinModel->findByUserId($user['id']);

        if (!$medecin) {
            die("✗ Erreur : profil médecin introuvable.");
        }

        // Mise à jour des données utilisateur
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $specialite = trim($_POST['specialite'] ?? '');
        $numero_licence = trim($_POST['numero_licence'] ?? '');
        $cabinet = trim($_POST['cabinet'] ?? '');

        if (empty($nom) || empty($prenom) || empty($email)) {
            $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires.';
            header('Location: index.php?route=/medecin/profile');
            exit();
        }

        // Vérifier si l'email est déjà utilisé par un autre utilisateur
        $userModel = new User();
        $existingUser = $userModel->findByEmail($email);
        if ($existingUser && $existingUser['id'] !== $user['id']) {
            $_SESSION['error'] = 'Cet email est déjà utilisé.';
            header('Location: index.php?route=/medecin/profile');
            exit();
        }

        // Mettre à jour la table users
        $userModel->update($user['id'], [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email
        ]);

        // Mettre à jour la table dentistes
        $medecinModel->update($medecin['id'], [
            'specialite' => $specialite,
            'numero_licence' => $numero_licence,
            'telephone' => $telephone,
            'cabinet' => $cabinet
        ]);

        $_SESSION['success'] = 'Profil mis à jour avec succès.';
        header('Location: index.php?route=/medecin/profile');
        exit();
    }
}
