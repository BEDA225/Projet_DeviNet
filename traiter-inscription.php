<?php
// traiter-inscription.php
// Traitement du formulaire d'inscription en orienté objet

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

// Fonction pour vérifier si l'utilisateur existe
function estCeQueUtilisateurExiste($nom_utilisateur): bool
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
    } else if ($recevoirDonnees->recevoirNombreDeLignes() > 0) {
        $reponse = true; // Oui, existe
    }
    return $reponse;
}

// Fonction pour valider les mots de passe
function validerMotDePasse($mot_de_passe, $confirmer_mot_de_passe): bool
{
    // Vérifier que les mots de passe sont identiques
    if ($mot_de_passe !== $confirmer_mot_de_passe) {
        return false;
    }
    return true;
}

// Fonction pour inscrire reussie
function inscrireUtilisateur($nom_utilisateur, $mot_de_passe): bool
{
    // Hachage du mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Utilisation de la classe orientée objet pour insérer le nouvel utilisateur
    $envoyerDonnees = new envoyerDonnees(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR);

    // Requête d'insertion
    $requete_insertion = "INSERT INTO " . NOM_TABLE . " (nom_utilisateur, mot_de_passe, date_creation) VALUES ('" . $nom_utilisateur . "', '" . $mot_de_passe_hash . "', NOW())";

    // Envoyer les données
    $envoyerDonnees->envoyerDonnees(
        $requete_insertion,
        NOM_BASEDEDONNEES,
        NOM_TABLE
    );

    return true;
}

// Vérifier que le formulaire a été soumis via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: inscription-form.php');
    exit();
}

// Récupération et validation des données du formulaire
$nom_utilisateur = trim($_POST['nom_utilisateur'] ?? '');
$mot_de_passe = $_POST['mot_de_passe'] ?? '';
$confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'] ?? '';

// Vérifier que tous les champs sont remplis
if (empty($nom_utilisateur) && empty($mot_de_passe) && empty($confirmer_mot_de_passe)) {
    $_SESSION['erreurs_inscription'] = ["Tous les champs sont obligatoires. Veuillez remplir tous les champs."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    header('Location: inscription-form.php');
    exit();
} else if (empty($nom_utilisateur)) {
    $_SESSION['erreurs_inscription'] = [" Veuillez remplir le nom d'utilisateur."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    $_SESSION['focus_champ'] = 'nom_utilisateur';
    header('Location: inscription-form.php');
    exit();
} else if (empty($mot_de_passe)) {
    $_SESSION['erreurs_inscription'] = [" Veuillez remplir le mot de passe."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    $_SESSION['focus_champ'] = 'mot_de_passe';
    header('Location: inscription-form.php');
    exit();
} else if (empty($confirmer_mot_de_passe)) {
    $_SESSION['erreurs_inscription'] = [" Veuillez confirmer le mot de passe."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    $_SESSION['focus_champ'] = 'confirmer_mot_de_passe';
    header('Location: inscription-form.php');
    exit();
}

// Validation du nom d'utilisateur avec REGEX
if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $nom_utilisateur)) {
    $_SESSION['erreurs_inscription'] = ["Le nom d'utilisateur doit contenir entre 3 et 20 caractères (lettres, chiffres, - et _ uniquement)."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    $_SESSION['focus_champ'] = 'nom_utilisateur';
    header('Location: inscription-form.php');
    exit();
}

// Vérifier la longueur du nom d'utilisateur
/*if (strlen($nom_utilisateur) < 3 || strlen($nom_utilisateur) > 20) {
    $_SESSION['erreurs_inscription'] = ["Le nom d'utilisateur doit contenir entre 3 et 20 caractères."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    $_SESSION['focus_champ'] = 'nom_utilisateur';
    header('Location: inscription-form.php');
    exit();
}*/

// Validation du mot de passe avec REGEX
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/', $mot_de_passe)) {
    $_SESSION['erreurs_inscription'] = ["Le mot de passe doit contenir au moins 6 caractères avec au moins une minuscule, une majuscule et un chiffre."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    $_SESSION['focus_champ'] = 'mot_de_passe';
    header('Location: inscription-form.php');
    exit();
}

// Vérifier que les mots de passe sont identiques
/*if ($mot_de_passe !== $confirmer_mot_de_passe) {
    $_SESSION['erreurs_inscription'] = ["Les mots de passe différents."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    $_SESSION['focus_champ'] = 'mot_de_passe';
    header('Location: inscription-form.php');
    exit();
}*/

try {
    //Valider 'Nom utilisateur' - vérifier s'il existe déjà
    if (estCeQueUtilisateurExiste($nom_utilisateur)) {
        $msg = "Échec d'inscription! Le nom d'utilisateur '$nom_utilisateur' existe déjà.";
        $_SESSION['erreurs_inscription'] = [$msg];
        $_SESSION['old_utilisateur'] = $nom_utilisateur;
        header("Location: inscription-form.php");
        exit();
    }

    // valider les mots de passe

    if (!validerMotDePasse($mot_de_passe, $confirmer_mot_de_passe)) {
        $msg = "Échec d'inscription! 'mots de passe' et 'confirmer mot de passe' ne correspondent pas.";
        $_SESSION['erreurs_inscription'] = [$msg];
        $_SESSION['old_utilisateur'] = $nom_utilisateur;
        $_SESSION['focus_champ'] = 'mot_de_passe';
        header('Location: inscription-form.php');
        exit();
    }

    // valider l'inscription
    if (!inscrireUtilisateur($nom_utilisateur, $mot_de_passe)) {
        $msg = "Échec d'inscription! Veuillez réessayer.";
        $_SESSION['erreurs_inscription'] = [$msg];
        $_SESSION['old_utilisateur'] = $nom_utilisateur;
        header('Location: inscription-form.php');
        exit();
    } else {
        // Réinitialiser les champs de saisie
        // Inscription réussie avec message de succes au nom d'utilisateur
        $_SESSION['old_utilisateur'] = '';
        $_SESSION['focus_champ'] = '';
        $msg = "Inscription réussie ! Bienvenue $nom_utilisateur. Vous pouvez maintenant vous connecter.";
        $_SESSION['succes_inscription'] = $msg;
        header('Location: connexion-form.php');
        exit();
    }

    
} catch (Exception $erreur) {
    // Erreur lors du traitement
    $_SESSION['erreurs_inscription'] = ["Erreur lors de l'inscription. Veuillez réessayer."];
    $_SESSION['old_utilisateur'] = $nom_utilisateur;
    header('Location: inscription-form.php');
    exit();
}
