<?php
// verification-nom-utilisateur-connexion.php
// Pour la vérification AJAX du nom d'utilisateur lors de la connexion

// Désactiver l'affichage des erreurs pour l'AJAX
error_reporting(0);
ini_set('display_errors', 0);

require_once 'gestiondb.php';

// Configuration de la base de données
define('NOM_SERVEUR', 'localhost');
define('UTILISATEUR_SERVEUR', 'root');
define('MOTDEPASSE_SERVEUR', '');
define('NOM_BASEDEDONNEES', 'jeu_devinette');
define('NOM_TABLE', 'compte_utilisateur');

// Créer la structure de la base de données si elle n'existe pas (silencieusement)
try {
    $creerStructure = new creerStructure(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR);
    $creerStructure->creeAdresseFichier("db_structure.sql");
} catch (Exception $erreur) {
}

// Fonction pour vérifier si l'utilisateur existe (POO)
function verifierUtilisateurExistePourConnexion($nom_utilisateur): bool
{
    try {
        $recevoirDonnees = new recevoirDonnees(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR);
        $requete_recevoir = "SELECT nom_utilisateur FROM " . NOM_TABLE . " WHERE nom_utilisateur = '" . $nom_utilisateur . "'";
        $recevoirDonnees->sauvegarderDonnees(
            $requete_recevoir,
            NOM_BASEDEDONNEES,
            NOM_TABLE
        );

        return $recevoirDonnees->recevoirNombreDeLignes() > 0;
    } catch (Exception $e) {
        return false;
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = trim($_POST['nom_utilisateur'] ?? '');
    if (empty($nom_utilisateur)) {
        echo '';
        exit();
    }
    try {
        if (verifierUtilisateurExistePourConnexion($nom_utilisateur)) {
            echo 'EXISTE';
        } else {
            // Ici, le message 'NON_EXISTE' est renvoyé au JS pour afficher l'alerte "Nom d'utilisateur invalide" côté client
            echo 'NON_EXISTE';
        }
    } catch (Exception $e) {
        echo '';
    }
}
