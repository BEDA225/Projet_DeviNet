<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeviNet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex flex-col justify-between">
    <?php
    session_start();
    date_default_timezone_set('America/Toronto'); // Set the timezone to Montreal
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
    <?php if ($afficher_message): ?>
        <div id="message-bienvenue" class="fixed top-6 left-1/2 -translate-x-1/2 bg-green-100 border border-green-300 text-green-800 px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in">
            Connexion réussie ! Bienvenue <?php echo htmlspecialchars($nom_utilisateur); ?> !
        </div>
        <script>
            setTimeout(function() {
                const msg = document.getElementById('message-bienvenue');
                if (msg) msg.style.display = 'none';
            }, 3000);
        </script>
    <?php endif; ?>

    <main class="flex flex-col items-center justify-center flex-1 py-8">
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-8 border border-indigo-100 mx-auto px-2">
            <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center tracking-tight">Jeu de Devinette</h1>
            <form method="GET" action="traiter-jeu.php" class="space-y-6">
                <?php
                // Afficher la date et le nom d'utilisateur sur la même ligne avec un fond coloré
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
                ?>
                <hr>
                <p class="text-gray-700 text-center mb-4">Le système va générer 5 nombres aléatoires entre 0 et 12. Sélectionnez les nombres ci-dessous pour deviner ces nombres à l'avance.</p>
                <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-5 gap-4">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div>
                            <label for="choix-nbr<?php echo $i; ?>" class="block text-sm font-medium text-gray-600 mb-1"></label>
                            <select name="choix-nbr<?php echo $i; ?>" id="choix-nbr<?php echo $i; ?>" class="w-full rounded-lg border-2 border-indigo-400 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-700 transition-shadow shadow-sm hover:bg-indigo-50 focus:bg-indigo-100">
                                <?php for ($j = 0; $j <= 12; $j++): ?>
                                    <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="flex justify-center gap-4 mt-4">
                    <button type="submit" name="jouer" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition">Jouer</button>
                    <button type="button" onclick="window.location.href='deconnexion.php'" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg border border-gray-300 transition">Se déconnecter</button>
                </div>
            </form>
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