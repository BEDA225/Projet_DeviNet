<?php
// index.php
// Page d'accueil qui redirige vers la page de connexion

session_start();

// Si l'utilisateur est déjà connecté, le rediriger vers le jeu
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: jeu-devinette.php');
    exit();
}

// Sinon, rediriger vers la page d'inscription
header('Location: inscription-form.php');
exit();
