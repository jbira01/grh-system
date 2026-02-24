
```markdown
<div align="center">
  
  # 🚀 GRH-System
  **Système Intégré de Gestion des Ressources Humaines (ERP)**

  [![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php)](https://www.php.net/)
  [![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
  [![Filament](https://img.shields.io/badge/Filament-FBBF24?logo=laravel&logoColor=black)](https://filamentphp.com)
  [![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
  [![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

  *Projet de Fin d'Études (PFE) - Développé par Yasser Jabir (OFPPT)*

</div>

<br>

## 📖 À propos du projet

**GRH-System** est une application web centralisée conçue pour automatiser et optimiser les processus administratifs des ressources humaines. Développée avec la stack **TALL** (Tailwind, Alpine.js, Laravel, Livewire) et **FilamentPHP**, elle offre une interface d'administration robuste et une expérience utilisateur fluide.

Ce projet résout les problématiques de gestion manuelle en dématérialisant les dossiers du personnel, le suivi du temps de travail, les absences et la génération de la paie.

## ✨ Fonctionnalités Principales

🔐 **Sécurité & Contrôle d'Accès (RBAC)**
- Rôles stricts : `Administrateur` et `Employé` (propulsé par Spatie Permissions).
- Isolation des données : un employé n'a accès qu'à son propre espace.

👥 **Gestion du Personnel**
- Opérations CRUD complètes sur les dossiers des employés.
- Suivi des contrats, départements et postes.

⏱️ **Système de Pointage Temps Réel**
- Widget interactif pour pointer l'arrivée et le départ.
- Horodatage sécurisé côté serveur (anti-fraude).
- Exportation Excel (`.xlsx`) des présences pour la comptabilité.

🏖️ **Gestion des Congés**
- Flux de demande de congés par les employés.
- Validation, refus et suivi des soldes par l'administration.

📄 **Gestion de la Paie**
- Calcul automatisé des salaires.
- Génération de bulletins de paie au format PDF.

## 🛠️ Stack Technique

- **Backend :** Laravel 11.x, PHP 8.2+
- **Frontend / Panel Admin :** FilamentPHP v3, Livewire v3, Alpine.js, Tailwind CSS
- **Base de données :** MySQL
- **Packages clés :** `spatie/laravel-permission`, `pxlrbt/filament-excel`, `barryvdh/laravel-dompdf`

---

## 🚀 Guide d'Installation

Suivez ces étapes pour installer le projet en local (idéalement sous [Laragon](https://laragon.org/)).

### 1. Prérequis
Assurez-vous d'avoir installé sur votre machine :
- PHP >= 8.2 (avec l'extension `gd` activée)
- Composer
- Node.js & NPM
- MySQL

### 2. Cloner le dépôt
```bash
git clone [https://github.com/VOTRE_NOM_UTILISATEUR/grh-system.git](https://github.com/VOTRE_NOM_UTILISATEUR/grh-system.git)
cd grh-system

```

### 3. Installer les dépendances

```bash
composer install
npm install
npm run build

```

### 4. Configuration de l'environnement

Copiez le fichier d'exemple et générez la clé de l'application :

```bash
cp .env.example .env
php artisan key:generate

```

Configurez votre fichier `.env` avec vos identifiants de base de données :

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grh_system
DB_USERNAME=root
DB_PASSWORD=

```

### 5. Migration et Jeu d'essai (Seeding)

Créez la base de données `grh_system` dans votre SGBD, puis lancez les migrations avec le seeder pour créer l'architecture et les comptes par défaut :

```bash
php artisan migrate:fresh --seed

```

### 6. Lier le stockage (Pour les PDF et images)

```bash
php artisan storage:link

```

---

## 🔑 Identifiants de Test (Générés par le Seeder)

Le système génère automatiquement deux comptes pour évaluer les différents rôles. Accédez au panel d'administration via : `http://votre-domaine-local/app/login`

| Rôle | Email | Mot de passe | Accès |
| --- | --- | --- | --- |
| **Administrateur** | `admin@grh.com` | `password123` | Accès total (Panel complet) |

---


## 👨‍💻 Auteur

**Yasser Jabir**

* Projet réalisé dans le cadre du cursus de Développement Digital Full Stack.

---


