
<?php
// Test : simuler une partie où l'utilisateur devine tous les bons nombres ou seulement 2 bons
session_start();
$_SESSION['utilisateur_connecte'] = [
    'nom_utilisateur' => 'TestUser'
];

$scenario = isset($_GET['scenario']) ? $_GET['scenario'] : 'tous';
if ($scenario === '2bons') {
    // 2 bons nombres
    $choix_utilisateur = [1, 2, 8, 9, 10];
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
} else {
    // Tous bons
    $choix = [1, 2, 3, 4, 5];
    $_SESSION['resultats_jeu'] = [
        'nombres_aleatoires' => $choix,
        'nombres_utilisateur' => $choix,
        'trouves' => $choix,
        'nb_trouves' => 5,
        'message' => "Résultat : Vous avez deviné les 5 nombres que nous avons générés qui sont '<b>" . implode(' , ', $choix) . "</b>'. Vous êtes un EXCELLENT devin !"
    ];
}
header('Location: resultat-du-jeu.php');
exit();
