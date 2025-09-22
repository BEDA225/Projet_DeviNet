<?php
// test-creation-db.php
// Page de test pour vérifier la création de la base de données

// Activer les exceptions MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once 'gestiondb.php';

// Configuration de la base de données
define('NOM_SERVEUR', 'localhost');
define('UTILISATEUR_SERVEUR', 'root');
define('MOTDEPASSE_SERVEUR', '');
define('NOM_BASEDEDONNEES', 'jeu_devinette');
define('NOM_TABLE', 'compte_utilisateur');

echo "<h1>Test de création de base de données</h1>";

try {
    echo "<p>1. Tentative de création de la structure de la base de données...</p>";

    // Créer la structure de la base de données
    $creerStructure = new creerStructure(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR);
    $creerStructure->creeAdresseFichier("db_structure.sql");

    echo "<p style='color: green;'>Structure de la base de données créée avec succès!</p>";

    // Test de connexion à la base de données
    echo "<p>2. Test de connexion à la base de données...</p>";

    $recevoirDonnees = new recevoirDonnees(NOM_SERVEUR, UTILISATEUR_SERVEUR, MOTDEPASSE_SERVEUR);
    $requete_test = "SELECT COUNT(*) as total FROM " . NOM_TABLE;
    $recevoirDonnees->sauvegarderDonnees(
        $requete_test,
        NOM_BASEDEDONNEES,
        NOM_TABLE
    );

    $nombre_utilisateurs = $recevoirDonnees->recevoirNombreDeLignes();
    echo "<p style='color: green;'>Connexion réussie! Nombre d'utilisateurs dans la table: " . $nombre_utilisateurs . "</p>";

    // Afficher les utilisateurs existants
    echo "<p>3. Liste des utilisateurs existants:</p>";
    $requete_liste = "SELECT id, nom_utilisateur, date_creation FROM " . NOM_TABLE;
    $donnees = $recevoirDonnees->sauvegarderDonnees(
        $requete_liste,
        NOM_BASEDEDONNEES,
        NOM_TABLE
    );

    if (!empty($donnees)) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>ID</th><th>Nom d'utilisateur</th><th>Date de création</th></tr>";
        foreach ($donnees as $utilisateur) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($utilisateur['id']) . "</td>";
            echo "<td>" . htmlspecialchars($utilisateur['nom_utilisateur']) . "</td>";
            echo "<td>" . htmlspecialchars($utilisateur['date_creation'] ?? 'Non définie') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun utilisateur trouvé dans la base de données.</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'> Erreur: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Vérifiez que:</p>";
    echo "<ul>";
    echo "<li>WAMP/XAMPP est démarré</li>";
    echo "<li>Le service MySQL fonctionne</li>";
    echo "<li>Le fichier db_structure.sql existe</li>";
    echo "<li>Les paramètres de connexion sont corrects</li>";
    echo "</ul>";
}

echo "<hr>";
echo "<p><a href='inscription-form.php'>← Retour au formulaire d'inscription</a></p>";
