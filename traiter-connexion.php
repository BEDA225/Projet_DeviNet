<?php
// traiter-connexion.php
// Traitement du formulaire de connexion en orienté objet

session_start();

// Activer les exceptions MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
    // Ignorer les erreurs de création silencieusement
}

// Fonction pour vérifier les identifiants de connexion
function verifierConnexion($nom_utilisateur, $mot_de_passe): array
{
    try {
        $recevoirDonnees = new recevoirDonnees(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR);
        // Sécurisation du nom d'utilisateur contre l'injection SQL
        $mysqli = new mysqli(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR, NOM_BASEDEDONNEES);
        $nom_utilisateur_safe = $mysqli->real_escape_string($nom_utilisateur);
        $mysqli->close();
        $requete_recevoir = "SELECT id, nom_utilisateur, mot_de_passe FROM " . NOM_TABLE . " WHERE nom_utilisateur = '" . $nom_utilisateur_safe . "' LIMIT 1";
        $donnees = $recevoirDonnees->sauvegarderDonnees(
            $requete_recevoir,
            NOM_BASEDEDONNEES,
            NOM_TABLE
        );

        if ($recevoirDonnees->recevoirNombreDeLignes() === 0) {
            return ['succes' => false, 'message' => "Echec de connexion! Nom d'utilisateur invalide. Veuillez réessayer."];
        }

        $utilisateur = $donnees[0];

        // Vérifier le mot de passe
        if (password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
            return [
                'succes' => true,
                'utilisateur' => [
                    'id' => $utilisateur['id'],
                    'nom_utilisateur' => $utilisateur['nom_utilisateur']
                ]
            ];
        } else {
            return ['succes' => false, 'message' => "Echec de connexion! Mot de passe incorrect. Veuillez réessayer."];
        }
    } catch (Exception $e) {
        return ['succes' => false, 'message' => "Erreur de connexion à la base de données."];
    }
}

// la logique de la connexion 
try {
    // Vérifier que le formulaire a été soumis via POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: connexion-form.php');
        exit();
    }

    // Récupération et validation des données du formulaire
    $nom_utilisateur = trim($_POST['nom_utilisateur'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    // Vérifier que tous les champs sont remplis
    if (empty($nom_utilisateur) || empty($mot_de_passe)) {
        $_SESSION['erreurs_connexion'] = ["Tous les champs sont obligatoires."];
        $_SESSION['old_utilisateur'] = $nom_utilisateur;
        $_SESSION['focus_champ'] = empty($nom_utilisateur) ? 'nom_utilisateur' : 'mot_de_passe';
        header('Location: connexion-form.php');
        exit();
    }

    // Vérifier les identifiants
    $resultat_connexion = verifierConnexion($nom_utilisateur, $mot_de_passe);

    if ($resultat_connexion['succes']) {
        // Connexion réussie
        $_SESSION['utilisateur_connecte'] = $resultat_connexion['utilisateur'];
        $_SESSION['nom_utilisateur_connecte'] = $nom_utilisateur;
        // Rediriger vers une page d'accueil ou tableau de bord
        header('Location: jeu-devinette.php'); // ou toute autre page de votre choix
        exit();
    } else {
        // Connexion échouée
        $_SESSION['erreurs_connexion'] = [$resultat_connexion['message']];
        $_SESSION['old_utilisateur'] = $nom_utilisateur;
        $_SESSION['focus_champ'] = 'mot_de_passe';
        header('Location: connexion-form.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['erreurs_connexion'] = ["Erreur inattendue lors de la connexion. Veuillez réessayer."];
    header('Location: connexion-form.php');
    exit();
}
