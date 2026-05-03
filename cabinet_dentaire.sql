-- =====================================================
-- CABINET DENTAIRE - Schéma de Base de Données
-- =====================================================

CREATE DATABASE IF NOT EXISTS cabinet_dentaire CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cabinet_dentaire;

-- Tables à supprimer dans l'ordre (clés étrangères)
DROP TABLE IF EXISTS factures;
DROP TABLE IF EXISTS ordonnance_medicaments;
DROP TABLE IF EXISTS ordonnances;
DROP TABLE IF EXISTS consultations;
DROP TABLE IF EXISTS rendez_vous;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS dentistes;
DROP TABLE IF EXISTS secretaires;
DROP TABLE IF EXISTS users;

-- =====================================================
-- TABLE USERS (Utilisateurs)
-- =====================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','dentiste','secretaire','patient') NOT NULL DEFAULT 'patient',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_email (email),
    KEY idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE DENTISTES (Informations spécifiques aux dentistes)
-- =====================================================
CREATE TABLE dentistes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    specialite VARCHAR(100),
    numero_licence VARCHAR(50) UNIQUE,
    telephone VARCHAR(20),
    cabinet TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    KEY idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE SECRETARIES (Informations spécifiques aux secrétaires)
-- =====================================================
CREATE TABLE secretaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    telephone VARCHAR(20),
    departement VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    KEY idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE PATIENTS (Dossiers patients)
-- =====================================================
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    age INT,
    telephone VARCHAR(20),
    adresse TEXT,
    date_naissance DATE,
    groupe_sanguin VARCHAR(5),
    allergies TEXT,
    observations TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    KEY idx_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE RENDEZ_VOUS
