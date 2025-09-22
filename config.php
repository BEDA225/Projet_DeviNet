<?php
// config.php
// Fichier de configuration pour la connexion à la base de données
// Contient les fonctions utilitaires pour la gestion des connexions

// Configuration de la base de données
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('NAME', 'jeu_devinette');


function getDbConnection()
{
    try {
        // Création de la connexion MySQLi
        $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, NAME);

        // Vérification de la connexion
        if ($mysqli->connect_error) {
            throw new Exception("Erreur de connexion : " . $mysqli->connect_error);
        }

        // Configuration de l'encodage UTF-8
        $mysqli->set_charset("utf8");

        return $mysqli;
    } catch (Exception $e) {
        throw new Exception("Impossible de se connecter à la base de données : " . $e->getMessage());
    }
}


function closeDbConnection($mysqli)
{
    if ($mysqli && !$mysqli->connect_error) {
        $mysqli->close();
    }
}
