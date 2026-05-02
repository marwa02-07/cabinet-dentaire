<?php

/**
 * Routes de l'application
 * Définit les routes GET et POST
 * Format: 'route' => ['ControllerName', 'methodName']
 */

return [
    'GET' => [
        '/' => ['HomeController', 'index'],
        '/login' => ['AuthController', 'login'],
        '/login/medecin' => ['AuthController', 'loginMedecin'],
        '/register' => ['AuthController', 'register'],
        '/register-medecin' => ['AuthController', 'registerMedecin'],
        '/register-secretaire' => ['AuthController', 'registerSecretaire'],
        '/logout' => ['AuthController', 'logout'],
        // Routes Patient
        '/patient/dashboard' => ['PatientController', 'dashboard'],
        '/patient/rendez-vous' => ['PatientController', 'rendezVous'],
        '/patient/rendez-vous/create' => ['PatientController', 'createRendezVous'],
        '/patient/rendez-vous/available-dates' => ['PatientController', 'availableBookingDates'],
        '/patient/rendez-vous/available-slots' => ['PatientController', 'availableBookingSlots'],
        '/patient/consultations' => ['PatientController', 'consultations'],
        '/patient/profile' => ['PatientController', 'profile'],
        // Routes Médecin/Dentiste
        '/medecin/dashboard' => ['MedecinController', 'dashboard'],
        '/medecin/rendez-vous' => ['MedecinController', 'rendezVous'],
        '/medecin/patient/:id' => ['MedecinController', 'patientDetail'],
        '/medecin/consultation/select' => ['MedecinController', 'selectConsultation'],
        '/medecin/consultation/create' => ['MedecinController', 'createConsultation'],
        '/medecin/consultation/create/:id' => ['MedecinController', 'createConsultation'],
        '/medecin/ordonnance/select' => ['MedecinController', 'selectOrdonnance'],
        '/medecin/ordonnance/create' => ['MedecinController', 'createOrdonnance'],
        '/medecin/ordonnance/create/:id' => ['MedecinController', 'createOrdonnance'],
        '/medecin/profile' => ['MedecinController', 'profile'],
        // Routes Secrétaire
        '/secretaire/dashboard' => ['SecretaireController', 'dashboard'],
        '/secretaire/patients' => ['SecretaireController', 'patients'],
        '/secretaire/patients/create' => ['SecretaireController', 'createPatient'],
        '/secretaire/patients/edit' => ['SecretaireController', 'editPatient'],
        '/secretaire/patients/view' => ['SecretaireController', 'viewPatient'],
        '/secretaire/rendezvous' => ['SecretaireController', 'rendezVous'],
        '/secretaire/rendezvous/create' => ['SecretaireController', 'createRdv'],
        '/secretaire/rendez-vous/create' => ['SecretaireController', 'createRdv'],
        '/secretaire/rendezvous/edit' => ['SecretaireController', 'editRdv'],
        '/secretaire/rendezvous/available-dates' => ['SecretaireController', 'availableBookingDates'],
        '/secretaire/rendezvous/available-slots' => ['SecretaireController', 'availableBookingSlots'],
        '/secretaire/planning' => ['SecretaireController', 'planning'],
        '/secretaire/planning/print' => ['SecretaireController', 'printPlanning'],
        // Routes Admin
        '/admin/dashboard' => ['AdminController', 'dashboard'],
        '/admin/medecins' => ['AdminController', 'medecins'],
        '/admin/medecin/edit/:id' => ['AdminController', 'editMedecin'],
        '/admin/medecin/delete/:id' => ['AdminController', 'deleteMedecin'],
        '/admin/secretaires' => ['AdminController', 'secretaires'],
        '/admin/secretaire/edit/:id' => ['AdminController', 'editSecretaire'],
        '/admin/secretaire/delete/:id' => ['AdminController', 'deleteSecretaire'],
        '/admin/patients' => ['AdminController', 'patients'],
        '/admin/patients/edit' => ['AdminController', 'editPatient'],
        '/admin/patients/edit/:id' => ['AdminController', 'editPatient'],
        '/register-patient' => ['AdminController', 'registerPatient'],
    ],
    'POST' => [
        '/login' => ['AuthController', 'authenticate'],
        '/register' => ['AuthController', 'store'],
        '/register-medecin' => ['AuthController', 'storeMedecin'],
        '/register-secretaire' => ['AuthController', 'storeSecretaire'],
        // Routes Patient
        '/patient/rendez-vous/store' => ['PatientController', 'storeRendezVous'],
        // Routes Médecin
        '/medecin/rendez-vous/status' => ['MedecinController', 'updateStatus'],
        '/medecin/consultation/store' => ['MedecinController', 'storeConsultation'],
        '/medecin/ordonnance/store' => ['MedecinController', 'storeOrdonnance'],
        '/medecin/profile/update' => ['MedecinController', 'updateProfile'],
        // Routes Secrétaire
        '/secretaire/patients/store' => ['SecretaireController', 'storePatient'],
        '/secretaire/patients/update' => ['SecretaireController', 'updatePatient'],
        '/secretaire/patients/delete' => ['SecretaireController', 'deletePatient'],
        '/secretaire/rendezvous/store' => ['SecretaireController', 'storeRdv'],
        '/secretaire/rendezvous/update' => ['SecretaireController', 'updateRdv'],
        '/secretaire/rendezvous/delete' => ['SecretaireController', 'deleteRdv'],
        '/secretaire/rendezvous/status' => ['SecretaireController', 'updateStatus'],
        // Routes API
        '/api/dentistes/by-specialite' => ['SecretaireController', 'getDentistesBySpecialite'],
        // Admin - Médecins
        '/admin/medecin/store' => ['AdminController', 'storeMedecin'],
        '/admin/medecin/update' => ['AdminController', 'updateMedecin'],
        '/admin/medecin/delete' => ['AdminController', 'deleteMedecin'],
        // Admin - Secrétaires
        '/admin/secretaire/store' => ['AdminController', 'storeSecretaire'],
        '/admin/secretaire/update' => ['AdminController', 'updateSecretaire'],
        '/admin/secretaire/delete' => ['AdminController', 'deleteSecretaire'],
        // Admin - Patients
        '/admin/patients/create' => ['AdminController', 'storePatient'],
        '/admin/patients/update' => ['AdminController', 'updatePatient'],
        '/admin/patients/delete' => ['AdminController', 'deletePatient'],
    ]
];
