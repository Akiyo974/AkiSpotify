# AkiSpotify

AkiSpotify est un projet de plateforme de streaming musical en ligne inspiré de Spotify. Le site permet aux utilisateurs d'explorer, d'aimer des chansons, de créer des comptes et d'administrer les contenus disponibles. Le projet inclut également un panneau d'administration pour gérer les utilisateurs, les albums, et les artistes.

## Fonctionnalités

- **Création de Compte et Connexion :** Inscription, connexion et déconnexion des utilisateurs.
- **Écoute de Musique :** Lecture de fichiers audio (fournis dans le répertoire `audio`).
- **Chansons Aimées :** Possibilité d'ajouter et retirer des chansons des titres aimés.
- **Panneau d'Administration :** Gestion des utilisateurs, des artistes, des albums et des musiques (ajout, modification, suppression).
- **Navigation Sécurisée :** Gestion des URL avec `.htaccess`.

## Structure du Projet

### Frontend
- **HTML/CSS/JavaScript :** Le frontend est construit à l'aide de HTML pour la structure, CSS pour le style (`style.css`), et JavaScript (`script.js`) pour les interactions.

### Backend
- **PHP :** Le backend utilise PHP pour gérer les fonctionnalités du site, comme l'inscription (`inscription.php`), la connexion (`connexion.php`), et la gestion de la base de données (`database.php`).
- **SQL :** Les données sont stockées dans une base MySQL, avec un fichier SQL (`AkiSpotify.sql`) fourni pour créer les tables nécessaires.

### Administration
- **Panneau Admin :** Accessible pour gérer les utilisateurs, artistes, albums et musiques, avec des fonctionnalités d'ajout, de mise à jour et de suppression (`admin`).

### Fichiers Audio
- **Répertoire Audio :** Le répertoire `audio` contient des fichiers `.mp3` pour différentes catégories (par exemple, `christmas`, `brothers`, `duet`). Les musiques peuvent être ajoutées par l'administrateur via le panneau d'administration.
