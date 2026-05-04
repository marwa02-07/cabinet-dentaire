# 🏥 Cabinet Dentaire - Application Web MVC

Application web complète de gestion d’un cabinet dentaire développée en **PHP (architecture MVC)** avec une interface moderne, responsive et adaptée à plusieurs rôles.

---

## 📌 1. Présentation du projet

Cette application permet de centraliser et simplifier la gestion d’un cabinet dentaire :

* Gestion des patients
* Gestion des rendez-vous
* Gestion des consultations
* Interfaces adaptées selon le rôle utilisateur

👥 **Rôles disponibles :**

* 👑 Administrateur
* 🧑‍⚕️ Dentiste (Médecin)
* 🧑‍💼 Secrétaire
* 🧑‍🦱 Patient

---

## 🌐 2. Accès en ligne

🔗 **Lien du projet :**
👉 https://cabinet-dentaire.infinityfree.me/

---

## 🔐 3. Comptes de test

Utilisez les comptes suivants pour tester l’application :

### 👑 Administrateur

* Email : `ensiasd`
* Mot de passe : `ENSIASD2026`

### 🧑‍⚕️ Dentiste

* Email : `dentiste@cabinet.com`
* Mot de passe : `123456`

### 🧑‍💼 Secrétaire

* Email : `secretaire@cabinet.com`
* Mot de passe : `123456`

### 🧑‍🦱 Patient

* Email : `patient@cabinet.com`
* Mot de passe : `123456`

⚠️ *Ces comptes sont destinés uniquement à des fins de démonstration.*

---

## ⚙️ 4. Technologies utilisées

* 🐘 PHP (Architecture MVC)
* 🗄️ MySQL
* 🎨 Bootstrap 5
* 🌐 HTML / CSS / JavaScript

---

## 🚀 5. Fonctionnalités principales

* 🔐 Authentification sécurisée (login/logout)
* 👥 Gestion des utilisateurs (admin)
* 📅 Prise et gestion des rendez-vous
* ❌ Prévention des conflits (double réservation)
* 🦷 Gestion des consultations :

  * Diagnostic
  * Traitement
  * Notes médicales
* 📊 Dashboards personnalisés par rôle
* 🎨 Interface moderne et responsive

---

## 📁 6. Structure du projet

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

---

## 🛠️ 7. Installation en local (XAMPP)

### Étapes :

1. Cloner le projet :

```
git clone https://github.com/Afousswassim/cabinet-dentaire.git
```

2. Placer le projet dans :

```
htdocs/
```

3. Créer une base de données (ex: `cabinet_dentaire`)

4. Importer le fichier `.sql`

5. Configurer la connexion dans :

```
app/core/Database.php
```

6. Démarrer :

* Apache
* MySQL

7. Accéder au projet :

```
http://localhost/cabinet-dentaire-IL/index.php?route=/login

```

---

## 🌍 8. Accès sans installation

👉 Accès direct en ligne :
https://cabinet-dentaire.infinityfree.me/

---

## 🔒 9. Sécurité

* Sessions PHP
* Hashage des mots de passe (`password_hash`)
* Vérification (`password_verify`)
* Contrôle d’accès par rôle
* Protection des routes

---

## ⚠️ 10. Remarques importantes

* Les mots de passe sont fournis pour test uniquement
* L’application est optimisée pour un usage académique
* Certaines fonctionnalités avancées peuvent être améliorées

---

## 🎯 11. Objectif du projet

Ce projet vise à :

✔ Digitaliser la gestion d’un cabinet dentaire
✔ Améliorer l’organisation des rendez-vous et consultations
✔ Mettre en pratique l’architecture MVC
✔ Créer une interface moderne et intuitive

---

## 👨‍💻 12. Auteur

* Afouss Wassim
* Benziane Marwa
* Ennaimai Aya 
* Projet académique – Filière Informatique

---

## 🚀 13. Améliorations futures

* 📩 Notifications email
* 💳 Module de facturation
* 📈 Statistiques avancées
* 📎 Upload de documents médicaux
* 🔐 Sécurité avancée (2FA)

---

# ✅ Conclusion

Cette application représente une solution moderne et efficace pour la gestion d’un cabinet dentaire, combinant une architecture propre, une interface utilisateur intuitive et des fonctionnalités adaptées aux besoins réels.

---