-- =====================================================
CREATE TABLE rendez_vous (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    dentiste_id INT NOT NULL,
    secretaire_id INT,
    date_heure DATETIME NOT NULL,
    duree_minutes INT DEFAULT 30,
    motif TEXT,
    type_rendez_vous ENUM('consultation','nettoyage','extraction','traitement','blanchiment','radio','autre') DEFAULT 'consultation',
    statut ENUM('planifié','confirmé','annulé','complété','absent') DEFAULT 'planifié',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (dentiste_id) REFERENCES dentistes(id) ON DELETE CASCADE,
    FOREIGN KEY (secretaire_id) REFERENCES secretaires(id) ON DELETE SET NULL,
    KEY idx_patient (patient_id),
    KEY idx_dentiste (dentiste_id),
    KEY idx_date (date_heure),
    KEY idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE CONSULTATIONS (Suivi des traitements)
-- =====================================================
CREATE TABLE consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rendez_vous_id INT NULL,
    dentiste_id INT NOT NULL,
    patient_id INT NOT NULL,
    diagnostic TEXT,
    traitement_effectue TEXT,
    traitement_prevu TEXT,
    dents_traitees VARCHAR(100),
    prix DECIMAL(10,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous(id) ON DELETE SET NULL,
    FOREIGN KEY (dentiste_id) REFERENCES dentistes(id) ON DELETE CASCADE,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    KEY idx_rendez_vous (rendez_vous_id),
    KEY idx_patient (patient_id),
    KEY idx_dentiste (dentiste_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE ORDONNANCES
-- =====================================================
CREATE TABLE ordonnances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    dentiste_id INT NOT NULL,
    rendez_vous_id INT NULL,
    consultation_id INT NULL,
    num_ordonnance VARCHAR(50) UNIQUE NOT NULL,
    date_creation DATE NOT NULL,
    instructions TEXT,
    recommandations TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (dentiste_id) REFERENCES dentistes(id) ON DELETE CASCADE,
    FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous(id) ON DELETE SET NULL,
    FOREIGN KEY (consultation_id) REFERENCES consultations(id) ON DELETE SET NULL,
    KEY idx_patient (patient_id),
    KEY idx_dentiste (dentiste_id),
    KEY idx_rendez_vous (rendez_vous_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE ORDONNANCE_MEDICAMENTS
-- =====================================================
CREATE TABLE ordonnance_medicaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ordonnance_id INT NOT NULL,
    nom_medicament VARCHAR(255) NOT NULL,
    dosage VARCHAR(100) NOT NULL,
    frequence VARCHAR(100) NOT NULL,
    duree VARCHAR(100),
    instructions_medicament TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ordonnance_id) REFERENCES ordonnances(id) ON DELETE CASCADE,
    KEY idx_ordonnance (ordonnance_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE FACTURES (Module de facturation)
-- =====================================================
CREATE TABLE factures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    consultation_id INT,
    numero_facture VARCHAR(50) UNIQUE NOT NULL,
    date_facture DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    montant_regle DECIMAL(10,2) DEFAULT 0,
    reste_a_payer DECIMAL(10,2) DEFAULT 0,
    statut ENUM('payé','partiel','impayé') DEFAULT 'impayé',
    mode_paiement ENUM('espèces','carte','chèque','virement','non payé') DEFAULT 'non payé',
    date_reglement DATE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (consultation_id) REFERENCES consultations(id) ON DELETE SET NULL,
    KEY idx_patient (patient_id),
    KEY idx_numero (numero_facture),
    KEY idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DONNÉES DE TEST
-- =====================================================

-- Utilisateurs de test
-- Admin: ensiasd / ENSIASD2026
-- Dentiste: dentiste@cabinet.com / 123456
-- Secrétaire: secretaire@cabinet.com / 123456
-- Patient: patient@cabinet.com / 123456
-- =========================
-- USERS (ADMIN + DENTISTE + SECRETAIRE + PATIENT + DENTISTES)
-- =========================
INSERT INTO users (nom, prenom, email, password, role) VALUES

-- Admin
('ENSIASD', 'Administrateur', 'ensiasd', '$2y$10$Ngo5BqdHYWC.7D2aXUyIJeaB1BDKzul6agzJjYnd73vFyzAmDjG7O', 'admin'),

-- Dentiste principal
('Bensalem', 'Youssef', 'dentiste@cabinet.com', '$2y$10$DFowLG4khDB3uh9Vr8hz2uVmkX15.voL8NIy4vW5CjO9.7bpinD9i', 'dentiste'),

-- Secretaire
('El Amrani', 'Fatima', 'secretaire@cabinet.com', '$2y$10$SlVBFjzt0XssqAM6pAUkheIlag1UVmrmMgk7Rbc5udxQgM/GxdiRa', 'secretaire'),

-- Patient
('Alaoui', 'Mehdi', 'patient@cabinet.com', '$2y$10$LRJJyGXvV.5vdHl2XvTpYO21.7rkFmMQnVzPUIIBydFKjNfdiA1tS', 'patient'),

('Amine', 'El Amrani', 'med1@cabinet.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'dentiste'),
('Youssef', 'Benali', 'med2@cabinet.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lmxGEtVyNHiKi', 'dentiste'),
('Omar', 'Alaoui', 'med3@cabinet.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'dentiste'),
('Karim', 'Tazi', 'med4@cabinet.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'dentiste'),
('Hamza', 'Idrissi', 'med5@cabinet.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'dentiste'),
('Mehdi', 'Bennani', 'med6@cabinet.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'dentiste'),
('Rachid', 'Zerouali', 'med7@cabinet.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'dentiste');

-- Dentiste
INSERT INTO dentistes (user_id, specialite, numero_licence, telephone, cabinet) VALUES
(2, 'Consultation', 'CD-001', '+212 6 11 22 33 44', 'Cabinet Dentaire Central, Casablanca'),
(5,  'Consultation', 'CONS-001', '+212600000001', 'Cabinet Central , Casablanca'),
(6,  'Nettoyage',    'NET-001',  '+212600000002', 'Cabinet Central , Casablanca'),
(7,  'Extraction',   'EXT-001',  '+212600000003', 'Cabinet Central , Casablanca'),
(8,  'Traitement',   'TRT-001',  '+212600000004', 'Cabinet Central , Casablanca'),
(9,  'Blanchiment',  'BL-001',   '+212600000005', 'Cabinet Central , Casablanca'),
(10, 'Radio',        'RAD-001',  '+212600000006', 'Cabinet Central, Casablanca'),
(11, 'Autre',        'AUT-001',  '+212600000007', 'Cabinet Central, Casablanca');

-- Secrétaire
INSERT INTO secretaires (user_id, telephone, departement) VALUES
(3, '+212 6 55 66 77 88', 'Réception');

-- Patient
INSERT INTO patients (user_id, age, telephone, adresse, date_naissance, allergies) VALUES
(4, 35, '+212 6 00 00 00 01', '123 Avenue Mohammed V, Casablanca', '1991-05-15', 'Allergie à la pénicilline');

-- Rendez-vous de test
INSERT INTO rendez_vous (patient_id, dentiste_id, secretaire_id, date_heure, duree_minutes, motif, type_rendez_vous, statut) VALUES
(1, 1, 1, NOW() + INTERVAL 1 DAY, 30, 'Consultation de contrôle', 'consultation', 'confirmé'),
(1, 1, 1, NOW() + INTERVAL 7 DAY, 45, 'Nettoyage dentaire', 'nettoyage', 'planifié');

-- Consultation de test
INSERT INTO consultations (rendez_vous_id, dentiste_id, patient_id, diagnostic, traitement_effectue, dents_traitees, prix) VALUES
(1, 1, 1, 'Carie sur dent 46', 'Obturation composite', '46', 350.00);

-- Ordonnance de test
INSERT INTO ordonnances (patient_id, dentiste_id, rendez_vous_id, consultation_id, num_ordonnance, date_creation, instructions, recommandations) VALUES
(1, 1, 1, 1, 'ORD-2026-0001', CURDATE(), 'Prendre les médicaments après les repas.', 'Contrôle dans 7 jours');

-- Médicaments de l'ordonnance de test
INSERT INTO ordonnance_medicaments (ordonnance_id, nom_medicament, dosage, frequence, duree, instructions_medicament) VALUES
(1, 'Amoxicilline', '500 mg', '3 fois par jour', '7 jours', 'A prendre avec de l''eau'),
(1, 'Paracétamol', '1 g', '2 fois par jour', '3 jours', 'En cas de douleur');

-- Facture de test
INSERT INTO factures (patient_id, consultation_id, numero_facture, date_facture, montant, montant_regle, reste_a_payer, statut, mode_paiement) VALUES
(1, 1, 'FAC-2026-0001', CURDATE(), 350.00, 350.00, 0, 'payé', 'espèces');