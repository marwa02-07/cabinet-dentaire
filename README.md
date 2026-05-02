# 🦷 Cabinet Dentaire - Système de Gestion

Application web PHP MVC pour la gestion complète d'un cabinet dentaire.

## 🚀 Fonctionnalités

### 👨‍💼 Administrateur
- Gestion des médecins (ajout, modification, suppression)
- Gestion des secrétaires
- Gestion des patients
- Tableau de bord avec statistiques

### 👨‍⚕️ Médecin / Dentiste
- Dashboard personnalisé avec statistiques hebdomadaires
- Gestion des rendez-vous (confirmation, annulation, absence)
- Création de consultations et ordonnances
- Accès au dossier patient

### 🗂️ Secrétaire
- Gestion complète des rendez-vous
- Enregistrement et modification des patients
- Planning journalier / hebdomadaire
- Mise à jour des statuts de rendez-vous

### 🧑‍🦱 Patient
- Prise de rendez-vous en ligne
- Historique des consultations
- Gestion du profil

---

## 🛠️ Stack Technique

- **Backend** : PHP 8+ (Architecture MVC)
- **Base de données** : MySQL (via PDO)
- **Frontend** : HTML5, CSS3, Bootstrap 5, Font Awesome
- **Serveur local** : XAMPP

---

## 📦 Installation

### 1. Cloner le dépôt
```bash
git clone https://github.com/Afousswassim/cabinet-dentaire.git
cd cabinet-dentaire
```

### 2. Placer dans XAMPP
Copier le dossier dans `C:/xampp/htdocs/` (ou votre répertoire htdocs).

### 3. Créer la base de données
1. Ouvrir **phpMyAdmin** (`http://localhost/phpmyadmin`)
2. Créer une base `cabinet_dentaire`
3. Importer le fichier `app/database/cabinet_dentaire.sql`

### 4. Configurer la connexion
Modifier `app/core/Database.php` selon votre configuration :
```php
private $host = 'localhost';
private $dbname = 'cabinet_dentaire';
private $username = 'root';
private $password = '';
```

### 5. Accéder à l'application
```
http://localhost/cabinet-dentaire/public/
```

---

## 👤 Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | admin@cabinet.com | 123456 |
| Dentiste | dentiste@cabinet.com | 123456 |
| Secrétaire | secretaire@cabinet.com | 123456 |
| Patient | patient@cabinet.com | 123456 |

---

## 📁 Structure du projet

```
cabinet-dentaire/
├── app/
│   ├── controllers/     # Contrôleurs MVC
│   ├── core/            # Classes de base (Auth, Controller, Model, Database)
│   ├── models/          # Modèles (User, Medecin, Patient, RendezVous...)
│   ├── views/           # Vues par rôle (admin, medecin, secretaire, patient, auth)
│   └── database/        # Schéma SQL et données de test
├── public/              # Point d'entrée (index.php), assets CSS/JS
├── routes/              # Définition des routes (web.php)
└── .gitignore
```

---

## 🔐 Sécurité

- Mots de passe hashés avec `password_hash()` (bcrypt)
- Sessions PHP sécurisées par rôle (`SESS_ADMIN`, `SESS_MEDECIN`, etc.)
- Contrôle d'accès par rôle sur chaque route
- Protection contre les injections SQL via PDO et requêtes préparées

---

## 📄 Licence

Projet académique - Usage éducatif.
