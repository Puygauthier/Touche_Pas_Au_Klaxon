# Touche Pas Au Klaxon

Application intranet en **PHP (MVC)** pour organiser le covoiturage entre agences d’une entreprise.

## Structure du projet
Touche_Pas_Au_Klaxon/
├── app/
│   ├── controllers/
│   ├── core/
│   │   ├── Autoloader.php
│   │   ├── Database.php
│   │   └── Router.php
│   ├── models/
│   ├── views/
│   └── routes.php
├── public/
│   ├── index.php
│   └── css/
│       └── style.css
├── tests/                 (optionnel)
├── composer.json          (si utilisé)
└── README.md

## Prérequis
- Windows + WampServer (Apache + MySQL/MariaDB + PHP)
- PHP 8.3+ (Wamp fournit php.exe)
- Navigateur web
- (Optionnel) Visual Studio Code

Base de données attendue : `covoiturage`
Identifiants par défaut Wamp : utilisateur `root` — mot de passe (vide)

## Installation (base de données)
1. Ouvrir phpMyAdmin : http://localhost/phpmyadmin/
2. Créer la base `covoiturage` (collation recommandée : `utf8mb4_general_ci`).
3. Importer vos tables/données (dump SQL) en vérifiant que l’**encodage du fichier est UTF-8**.

## Lancement (serveur PHP intégré)
Dans la **racine du projet** exécuter :
"C:\wamp64\bin\php\php8.3.14\php.exe" -S localhost:8000 -t public

Puis ouvrir : http://localhost:8000
(Arrêter le serveur : Ctrl + C dans le terminal)

## Encodage & UTF-8 (déjà configuré)
- `public/index.php` envoie : header('Content-Type: text/html; charset=UTF-8');
- `app/views/layout.php` contient : <meta charset="UTF-8">
- `app/core/Database.php` : DSN avec `charset=utf8mb4` + commande `SET NAMES utf8mb4`.
- Recommandé côté MySQL/MariaDB :
  ALTER DATABASE covoiturage CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

## Routes de test
/           — accueil
/users      — liste des utilisateurs
/agences    — liste des agences
/trajets    — liste des trajets

## Dépannage rapide
- PHP non reconnu : utiliser le chemin complet (commande ci-dessus) ou ajouter `C:\wamp64\bin\php\php8.3.14` au PATH Windows.
- Accents mal affichés après import ancien : forcer utf8mb4 (base/tables), puis corriger les données existantes si besoin :
  UPDATE utilisateurs
  SET
    nom    = REPLACE(REPLACE(nom,    '├¿', 'è'), '├®', 'é'),
    prenom = REPLACE(REPLACE(prenom, '├¿', 'è'), '├®', 'é');

## (Optionnel) Exécuter sous Wamp/Apache (VirtualHost 8081)
Éditer : C:\wamp64\bin\apache\apache*\conf\extra\httpd-vhosts.conf
Ajouter :

<VirtualHost *:8081>
    ServerName localhost
    DocumentRoot "C:/Users/puyga/Documents/Touche_Pas_Au_Klaxon/public"
    <Directory "C:/Users/puyga/Documents/Touche_Pas_Au_Klaxon/public">
        AllowOverride All
        Require all granted
        Options Indexes FollowSymLinks
    </Directory>
    ErrorLog "logs/tpak-error.log"
    CustomLog "logs/tpak-access.log" common
</VirtualHost>

Puis Wamp → Restart All Services → http://localhost:8081/

## Technologies
- PHP 8.3
- Architecture MVC
- HTML / CSS (Bootstrap)
- (Optionnel) PHPUnit & Composer

## Auteur
Projet réalisé par **Nathalie Puygauthier**, formation développeur web, 2025.
