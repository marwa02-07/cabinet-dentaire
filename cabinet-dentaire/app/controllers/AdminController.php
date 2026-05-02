<?php

/**
 * AdminController
 * Gère les fonctionnalités de l'administrateur
 */

class AdminController extends Controller
{
    private $userModel;
    private $medecinModel;
    private $secretaireModel;
    private $patientModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->medecinModel = new Medecin();
        $this->secretaireModel = new Secretaire();
        $this->patientModel = new Patient();
    }

    /**
     * Vérifie si l'utilisateur est un admin
     */
    private function checkAdminAccess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['login_error'] = 'Accès refusé. Vous devez être administrateur.';
            header('Location: index.php?route=/login');
            exit();
        }
    }

    /**
     * Affiche le dashboard administrateur
     */
    public function dashboard()
    {
        $this->checkAdminAccess();

        // Statistiques
        $stats = [
            'total_users' => count($this->userModel->findAll()),
            'total_medecins' => count($this->medecinModel->findAll()),
            'total_secretaires' => count($this->secretaireModel->findAll()),
            'total_patients' => count($this->patientModel->findAll())
        ];

        $this->view('admin.dashboard', [
            'stats' => $stats
        ]);
    }

    /**
     * Affiche la liste des médecins
     */
    public function medecins()
    {
        $this->checkAdminAccess();

        $medecins = $this->medecinModel->findAll();
        $this->view('admin.medecins', [
            'medecins' => $medecins
        ]);
    }

    /**
     * Enregistre un nouveau médecin (POST handler)
     */
    public function storeMedecin()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $specialite = $_POST['specialite'] ?? '';
            $numero_licence = $_POST['numero_licence'] ?? '';
            $cabinet = $_POST['cabinet'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Validation
            if (empty($nom) || empty($prenom) || empty($email) || empty($specialite) || empty($numero_licence) || empty($password)) {
                $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            if ($password !== $password_confirm) {
                $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Le mot de passe doit contenir au moins 6 caractères';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Adresse email invalide';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            // Vérifier si l'email existe déjà
            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser) {
                $_SESSION['error'] = 'Cet email est déjà utilisé';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            // Vérifier si le numéro de licence existe déjà
            $existingMedecin = $this->medecinModel->findByNumeroLicence($numero_licence);
            if ($existingMedecin) {
                $_SESSION['error'] = 'Ce numéro de licence est déjà utilisé';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            // Créer l'utilisateur
            $userId = $this->userModel->create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'dentiste'
            ]);

            if ($userId) {
                // Créer le médecin
                $medecinData = [
                    'user_id' => $userId,
                    'specialite' => $specialite,
                    'numero_licence' => $numero_licence,
                    'telephone' => $telephone,
                    'cabinet' => $cabinet
                ];

                $medecinId = $this->medecinModel->create($medecinData);
                if ($medecinId) {
                    $_SESSION['success'] = 'Médecin créé avec succès';
                } else {
                    // Supprimer l'utilisateur créé si la création du médecin échoue
                    $this->userModel->delete($userId);
                    $_SESSION['error'] = 'Erreur lors de la création du profil médecin';
                }
            } else {
                $_SESSION['error'] = 'Erreur lors de la création du compte utilisateur';
            }

            header('Location: index.php?route=/admin/medecins');
            exit();
        }

        header('Location: index.php?route=/admin/medecins');
        exit();
    }

    /**
     * Affiche la liste des secrétaires
     */
    public function secretaires()
    {
        $this->checkAdminAccess();

        $secretaires = $this->secretaireModel->findAll();
        $this->view('admin.secretaires', [
            'secretaires' => $secretaires
        ]);
    }

    /**
     * Affiche la liste des patients
     */
    public function patients()
    {
        $this->checkAdminAccess();

        $patients = $this->patientModel->findAll();
        $this->view('admin.patients', [
            'patients' => $patients
        ]);
    }

    /**
     * Affiche le formulaire d'ajout d'un patient
     */
    public function registerPatient()
    {
        $this->checkAdminAccess();
        $this->view('admin.register-patient');
    }

    /**
     * Enregistre un nouveau patient (POST handler)
     */
    public function storePatient()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $date_naissance = $_POST['date_naissance'] ?? null;
            $age = $_POST['age'] ?? null;
            $adresse = $_POST['adresse'] ?? '';
            $allergies = $_POST['allergies'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validation
            if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Veuillez remplir tous les champs obligatoires';
                header('Location: index.php?route=/register-patient');
                exit();
            }

            // Vérifier si l'email existe déjà
            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser) {
                $_SESSION['error'] = 'Cet email est déjà utilisé';
                header('Location: index.php?route=/register-patient');
                exit();
            }

            // Créer l'utilisateur
            $userId = $this->userModel->create([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'patient'
            ]);

            if ($userId) {
                // Créer le patient
                $patientData = [
                    'user_id' => $userId,
                    'telephone' => $telephone,
                    'adresse' => $adresse,
                    'date_naissance' => $date_naissance,
                    'age' => $age,
                    'allergies' => $allergies
                ];
                
                $this->patientModel->create($patientData);
                $_SESSION['success'] = 'Patient créé avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la création du patient';
            }

            header('Location: index.php?route=/admin/patients');
            exit();
        }

        header('Location: index.php?route=/register-patient');
        exit();
    }

    /**
     * Supprimer un patient
     */
    public function deletePatient()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientId = $_POST['patient_id'] ?? null;

            if (!$patientId) {
                $_SESSION['error'] = 'ID patient invalide';
                header('Location: index.php?route=/admin/patients');
                exit();
            }

            // Récupérer le patient pour avoir le user_id
            $patient = $this->patientModel->findById($patientId);
            if (!$patient) {
                $_SESSION['error'] = 'Patient non trouvé';
                header('Location: index.php?route=/admin/patients');
                exit();
            }

            // Supprimer le patient
            $success = $this->patientModel->delete($patientId);

            if ($success) {
                // Supprimer aussi l'utilisateur associé
                if (isset($patient['user_id'])) {
                    $this->userModel->delete($patient['user_id']);
                }
                $_SESSION['success'] = 'Patient supprimé avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la suppression';
            }

            header('Location: index.php?route=/admin/patients');
            exit();
        }

        header('Location: index.php?route=/admin/patients');
        exit();
    }

    /**
     * Voir les détails d'un patient
     */
    public function viewPatient($id = null)
    {
        $this->checkAdminAccess();

        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (!$id) {
            $_SESSION['error'] = 'ID patient invalide';
            header('Location: index.php?route=/admin/patients');
            exit();
        }

        $patient = $this->patientModel->findById($id);
        if (!$patient) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/admin/patients');
            exit();
        }

        // Récupérer les rendez-vous du patient
        $rendezVous = $this->patientModel->getRendezVous($id);
        $consultations = $this->patientModel->getConsultations($id);

        $this->view('admin.patient_view', [
            'patient' => $patient,
            'rendezVous' => $rendezVous,
            'consultations' => $consultations
        ]);
    }

    /**
     * Modifier un patient
     */
    public function editPatient($id = null)
    {
        $this->checkAdminAccess();

        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (!$id) {
            $_SESSION['error'] = 'ID patient invalide';
            header('Location: index.php?route=/admin/patients');
            exit();
        }

        $patient = $this->patientModel->findById($id);
        if (!$patient) {
            $_SESSION['error'] = 'Patient non trouvé';
            header('Location: index.php?route=/admin/patients');
            exit();
        }

        $this->view('admin.patient_edit', [
            'patient' => $patient
        ]);
    }

    /**
     * Mettre à jour un patient
     */
    public function updatePatient()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $date_naissance = $_POST['date_naissance'] ?? null;
            $adresse = $_POST['adresse'] ?? '';
            $allergies = $_POST['allergies'] ?? '';

            if (!$id) {
                $_SESSION['error'] = 'ID patient invalide';
                header('Location: index.php?route=/admin/patients');
                exit();
            }

            // Mise à jour via le modèle
            $success = $this->patientModel->update($id, [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'telephone' => $telephone,
                'date_naissance' => $date_naissance,
                'adresse' => $adresse,
                'allergies' => $allergies
            ]);

            if ($success) {
                $_SESSION['success'] = 'Patient mis à jour avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la mise à jour';
            }

            header('Location: index.php?route=/admin/patients');
            exit();
        }

        header('Location: index.php?route=/admin/patients');
        exit();
    }

    // ==================== MÉDECINS ====================

    /**
     * Modifier un médecin
     */
    public function editMedecin($id = null)
    {
        $this->checkAdminAccess();

        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (!$id) {
            $_SESSION['error'] = 'ID médecin invalide';
            header('Location: index.php?route=/admin/medecins');
            exit();
        }

        $medecin = $this->medecinModel->find($id);
        if (!$medecin) {
            $_SESSION['error'] = 'Médecin non trouvé';
            header('Location: index.php?route=/admin/medecins');
            exit();
        }

        $this->view('admin.medecin_edit', [
            'medecin' => $medecin
        ]);
    }

    /**
     * Mettre à jour un médecin
     */
    public function updateMedecin()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $specialite = $_POST['specialite'] ?? '';

            if (!$id) {
                $_SESSION['error'] = 'ID médecin invalide';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            // Mise à jour via le modèle
            $success = $this->medecinModel->update($id, [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'telephone' => $telephone,
                'specialite' => $specialite
            ]);

            if ($success) {
                $_SESSION['success'] = 'Médecin mis à jour avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la mise à jour';
            }

            header('Location: index.php?route=/admin/medecins');
            exit();
        }

        header('Location: index.php?route=/admin/medecins');
        exit();
    }

    /**
     * Supprimer un médecin
     */
    public function deleteMedecin()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID médecin invalide';
                header('Location: index.php?route=/admin/medecins');
                exit();
            }

            $success = $this->medecinModel->delete($id);

            if ($success) {
                $_SESSION['success'] = 'Médecin supprimé avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la suppression';
            }

            header('Location: index.php?route=/admin/medecins');
            exit();
        }

        header('Location: index.php?route=/admin/medecins');
        exit();
    }

    // ==================== SECRÉTAIRES ====================

    /**
     * Modifier une secrétaire
     */
    public function editSecretaire($id = null)
    {
        $this->checkAdminAccess();

        if (!$id && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if (!$id) {
            $_SESSION['error'] = 'ID secrétaire invalide';
            header('Location: index.php?route=/admin/secretaires');
            exit();
        }

        $secretaire = $this->secretaireModel->find($id);
        if (!$secretaire) {
            $_SESSION['error'] = 'Secrétaire non trouvée';
            header('Location: index.php?route=/admin/secretaires');
            exit();
        }

        $this->view('admin.secretaire_edit', [
            'secretaire' => $secretaire
        ]);
    }

    /**
     * Mettre à jour une secrétaire
     */
    public function updateSecretaire()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $departement = $_POST['departement'] ?? '';

            if (!$id) {
                $_SESSION['error'] = 'ID secrétaire invalide';
                header('Location: index.php?route=/admin/secretaires');
                exit();
            }

            $success = $this->secretaireModel->update($id, [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'telephone' => $telephone,
                'departement' => $departement
            ]);

            if ($success) {
                $_SESSION['success'] = 'Secrétaire mise à jour avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la mise à jour';
            }

            header('Location: index.php?route=/admin/secretaires');
            exit();
        }

        header('Location: index.php?route=/admin/secretaires');
        exit();
    }

    /**
     * Supprimer une secrétaire
     */
    public function deleteSecretaire()
    {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID secrétaire invalide';
                header('Location: index.php?route=/admin/secretaires');
                exit();
            }

            $success = $this->secretaireModel->delete($id);

            if ($success) {
                $_SESSION['success'] = 'Secrétaire supprimée avec succès';
            } else {
                $_SESSION['error'] = 'Erreur lors de la suppression';
            }

            header('Location: index.php?route=/admin/secretaires');
            exit();
        }

        header('Location: index.php?route=/admin/secretaires');
        exit();
    }
}