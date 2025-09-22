<?php
session_start();

// session_start() déjà appelé en haut du fichier
date_default_timezone_set('America/Toronto'); // ou 'Europe/Paris' pour la France
if (!isset($_SESSION['utilisateur_connecte'])) {
    header('Location: connexion-form.php');
    exit();
}
$afficher_message = false;
$nom_utilisateur = '';
if (isset($_SESSION['nom_utilisateur_connecte'])) {
    $afficher_message = true;
    $nom_utilisateur = $_SESSION['nom_utilisateur_connecte'];
    unset($_SESSION['nom_utilisateur_connecte']);
}


?>

<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats du Jeu - DeviNet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>



<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex flex-col justify-between">
    <main class="flex flex-col items-center justify-center flex-1 py-8">
        <?php
        // Affichage date et nom utilisateur comme sur la page du jeu
        $nom_afficher = '';
        if (isset($_SESSION['utilisateur_connecte']['nom_utilisateur'])) {
            $nom_afficher = $_SESSION['utilisateur_connecte']['nom_utilisateur'];
        } elseif (!empty($nom_utilisateur)) {
            $nom_afficher = $nom_utilisateur;
        }
        echo "<div class='flex items-center justify-center gap-6 py-2 px-4 rounded-xl mb-4 bg-gradient-to-r from-indigo-100 via-blue-100 to-indigo-200 border border-indigo-300 shadow text-indigo-700 font-medium text-lg'>";
        echo "<span>Date : " . date("Y-m-d H:i:s") . "</span>";
        echo "<span class='border-l border-indigo-300 pl-4'>Utilisateur : " . htmlspecialchars($nom_afficher) . "</span>";
        echo "</div>";
        // Récupérer les résultats du jeu depuis la session
        $resultats = null;
        if (isset($_SESSION['resultats_jeu'])) {
            $resultats = $_SESSION['resultats_jeu'];
            unset($_SESSION['resultats_jeu']);
        } else {
            // Redirige automatiquement si aucun résultat n'est disponible
            header('Location: jeu-devinette.php');
            exit();
        }
        ?>
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-8 border border-indigo-100 mx-auto px-2">
            <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center tracking-tight">Résultats du Jeu de Devinette</h1>
            <div class="mb-6 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                <?php if (is_array($resultats) && isset($resultats['nombres_aleatoires'], $resultats['nombres_utilisateur'], $resultats['nb_trouves'], $resultats['message'])): ?>
                    <p class="mb-2 text-gray-700"><span class="font-semibold text-indigo-600">Nombres générés :</span> <span class="font-bold text-gray-900"> <?php echo implode(' , ', $resultats['nombres_aleatoires']); ?> </span></p>
                    <p class="mb-2 text-gray-700"><span class="font-semibold text-indigo-600">Vos choix :</span> <span class="font-bold text-gray-900"> <?php echo implode(' , ', $resultats['nombres_utilisateur']); ?> </span></p>
                    <div class="mt-4">
                        <span class="block text-lg font-medium <?php echo ($resultats['nb_trouves'] === 5) ? 'text-green-600' : (($resultats['nb_trouves'] === 0) ? 'text-red-600' : 'text-yellow-700'); ?>">
                            <?php echo $resultats['message']; ?>
                        </span>
                    </div>
                <?php else: ?>
                    <p class="text-red-600 font-semibold">Aucun résultat de jeu à afficher. Veuillez jouer d'abord.</p>
                <?php endif; ?>
            </div>
            <div class="flex justify-center gap-4 mt-4">
                <a href="jeu-devinette.php" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition">Essayez encore!</a>
                <a href="deconnexion.php" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg border border-gray-300 transition">SE DÉCONNECTER</a>
            </div>
        </div>
    </main>
    <footer class="bg-white border-t border-indigo-100 py-4 mt-8">
        <div class="max-w-xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2 px-4 text-sm text-gray-500">
            <div>
                <p>&copy; <?php echo date("Y"); ?> DeviNet by <span class="font-semibold text-indigo-700">Eric BEDA</span>. Tous droits réservés.</p>
            </div>
            <div class="flex flex-col md:flex-row md:gap-4 gap-1">
                <span>Contact: <a class="text-indigo-600 hover:underline" href="mailto:a.anazet1@gmail.com">a.anazet1@gmail.com</a></span>
                <span>GitHub: <a class="text-indigo-600 hover:underline" href="https://github.com/beda225">github.com/beda225</a></span>
                <span>LinkedIn: <a class="text-indigo-600 hover:underline" href="https://www.linkedin.com/in/anazet-beda">linkedin.com/in/anazet-beda</a></span>
            </div>
        </div>
    </footer>
</body>

</html>