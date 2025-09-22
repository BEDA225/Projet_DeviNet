<?php
// verification-nom-utilisateur.php
// Pour la vérification AJAX du nom d'utilisateur

// Démarrer la session pour éviter les conflits
session_start();

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
} catch (Exception $e) {
   echo '';
    
}

// Fonction pour vérifier si l'utilisateur existe (POO)
function verifierUtilisateurExiste($nom_utilisateur): bool
{
    //Récupérer des données de la base de données
    $recevoirDonnees = new recevoirDonnees(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR);
    $requete_recevoir = "SELECT nom_utilisateur FROM " . NOM_TABLE . " WHERE nom_utilisateur = '" . $nom_utilisateur . "'";
    $recevoirDonnees->sauvegarderDonnees(
        $requete_recevoir,
        NOM_BASEDEDONNEES,
        NOM_TABLE
    );

    if ($recevoirDonnees->recevoirNombreDeLignes() === 0) {
        $reponse = false; // Non, n'existe pas
    } else {
        $reponse = true; // Oui, existe
    }
    return $reponse;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = trim($_POST['nom_utilisateur'] ?? '');

    if (empty($nom_utilisateur)) {
        echo '';
        exit();
    }

    try {
        // Utilisation de la logique POO
        if (verifierUtilisateurExiste($nom_utilisateur)) {
            // Message d'erreur stylé Tailwind
            echo '<span class="block p-2 bg-red-100 text-red-700 border border-red-200 rounded">Le nom d\'utilisateur <b>' . htmlspecialchars($nom_utilisateur) . '</b> existe déjà.</span>';
        } else {
            // Message de succès stylé Tailwind
            echo '<span class="block p-2 bg-green-100 text-green-700 border border-green-200 rounded">Ce nom d\'utilisateur est disponible.</span>';
        }
    } catch (Exception $e) {
        echo '<span class="block p-2 bg-orange-100 text-orange-700 border border-orange-200 rounded">Erreur : ' . htmlspecialchars($e->getMessage()) . '<br>Fichier : ' . htmlspecialchars($e->getFile()) . ' à la ligne : ' . $e->getLine() . '</span>';
    }
}
