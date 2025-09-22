<?php
// deconnexion.php - Déconnexion utilisateur
session_start();

// Vérifier si l'utilisateur était vraiment connecté
$etait_connecte = isset($_SESSION['utilisateur_connecte']);

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Supprimer le cookie de session si il existe
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redémarrer une nouvelle session pour le message
session_start();

// Afficher le message approprié
if ($etait_connecte) {
    $_SESSION['succes_connexion'] = "Vous avez été déconnecté avec succès.";
} else {
    $_SESSION['erreurs_connexion'] = ["Aucune session active trouvée."];
}

// Rediriger vers la page de connexion
header('Location: connexion-form.php');
exit();
