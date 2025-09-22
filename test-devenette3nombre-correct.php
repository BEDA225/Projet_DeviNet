 <?php
    session_start();
    $_SESSION['utilisateur_connecte'] = [
        'nom_utilisateur' => 'Test3'
    ];

    $scenario = isset($_GET['scenario']) ? $_GET['scenario'] : 'trois';
    // 2 bons nombres
    $choix_utilisateur = [1, 2, 5, 9, 10];
    $choix_aleatoire = [1, 2, 3, 4, 5];
    $trouves = array_intersect($choix_utilisateur, $choix_aleatoire);
    $nb_trouves = count($trouves);
    $message = "Résultat : Vous avez deviné $nb_trouves des nombres que nous avons générés qui sont '<b>" . implode(' , ', $trouves) . "</b>'. Vous êtes un BON devin !";
    $_SESSION['resultats_jeu'] = [
        'nombres_aleatoires' => $choix_aleatoire,
        'nombres_utilisateur' => $choix_utilisateur,
        'trouves' => $trouves,
        'nb_trouves' => $nb_trouves,
        'message' => $message
    ];
    header('Location: resultat-du-jeu.php');
    exit();
