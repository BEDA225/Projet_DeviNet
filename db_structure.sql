-- db_structure.sql
-- Structure de la base de données pour le jeu de devinette

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS jeu_devinette;
USE jeu_devinette;

-- Créer la table des comptes utilisateurs
CREATE TABLE IF NOT EXISTS compte_utilisateur( 
    id INT(5) PRIMARY KEY AUTO_INCREMENT,
    nom_utilisateur VARCHAR(50) NOT NULL UNIQUE, 
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Insérer des données de test
insert into compte_utilisateur (
   nom_utilisateur,
   mot_de_passe
) values ( 'sonic12345',
           '$2y$10$AMyb4cbGSWSvEcQxt91ZVu5r5OV7/3mMZl7tn8wnZrJ1ddidYfVYW' ); 

-- Corresponding password in PHP | Mot de passe correspondant dans le code PHP
-- $passCode=password_hash('helloquebec', PASSWORD_DEFAULT);
insert into compte_utilisateur (
   nom_utilisateur,
   mot_de_passe
) values ( 'asterix2023',
           '$2y$10$Lpd3JsgFW9.x2ft6Qo9h..xmtm82lmSuv/vaQKs9xPJ4rhKlMJAF.' ); 

-- Corresponding password in PHP | Mot de passe correspondant dans le code PHP
-- $passCode=password_hash('hellocanada', PASSWORD_DEFAULT);
insert into compte_utilisateur (   nom_utilisateur,   mot_de_passe
) values ( 'pokemon527', '$2y$10$FRAyAIK6.TYEEmbOHF4JfeiBCdWFHcqRTILM7nF/7CPjE3dNEWj3W' );
