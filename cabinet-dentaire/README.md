# 🏥 Système de Login - Gestion d'Hôpital

## ✅ Corrections appliquées

- ✓ Routeur amélioré (router.php)
- ✓ Redirections corrigées avec paramètres GET
- ✓ Formulaire de login mis à jour
- ✓ Architecture MVC complète et fonctionnelle

---

## 🚀 URL D'ACCÈS AU PROJET

### **Login (Page d'accueil)**
```
http://localhost/web-hopital/public/router.php?route=/login
```

### **Dashboards après connexion**
```
Patient:     http://localhost/web-hopital/public/router.php?route=/patient/dashboard
Médecin:     http://localhost/web-hopital/public/router.php?route=/medecin/dashboard
Secrétaire:  http://localhost/web-hopital/public/router.php?route=/secretaire/dashboard
Admin:       http://localhost/web-hopital/public/router.php?route=/admin/dashboard
```

### **Déconnexion**
```
http://localhost/web-hopital/public/router.php?route=/logout
```

---

## 📝 Identifiants de Test

| Email | Mot de passe | Rôle |
|---|---|---|
| `test@admin.com` | `123456` | Administrateur |
| `patient@test.com` | `123456` | Patient |
| `medecin@test.com` | `123456` | Médecin |
| `secretaire@test.com` | `123456` | Secrétaire |

---

## � Contrôle d'Accès Administrateur

### **Fonctionnalités réservées aux administrateurs :**
- ✅ Inscription de nouveaux médecins (`/register-medecin`)
- ✅ Inscription de nouvelles secrétaires (`/register-secretaire`)
- ✅ Accès au dashboard administrateur (`/admin/dashboard`)
- ✅ Gestion des utilisateurs (médecins, secrétaires, patients)

### **Comment accéder aux formulaires d'inscription :**
1. Connectez-vous en tant qu'administrateur : `test@admin.com` / `123456`
2. Allez sur le dashboard admin
3. Cliquez sur "Ajouter Médecin" ou "Ajouter Secrétaire"
4. Ou accédez directement aux URLs :
   - `http://localhost/web-hopital/public/router.php?route=/register-medecin`
   - `http://localhost/web-hopital/public/router.php?route=/register-secretaire`

**⚠️ Important :** Si un utilisateur non-administrateur tente d'accéder à ces pages, il sera automatiquement redirigé vers la page de login avec un message d'erreur.

---

## �🔧 Installation de la Base de Données

### **Via phpMyAdmin :**

1. Allez à : `http://localhost/phpmyadmin`
2. Cliquez sur **SQL**
3. Collez ces requêtes :

```sql
CREATE DATABASE hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE hospital_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('patient','medecin','secretaire') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (nom, prenom, email, password, role) VALUES
('Dupont', 'Jean', 'patient@test.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'patient'),
('Martin', 'Marie', 'medecin@test.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'medecin'),
('Bernard', 'Sophie', 'secretaire@test.com', '$2y$10$slYQmyNdGzin7olVZeNewOSFihO02X5UqQ8opY2lTmxGEtVyNHiKi', 'secretaire');
```

4. Cliquez **Exécuter** pour chaque requête

---

## 📁 Structure du Projet

```
web-hopital/
├── app/
│   ├── core/
│   │   ├── Database.php
│   │   ├── Model.php
│   │   ├── Controller.php
│   │   └── Auth.php
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── PatientController.php
│   │   ├── MedecinController.php
│   │   └── SecretaireController.php
│   ├── models/
│   │   └── User.php
│   ├── views/
│   │   ├── auth/
│   │   │   └── login.php
│   │   ├── patient/
│   │   │   └── dashboard.php
│   │   ├── medecin/
│   │   │   └── dashboard.php
│   │   └── secretaire/
│   │       └── dashboard.php
│   └── database/
│       └── hospital.sql
├── public/
│   ├── index.php
│   ├── router.php (Principal)
│   └── .htaccess
└── routes/
    └── web.php
```

---

## 🎯 Test du Système

### **Étape 1 : Créer la base de données**
Exécutez les requêtes SQL ci-dessus dans phpMyAdmin

### **Étape 2 : Allez au login**
- URL: `http://localhost/web-hopital/public/router.php?route=/login`
- Email: `patient@test.com`
- Mot de passe: `123456`
- Cliquez **Se connecter**

### **Étape 3 : Vérify la redirection**
Vous devriez être redirigé vers :
- `http://localhost/web-hopital/public/router.php?route=/patient/dashboard`
- Affiche: **Dashboard Patient** avec un h1

---

## ⚙️ Fonctionnalités Implémentées

✅ Login avec email/password
✅ Vérification PDO + password_verify
✅ Sessions PHP
✅ Redirection par rôle (patient/médecin/secrétaire)
✅ Logout
✅ Architecture MVC propre
✅ Authentification avec Auth::role($role)

---

## 📌 URL PRINCIPALE À RETENIR

```
http://localhost/web-hopital/public/router.php?route=/login
```

C'est tout ce que vous devez retenir pour accéder au projet ! 🚀
