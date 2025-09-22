<?php
session_start();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex flex-col justify-between">
    <main class="flex flex-col items-center justify-center flex-1 py-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 border border-indigo-100 mx-auto px-2">
            <h2 class="text-2xl font-bold text-indigo-700 mb-4 text-center">Créer un compte utilisateur</h2>
            <p class="text-gray-700 text-center mb-2">Veuillez remplir le formulaire ci-dessous pour vous inscrire.</p>
            <p class="text-gray-500 text-center mb-4">Si vous avez déjà un compte, cliquez sur <span class="font-semibold text-indigo-600">Se connecter</span> pour vous connecter.</p>
            <?php
            if (isset($_SESSION['erreurs_inscription'])) {
                echo '<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">';
                echo '<h4 class="font-semibold mb-2">Erreurs :</h4><ul class="list-disc pl-5">';
                foreach ($_SESSION['erreurs_inscription'] as $erreur) {
                    echo '<li>' . htmlspecialchars($erreur) . '</li>';
                }
                echo '</ul></div>';
                unset($_SESSION['erreurs_inscription']);
            }
            ?>
            <form action="traiter-inscription.php" method="post" class="space-y-6 mt-4" autocomplete="off">
                <div>
                    <label for="nom_utilisateur" class="block text-sm font-medium text-gray-600 mb-1">Nom d'utilisateur</label>
                    <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="<?php echo isset($_SESSION['old_utilisateur']) ? htmlspecialchars($_SESSION['old_utilisateur']) : ''; ?>" onkeyup="verifierNomUtilisateur()" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <div id="message_ajax" class="text-xs mt-1"></div>
                </div>
                <div>
                    <label for="mot_de_passe" class="block text-sm font-medium text-gray-600 mb-1">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label for="confirmer_mot_de_passe" class="block text-sm font-medium text-gray-600 mb-1">Confirmer le mot de passe</label>
                    <input type="password" id="confirmer_mot_de_passe" name="confirmer_mot_de_passe" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div class="flex justify-center gap-4 mt-4">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition">S'inscrire</button>
                    <button type="button" onclick="window.location.href='connexion-form.php'" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg border border-gray-300 transition">Se connecter</button>
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
    <footer class="bg-white border-t border-indigo-100 py-6 mt-8">
        <div class="max-w-3xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-6 px-4 text-sm text-gray-500">
            <div class="text-center md:text-left">
                <p class="mb-1">&copy; <?php echo date("Y"); ?> <span class="font-semibold text-indigo-700">DeviNet</span> by <span class="font-semibold text-indigo-700">Eric BEDA</span>.</p>
                <p class="mb-1">Tous droits réservés.</p>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 w-full md:w-auto justify-center md:justify-end">
                <span><span class="font-semibold text-gray-700">Contact :</span> <a class="text-indigo-600 hover:underline font-medium" href="mailto:a.anazet1@gmail.com">a.anazet1@gmail.com</a></span>
                <span><span class="font-semibold text-gray-700">GitHub :</span> <a class="text-indigo-600 hover:underline font-medium" href="https://github.com/beda225">github.com/beda225</a></span>
                <span><span class="font-semibold text-gray-700">LinkedIn :</span> <a class="text-indigo-600 hover:underline font-medium" href="https://www.linkedin.com/in/anazet-beda">linkedin.com/in/anazet-beda</a></span>
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

</html>