# 🦷 Cabinet Dentaire — Application de Gestion

Cabinet Dentaire est une application web PHP MVC pour la gestion opérationnelle d’un cabinet dentaire.

Elle offre une interface dédiée aux rôles suivants :
- **Administrateur**
- **Dentiste**
- **Secrétaire**
- **Patient**

## 🌟 Fonctionnalités

- Authentification sécurisée avec rôles séparés
- Gestion des médecins, secrétaires et patients
- Organisation complète des rendez-vous
- Création et suivi des consultations et ordonnances
- Tableaux de bord par rôle
- Planning journaliers et hebdomadaires
- Messages d’erreur clairs et retours utilisateur

## 🔧 Technologies

- PHP 8+
- MySQL
- PDO
- HTML5 / CSS3
- Bootstrap 5
- Font Awesome
- XAMPP

## 📦 Installation

### Pré-requis
- XAMPP installé
- Apache et MySQL activés
- PHP 8+

### Étapes

1. Cloner le dépôt :
   ```bash
   git clone https://github.com/marwa02-07/cabinet-dentaire.git
   cd cabinet-dentaire
   ```

2. Copier le dossier dans le répertoire XAMPP :
   - `C:/xampp/htdocs/cabinet-dentaire`

3. Créer la base de données :
   - Ouvrir `http://localhost/phpmyadmin`
   - Créer la base `cabinet_dentaire`
   - Importer `cabinet_dentaire.sql`

4. Configurer la connexion :
   - Ouvrir `config.php`
   - Vérifier les paramètres :
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'cabinet_dentaire');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     ```

5. Lancer Apache et MySQL via XAMPP.

6. Accéder à l’application :
   - `http://localhost/cabinet-dentaire/`

## 👤 Comptes de test

| Rôle | Identifiant | Mot de passe |
|---|---|---|
| Administrateur | ensiasd | ENSIASD2026 |
| Dentiste | dentiste@cabinet.com | 123456 |
| Secrétaire | secretaire@cabinet.com | 123456 |
| Patient | patient@cabinet.com | 123456 |

## 📁 Structure du projet

```
cabinet-dentaire/
├── app/
│   ├── controllers/     # Contrôleurs MVC
│   ├── core/            # Classes de base
│   ├── models/          # Modèles
│   └── views/           # Templates
├── config.php           # Configuration de la base de données
├── index.php            # Point d’entrée principal
├── routes/              # Routes de l’application
├── css/                 # Styles
├── cabinet_dentaire.sql # Schéma SQL + données tests
└── README.md            # Documentation
```

## 💡 Notes

- Le projet est prévu pour un déploiement depuis un sous-dossier XAMPP.
- Si votre URL diffère, adaptez `BASE_URL` dans `index.php`.
- Le login peut utiliser l’email ou le nom d’utilisateur selon la configuration.

## 🤝 Contribution

1. Forkez le dépôt.
2. Créez une branche dédiée.
3. Effectuez vos modifications.
4. Ouvrez une Pull Request.

## 📄 Licence

Licence MIT.
