<?php
session_start();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex flex-col justify-between">
    <main class="flex flex-col items-center justify-center flex-1 py-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 border border-indigo-100 mx-auto px-2">
            <h2 class="text-2xl font-bold text-indigo-700 mb-4 text-center">Se connecter à son compte utilisateur</h2>
            <p class="text-gray-700 text-center mb-2">Veuillez remplir le formulaire ci-dessous pour vous connecter.</p>
            <p class="text-gray-500 text-center mb-4">Si vous n'avez pas encore de compte, cliquez sur <span class="font-semibold text-indigo-600">S'inscrire</span> pour créer un compte.</p>
            <?php
            if (isset($_SESSION['erreurs_connexion'])) {
                echo '<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">';
                echo '<h4 class="font-semibold mb-2">Erreurs :</h4><ul class="list-disc pl-5">';
                foreach ($_SESSION['erreurs_connexion'] as $erreur) {
                    echo '<p>' . htmlspecialchars($erreur) . '</p>';
                }
                echo '</ul></div>';
                unset($_SESSION['erreurs_connexion']);
            }
            // Afficher le message de confirmation d'inscription réussie
            if (isset($_SESSION['succes_inscription'])) {
                echo '<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">';
                echo htmlspecialchars($_SESSION['succes_inscription']);
                echo '</div>';
                unset($_SESSION['succes_inscription']);
            }
            if (isset($_SESSION['succes_connexion'])) {
                echo '<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">';
                echo htmlspecialchars($_SESSION['succes_connexion']);
                echo '</div>';
                unset($_SESSION['succes_connexion']);
            }
            ?>
            <form action="traiter-connexion.php" method="post" class="space-y-6 mt-4">
                <div>
                    <label for="nom_utilisateur" class="block text-sm font-medium text-gray-600 mb-1">Nom d'utilisateur</label>
                    <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="<?php echo isset($_SESSION['old_utilisateur']) ? htmlspecialchars($_SESSION['old_utilisateur']) : ''; ?>" onkeyup="verifierUtilisateurALaConnexion()" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <div id="message_ajax_connexion" class="text-xs mt-1"></div>
                </div>
                <div>
                    <label for="mot_de_passe" class="block text-sm font-medium text-gray-600 mb-1">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div class="flex justify-center gap-4 mt-4">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition">Se connecter</button>
                    <button type="button" onclick="window.location.href='inscription-form.php'" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg border border-gray-300 transition">S'inscrire</button>
                </div>
                <?php
                if (isset($_SESSION['old_utilisateur'])) {
                    unset($_SESSION['old_utilisateur']);
                }
                if (isset($_SESSION['old_mot_de_passe'])) {
                    unset($_SESSION['old_mot_de_passe']);
                }
                ?>
            </form>
        </div>
    </main>
    <footer class="bg-white border-t border-indigo-100 py-4 mt-8">
        <div class="max-w-md mx-auto flex flex-col md:flex-row items-center justify-between gap-2 px-4 text-sm text-gray-500">
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
    <script src="main.js"></script>
    <?php
    if (isset($_SESSION['focus_champ'])) {
        echo "<script>";
        echo "window.addEventListener('load', function() {";
        echo "    const champ = document.getElementById('" . $_SESSION['focus_champ'] . "');";
        echo "    if (champ) { champ.focus(); }";
        echo "});";
        echo "</script>";
        unset($_SESSION['focus_champ']);
    }
    ?>
</body>