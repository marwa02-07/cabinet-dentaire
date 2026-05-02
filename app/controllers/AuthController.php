<?php

/**
 * AuthController
 * Gère le login et logout
 * AFFICHE TOUS LES MESSAGES DE DEBUG
 */

class AuthController extends Controller
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
    }
    
    /**
     * Affiche la page de login
     */
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $error = '';
        $success = '';
        
        // Récupérer les messages d'erreur de la session précédente
        if (isset($_SESSION['login_error'])) {
            $error = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }
        
        // Récupérer les messages de succès
        if (isset($_SESSION['login_success'])) {
            $success = $_SESSION['login_success'];
            unset($_SESSION['login_success']);
        }
        
        // Nettoyer les messages de debug de la session (ne pas les passer à la vue)
        if (isset($_SESSION['debug_messages'])) {
            unset($_SESSION['debug_messages']);
        }
        
        // Afficher la vue login
        $this->view('auth.login', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Affiche la page d'inscription pour les patients
     */
    public function register()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $error = '';
        $success = '';
        
        // Récupérer les messages d'erreur de la session précédente
        if (isset($_SESSION['register_error'])) {
            $error = $_SESSION['register_error'];
            unset($_SESSION['register_error']);
        }
        
        // Récupérer les messages de succès
        if (isset($_SESSION['register_success'])) {
            $success = $_SESSION['register_success'];
            unset($_SESSION['register_success']);
        }
        
        // Afficher la vue register
        $this->view('auth.register', [
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Affiche la page d'inscription pour les médecins
     */
    public function registerMedecin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que l'utilisateur est admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['login_error'] = 'Accès refusé. Seuls les administrateurs peuvent enregistrer des médecins.';
            header('Location: index.php?route=/login');
            exit();
        }
        
        $error = '';
        $success = '';
        
        if (isset($_SESSION['register_error'])) {
            $error = $_SESSION['register_error'];
            unset($_SESSION['register_error']);
        }
        
        if (isset($_SESSION['register_success'])) {
            $success = $_SESSION['register_success'];
            unset($_SESSION['register_success']);
        }
        
        $this->view('auth.register-medecin', [
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Affiche la page d'inscription pour les secrétaires
     */
    public function registerSecretaire()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier que l'utilisateur est admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['login_error'] = 'Accès refusé. Seuls les administrateurs peuvent enregistrer des secrétaires.';
            header('Location: index.php?route=/login');
            exit();
        }
        
        $error = '';
        $success = '';
        
        if (isset($_SESSION['register_error'])) {
            $error = $_SESSION['register_error'];
            unset($_SESSION['register_error']);
        }
        
        if (isset($_SESSION['register_success'])) {
            $success = $_SESSION['register_success'];
            unset($_SESSION['register_success']);
        }
        
        $this->view('auth.register-secretaire', [
            'error' => $error,
            'success' => $success
        ]);
    }
    
    /**
     * Traite la soumission du formulaire d'inscription
     */
    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier que c'est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['register_error'] = 'Erreur de requête (méthode non POST)';
            header('Location: index.php?route=/register');
            exit();
        }
        
        // Récupérer les données
        $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
        $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
        $email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $age = isset($_POST['age']) ? (int)$_POST['age'] : 0;
        $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
        $adresse = isset($_POST['adresse']) ? trim($_POST['adresse']) : '';
        
        // Log des données reçues (debug)
        error_log("=== INSCRIPTION DEBUG ===");
        error_log("Données reçues: nom=$nom, prenom=$prenom, email=$email, age=$age");
        
        // Validation
        if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password) || empty($age) || empty($telephone) || empty($adresse)) {
            $_SESSION['register_error'] = 'Veuillez remplir tous les champs (reçus: nom=' . $nom . ', prenom=' . $prenom . ', email=' . $email . ')';
            header('Location: index.php?route=/register');
            exit();
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['register_error'] = 'Les mots de passe ne correspondent pas';
            header('Location: index.php?route=/register');
            exit();
        }
        
        if (strlen($password) < 6) {
            $_SESSION['register_error'] = 'Le mot de passe doit contenir au moins 6 caractères';
            header('Location: index.php?route=/register');
            exit();
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Adresse email invalide';
            header('Location: index.php?route=/register');
            exit();
        }
        
        // Vérifier si l'email existe déjà
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'Cette adresse email est déjà utilisée';
            header('Location: index.php?route=/register');
            exit();
        }
        
        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer dans users
        $user_id = $this->userModel->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $hashed_password,
            'role' => 'patient'
        ]);
        
        if (!$user_id) {
            $_SESSION['register_error'] = 'Erreur lors de la création du compte';
            header('Location: index.php?route=/register');
            exit();
        }
        
        // Insérer dans patients
        $patientModel = new Patient();
        $patient_id = $patientModel->create([
            'user_id' => $user_id,
            'age' => $age,
            'telephone' => $telephone,
            'adresse' => $adresse
        ]);
        
        if (!$patient_id) {
            // Supprimer l'utilisateur si l'insertion patient échoue
            $this->userModel->delete($user_id);
            $_SESSION['register_error'] = 'Erreur lors de la création du profil patient';
            header('Location: index.php?route=/register');
            exit();
        }
        
        $_SESSION['register_success'] = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
        header('Location: index.php?route=/login');
        exit();
    }

    /**
     * Traite l'inscription d'un médecin
     */
    public function storeMedecin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['register_error'] = 'Erreur de requête (méthode non POST)';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        
        // Récupérer les données
        $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
        $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
        $email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $specialite = isset($_POST['specialite']) ? trim($_POST['specialite']) : '';
        $numero_licence = isset($_POST['numero_licence']) ? trim($_POST['numero_licence']) : '';
        $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
        $cabinet = isset($_POST['cabinet']) ? trim($_POST['cabinet']) : '';
        
        // Validation
        if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password) || empty($specialite) || empty($numero_licence)) {
            $_SESSION['register_error'] = 'Veuillez remplir tous les champs obligatoires';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['register_error'] = 'Les mots de passe ne correspondent pas';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        
        if (strlen($password) < 6) {
            $_SESSION['register_error'] = 'Le mot de passe doit contenir au moins 6 caractères';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Adresse email invalide';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        
        // Vérifier si l'email existe déjà
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'Cette adresse email est déjà utilisée';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        
        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer dans users
        $user_id = $this->userModel->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $hashed_password,
            'role' => 'dentiste'
        ]);
        
        if (!$user_id) {
            $_SESSION['register_error'] = 'Erreur lors de la création du compte';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        
        // Insérer dans medecins
        $medecinModel = new Medecin();
        $medecin_id = $medecinModel->create([
            'user_id' => $user_id,
            'specialite' => $specialite,
            'numero_licence' => $numero_licence,
            'telephone' => $telephone,
            'cabinet' => $cabinet
        ]);
        
        if (!$medecin_id) {
            $this->userModel->delete($user_id);
            $_SESSION['register_error'] = 'Erreur lors de la création du profil médecin';
            header('Location: index.php?route=/register-medecin');
            exit();
        }
        // Vérifier si c'est un admin qui a créé le médecin
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            $_SESSION['success'] = 'Compte médecin créé avec succès !';
            header('Location: index.php?route=/admin/medecins');
        } else {
            $_SESSION['register_success'] = 'Compte médecin créé avec succès ! Vous pouvez maintenant vous connecter.';
            header('Location: index.php?route=/login');
        }
        exit();
    }

    /**
     * Traite l'inscription d'une secrétaire
     */
    public function storeSecretaire()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['register_error'] = 'Erreur de requête (méthode non POST)';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        // Récupérer les données
        $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
        $prenom = isset($_POST['prenom']) ? trim($_POST['prenom']) : '';
        $email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
        $departement = isset($_POST['departement']) ? trim($_POST['departement']) : '';
        
        // Validation
        if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password)) {
            $_SESSION['register_error'] = 'Veuillez remplir tous les champs obligatoires';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['register_error'] = 'Les mots de passe ne correspondent pas';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        if (strlen($password) < 6) {
            $_SESSION['register_error'] = 'Le mot de passe doit contenir au moins 6 caractères';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Adresse email invalide';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        // Vérifier si l'email existe déjà
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'Cette adresse email est déjà utilisée';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer dans users
        $user_id = $this->userModel->create([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $hashed_password,
            'role' => 'secretaire'
        ]);
        
        if (!$user_id) {
            $_SESSION['register_error'] = 'Erreur lors de la création du compte';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        // Insérer dans secretaires
        $secretaireModel = new Secretaire();
        $secretaire_id = $secretaireModel->create([
            'user_id' => $user_id,
            'telephone' => $telephone,
            'departement' => $departement
        ]);
        
        if (!$secretaire_id) {
            $this->userModel->delete($user_id);
            $_SESSION['register_error'] = 'Erreur lors de la création du profil secrétaire';
            header('Location: index.php?route=/register-secretaire');
            exit();
        }
        
        // Vérifier si c'est un admin qui a créé la secrétaire
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            $_SESSION['success'] = 'Compte secrétaire créé avec succès !';
            header('Location: index.php?route=/admin/secretaires');
        } else {
            $_SESSION['register_success'] = 'Compte secrétaire créé avec succès ! Vous pouvez maintenant vous connecter.';
            header('Location: index.php?route=/login');
        }
        exit();
    }
    public function authenticate()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier que c'est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['login_error'] = 'Erreur de requête';
            header('Location: index.php?route=/login');
            exit();
        }
        
        // Récupérer email et password
        $email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        
        // Vérification : email et password non vides
        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Veuillez remplir tous les champs';
            header('Location: index.php?route=/login');
            exit();
        }
        
        // Log debug
        error_log("=== LOGIN DEBUG ===");
        error_log("Email cherché: " . $email);
        
        // Chercher l'utilisateur
        $user = $this->userModel->findByEmail($email);
        
        if (!$user) {
            error_log("Utilisateur NON trouvé pour l'email: " . $email);
            $_SESSION['login_error'] = 'Email ou mot de passe incorrect';
            header('Location: index.php?route=/login');
            exit();
        }
        
        error_log("Utilisateur trouvé: " . $user['email']);
        error_log("Mot de passe reçu: " . $password);
        error_log("Mot de passe hashé en BD: " . $user['password']);
        
        // Vérifier le mot de passe avec password_verify() (sécurisé avec bcrypt)
        if (!password_verify($password, $user['password'])) {
            error_log("Mot de passe INCORRECT pour: " . $email);
            $_SESSION['login_error'] = 'Email ou mot de passe incorrect';
            header('Location: index.php?route=/login');
            exit();
        }
        
        error_log("Mot de passe CORRECT");
        
        // Déterminer le nom de session selon le rôle détecté
        $roleSessionMap = [
            'admin'      => 'SESS_ADMIN',
            'medecin'    => 'SESS_MEDECIN',
            'dentiste'   => 'SESS_MEDECIN',
            'secretaire' => 'SESS_SECRETAIRE',
            'patient'    => 'SESS_PATIENT',
        ];
        $targetSessionName = $roleSessionMap[$user['role']] ?? 'PHPSESSID';
        
        // Fermer la session courante (temporaire de la page login)
        session_write_close();
        
        // Ouvrir la session spécifique au rôle
        session_name($targetSessionName);
        session_set_cookie_params(43200, '/');
        session_start();
        
        // Renouveler l'identifiant de session pour éviter le détournement de session
        session_regenerate_id(true);
        
        // Créer les sessions avec toutes les infos utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        
        $fullName = $user['prenom'] . ' ' . $user['nom'];
        $_SESSION['login_success'] = "Connexion réussie ! Bienvenue " . $fullName;
        
        // Redirection selon le rôle
        switch ($user['role']) {
            case 'patient':
                header('Location: index.php?route=/patient/dashboard');
                break;
            case 'medecin':
            case 'dentiste':  // Support both "medecin" and "dentiste" roles
                header('Location: index.php?route=/medecin/dashboard');
                break;
            case 'secretaire':
                header('Location: index.php?route=/secretaire/dashboard');
                break;
            case 'admin':
                header('Location: index.php?route=/admin/dashboard');
                break;
            default:
                $_SESSION['login_error'] = 'Erreur : rôle inconnu (' . $user['role'] . ')';
                header('Location: index.php?route=/login');
        }
        
        exit();
    }
    
    /**
     * Logout - détruit uniquement la session du rôle courant
     */
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Désactiver le cache lors de la déconnexion
        if (!headers_sent()) {
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
            header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        }
        
        // Vider la session côté serveur et client (seulement la session courante du rôle)
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        
        header('Location: index.php?route=/login');
        exit();
    }
}
