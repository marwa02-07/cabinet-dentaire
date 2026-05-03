# 🦷 Cabinet Dentaire - Système de Gestion

Bienvenue dans l'application web **Cabinet Dentaire**, un système complet de gestion pour cabinets dentaires développé en PHP avec une architecture MVC. Cette plateforme permet une gestion efficace des rendez-vous, patients, médecins et secrétaires.

## 🚀 Fonctionnalités Principales

### 👨‍💼 Administrateur
- **Gestion des utilisateurs** : Ajout, modification et suppression des médecins et secrétaires.
- **Gestion des patients** : Vue d'ensemble et administration des dossiers patients.
- **Tableau de bord** : Statistiques globales et suivi des activités.

### 👨‍⚕️ Médecin / Dentiste
- **Dashboard personnalisé** : Aperçu des rendez-vous hebdomadaires et statistiques.
- **Gestion des rendez-vous** : Confirmation, annulation et marquage des absences.
- **Consultations et ordonnances** : Création et gestion des consultations médicales et prescriptions.
- **Accès aux dossiers** : Consultation des informations patients.

### 🗂️ Secrétaire
- **Gestion des rendez-vous** : Planification, modification et suivi complet.
- **Administration des patients** : Enregistrement, mise à jour et gestion des profils.
- **Planning** : Vue journalière et hebdomadaire des rendez-vous.
- **Mises à jour de statut** : Changement des états des rendez-vous en temps réel.

### 🧑‍🦱 Patient
- **Prise de rendez-vous** : Réservation en ligne avec sélection de créneaux disponibles.
- **Historique médical** : Accès aux consultations passées et résultats.
- **Gestion du profil** : Mise à jour des informations personnelles.

## 🛠️ Technologies Utilisées

- **Backend** : PHP 8+ avec architecture MVC personnalisée.
- **Base de données** : MySQL (connexion via PDO pour la sécurité).
- **Frontend** : HTML5, CSS3, Bootstrap 5 pour une interface responsive, et Font Awesome pour les icônes.
- **Serveur local** : XAMPP (Apache, MySQL, PHP).
- **Sécurité** : Sessions PHP avec gestion de rôles indépendants.

## 📦 Installation et Configuration

### Prérequis
- **XAMPP** installé et configuré (avec Apache et MySQL activés).
- **PHP 8+** et **MySQL**.
- Un navigateur web moderne.

### Étapes d'Installation

1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/marwa02-07/cabinet-dentaire.git
   cd cabinet-dentaire
   ```

2. **Placer le projet dans XAMPP** :
   - Copiez le dossier `cabinet-dentaire` dans `C:/xampp/htdocs/` (ou votre répertoire htdocs équivalent).

3. **Configurer la base de données** :
   - Ouvrez **phpMyAdmin** via `http://localhost/phpmyadmin`.
   - Créez une nouvelle base de données nommée `cabinet_dentaire`.
   - Importez le fichier SQL fourni : `cabinet_dentaire.sql` (situé à la racine du projet).

4. **Configurer la connexion à la base de données** :
   - Ouvrez le fichier `config.php` à la racine du projet.
   - Modifiez les paramètres de connexion si nécessaire :
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'cabinet_dentaire');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     ```

5. **Démarrer les services** :
   - Lancez Apache et MySQL dans le panneau de contrôle XAMPP.

6. **Accéder à l'application** :
   - Ouvrez votre navigateur et allez à : `http://localhost/cabinet-dentaire/`
   - La page d'accueil s'affichera automatiquement.

## 👤 Comptes de Test

Utilisez ces comptes pour explorer les différentes fonctionnalités :

| Rôle       | Email                  | Mot de passe |
|------------|------------------------|--------------|
| Administrateur | admin@cabinet.com     | 123456      |
| Médecin/Dentiste | dentiste@cabinet.com | 123456      |
| Secrétaire | secretaire@cabinet.com | 123456      |
| Patient    | patient@cabinet.com    | 123456      |

## 📁 Structure du Projet

```
cabinet-dentaire/
├── app/
│   ├── controllers/     # Contrôleurs MVC (gestion des requêtes)
│   ├── core/            # Classes de base (Auth, Controller, Model, Database)
│   ├── models/          # Modèles de données (User, Medecin, Patient, etc.)
│   └── views/           # Templates par rôle (admin, medecin, secretaire, patient, auth)
├── config.php           # Configuration de la base de données
├── index.php            # Point d'entrée principal
├── routes/
│   └── web.php          # Définition des routes de l'application
├── css/                 # Feuilles de style personnalisées
├── cabinet_dentaire.sql # Schéma et données de la base de données
└── README.md            # Ce fichier
```

## 🔧 Dépannage

- **Erreur 404** : Assurez-vous que l'URL est correcte (`http://localhost/cabinet-dentaire/`) et que le dossier est bien dans `htdocs`.
- **Problème de base de données** : Vérifiez les paramètres dans `config.php` et que MySQL est démarré.
- **Permissions** : Assurez-vous que PHP peut écrire dans les dossiers nécessaires (sessions, etc.).

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :
1. Forkez le projet.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/nouvelle-fonction`).
3. Commitez vos changements (`git commit -am 'Ajout de nouvelle fonctionnalité'`).
4. Poussez vers la branche (`git push origin feature/nouvelle-fonction`).
5. Ouvrez une Pull Request.

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

---

Développé avec ❤️ pour simplifier la gestion des cabinets dentaires.

## 🔐 Sécurité

- Mots de passe hashés avec `password_hash()` (bcrypt)
- Sessions PHP sécurisées par rôle (`SESS_ADMIN`, `SESS_MEDECIN`, etc.)
- Contrôle d'accès par rôle sur chaque route
- Protection contre les injections SQL via PDO et requêtes préparées

---

## 📄 Licence

Projet académique - Usage éducatif.
