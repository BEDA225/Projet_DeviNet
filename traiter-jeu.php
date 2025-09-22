<?php
session_start();
if (!isset($_SESSION['utilisateur_connecte'])) {
    header('Location: connexion-form.php');
    exit();
}

if (isset($_GET['jouer'])) {
    // 1-Stocker les nombres entrés dans le formulaire dans un tableau
    $choixUtilisateur = [];
    $choixUtilisateur[] = $_GET['choix-nbr1'];
    $choixUtilisateur[] = $_GET['choix-nbr2'];
    $choixUtilisateur[] = $_GET['choix-nbr3'];
    $choixUtilisateur[] = $_GET['choix-nbr4'];
    $choixUtilisateur[] = $_GET['choix-nbr5'];
    $choixUtilisateurUniques = array_unique($choixUtilisateur);
    $totalChoixUniques = count($choixUtilisateurUniques);




    // 2-Générer les nombres aléatoires
    $min_nb_aleatoire = 0;
    $max_nb_aleatoire = 4;
    $quantite_choix = 5;
    $choixAleatoire = [];

    // boucle for apres modification 
    for ($i = 0; $i < $quantite_choix; $i++) {
        do {

            $choixAleatoire[] = rand($min_nb_aleatoire, $max_nb_aleatoire);
        } while (in_array($choixAleatoire[$i], $choixAleatoire) && count($choixAleatoire) < 5);
    }

    // Calculer les nombres devinés et générés qui sont communs (uniques)
    $trouves = array_intersect($choixUtilisateurUniques, array_unique($choixAleatoire));
    $nb_trouves = count($trouves);

    // Préparer le message de résultat (exactement comme sur les images)
    // Si tous les chiffres sont identiques (résultat nul) OU tous les chiffres sont des zéros
    if ($totalChoixUniques === 1) {
        $uniqueValue = array_values($choixUtilisateurUniques)[0];
        if ($uniqueValue == 0) {
            $message = "Vous n'avez pas joué ! Veuillez choisir 5 chiffres différents de zéro.";
        } else {
            $message = "Veuillez choisir 5 chiffres différents pour jouer.";
        }
        // Stocker les résultats dans la session pour affichage dans resultat-du-jeu.php
        $_SESSION['resultats_jeu'] = [
            'nombres_aleatoires' => $choixAleatoire,
            'nombres_utilisateur' => $choixUtilisateur,
            'trouves' => [],
            'nb_trouves' => 0,
            'message' => $message
        ];
        header('Location: resultat-du-jeu.php');
        exit();
    }

    if ($nb_trouves === 0) {
        $message = "Vous n'avez deviné aucun des chiffres que nous avons générés ! Réessayez, ça marchera la prochaine fois!";
    } elseif ($nb_trouves === 5) {
        $message = "Résultat : Vous avez deviné les 5 nombres que nous avons générés qui sont '<b>" . implode(' , ', $trouves) . "</b>'. Vous êtes un EXCELLENT devin !";
    } elseif ($nb_trouves === 2 || $nb_trouves === 3 || $nb_trouves === 4) {
        $message = "Résultat : Vous avez deviné $nb_trouves des nombres que nous avons générés qui sont '<b>" . implode(' , ', $trouves) . "</b>'. Vous êtes un BON devin !";
    } else {
        $message = "Résultat : Vous avez deviné $nb_trouves des nombres que nous avons générés qui sont '<b>" . implode(' , ', $trouves) . "</b>'. ";
    }

    // 5-Stocker les résultats dans la session
    $_SESSION['resultats_jeu'] = [
        'nombres_aleatoires' => $choixAleatoire,
        'nombres_utilisateur' => $choixUtilisateur,
        'trouves' => $trouves,
        'nb_trouves' => $nb_trouves,
        'message' => $message
    ];

    // 6-Rediriger vers la page de résultats
    header('Location: resultat-du-jeu.php');
    exit();
}
