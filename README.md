# DeviNet

## Présentation du projet
DeviNet est une application web développée en PHP qui propose un jeu de devinette interactif avec gestion des utilisateurs. Les participants peuvent s'inscrire, se connecter, et jouer à un jeu où ils doivent deviner un nombre ou une valeur générée aléatoirement par le serveur. Le projet met l'accent sur la sécurité (hachage des mots de passe), l'expérience utilisateur (vérification AJAX du nom d'utilisateur), et une structure orientée objet pour la gestion de la base de données.

Projet PHP de jeu de devinette avec gestion d'utilisateurs.

## Fonctionnalités principales
- Inscription et connexion des utilisateurs
- Vérification du nom d'utilisateur avec AJAX
- Jeu de devinette interactif
- Gestion sécurisée des mots de passe (hachage)
- Structure orientée objet pour la base de données

## Structure du projet
- `index.php` : Page d'accueil
- `inscription-form.php` : Formulaire d'inscription
- `connexion-form.php` : Formulaire de connexion
- `jeu-devinette.php` : Jeu principal
- `gestiondb.php` : Classes pour la gestion de la base de données
- `traiter-inscription.php` : Traitement de l'inscription
- `traiter-connexion.php` : Traitement de la connexion
- `main.js` : Scripts JS (AJAX, interactions)
- `config.php` : Configuration de la base de données
- `db_structure.sql` : Structure SQL de la base

## Installation
1. Cloner le projet ou copier les fichiers dans votre serveur local (WAMP/XAMPP).
2. Importer le fichier `db_structure.sql` dans votre base de données MySQL.
3. Configurer les accès à la base dans `config.php`.
4. Accéder à `index.php` via votre navigateur.

## Auteur
Eric BEDA
- Email : a.anazet1@gmail.com
- GitHub : [github.com/beda225](https://github.com/beda225)
- LinkedIn : [linkedin.com/in/anazet-beda](www.linkedin.com/in/beda225)

## Licence
Projet libre d'utilisation à des fins pédagogiques.
