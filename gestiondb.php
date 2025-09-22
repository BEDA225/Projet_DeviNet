<?php

class BaseDeDonnees
{
    protected $connection;
    private $hostname, $username, $password;

    public function __construct($hostname, $username, $password)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
    }


    // mehode de connexion à la base de données
    protected function seConnecterAMySQL()
    {
        try {
            $this->connection = new mysqli($this->hostname, $this->username, $this->password);
        } catch (mysqli_sql_exception $erreur) {
            die("Échec de connexion à MySQL!<br/>" . $erreur);
        }
    }

    // methode pour executer le fichier sql
    protected function executerFichierSQL($adresse_fichier)
    {
        try {
            $this->connection->multi_query(file_get_contents($adresse_fichier));
            // Pas de message pour éviter l'affichage lors des vérifications AJAX
        } catch (mysqli_sql_exception $erreur) {
            // Erreur silencieuse pour l'AJAX
        }
    }

    // methode pour verifier si la table existe
    protected function executerUneRequeteSQL($requete, $retour = false)
    {
        // Exécute la requête SQL
        try {
            $resultat = $this->connection->query($requete);
            if ($retour === true) {
                return $resultat;
            }
        } catch (mysqli_sql_exception $erreur) {
            // Si la description échoue, afficher les informations détaillées de l'erreur
            echo "Échec de l'exécution de la requête SQL" . $requete . "<br/>";
            echo "Message: " . $erreur->getMessage() . "<br/>";
            echo "Fichier: " . $erreur->getFile() . "<br/>";
            echo "Ligne: " . $erreur->getLine() . "<br/>";
            die();
        }
    }

    //methode de destruction de la connexion
    public function __destruct()
    {
        try {
            $this->connection->close(); // Ferme la connexion MySQLi
        } catch (mysqli_sql_exception $erreur) {
            echo "Message: " . $erreur->getMessage() . "<br/>";
            echo "Fichier: " . $erreur->getFile() . "<br/>";
            echo "Ligne: " . $erreur->getLine() . "<br/>";
            die();
        }
    }
}

//-----------------------------------------------------------------
// creer une sous classe pour creer la structure de la base de données
class creerStructure extends BaseDeDonnees
{
    public function creeAdresseFichier($adresse_fichier)
    {
        // appeller la methode pour se connecter à MySQL
        $this->seConnecterAMySQL();
        // creer la structure de la base de données si elle n'existe pas
        $this->executerFichierSQL($adresse_fichier);
    }
}

//-----------------------------------------------------------------

// creer une classe pour envoyer des données à la base de données

class envoyerDonnees extends BaseDeDonnees
{

    public function envoyerDonnees($requete_envoyer, $nom_base_de_donnees, $nom_de_la_table)
    {
        // se connecter à la base de données
        $this->seConnecterAMySQL();

        // requete SQL pour envoyer les données
        $requete_localisation = "USE " . $nom_base_de_donnees . ";";
        $this->executerUneRequeteSQL($requete_localisation, false);
        // vérifier si la table existe
        $requete_verif_table = "DESC " . $nom_de_la_table . ";";
        $this->executerUneRequeteSQL($requete_verif_table, false);

        // insertion des données

        $this->executerUneRequeteSQL($requete_envoyer, false);
    }
}

//-----------------------------------------------------------------

// creer une classe pour recevoir des données de la base de données
class recevoirDonnees extends BaseDeDonnees
{
    private $resultat;
    private function recevoirDonnees($requete_recevoir, $nom_base_de_donnees, $nom_de_la_table)
    {
        // se connecter à la base de données
        $this->seConnecterAMySQL();

        // requete SQL pour envoyer les données
        $requete_localisation = "USE " . $nom_base_de_donnees . ";";
        $this->executerUneRequeteSQL($requete_localisation, false);
        // vérifier si la table existe
        $requete_verif_table = "DESC " . $nom_de_la_table . ";";
        $this->executerUneRequeteSQL($requete_verif_table, false);
        // exécuter la requête pour recevoir les données
        $this->resultat = $this->executerUneRequeteSQL($requete_recevoir, true);
    }

    // methode pour recevoir le nombre de lignes
    public function recevoirNombreDeLignes()
    {
        return $this->resultat->num_rows;
    }

    // methode pour recevoir une donnée
    public function recevoirUneDonnee()
    {
        foreach ($this->resultat as $each_row) {
            foreach ($each_row as $nomCol => $value) {
                $une_donnee = $value;
            }
        }
        return $une_donnee;
    }
    // methode pour sauvgarder les données reçues

    public function sauvegarderDonnees($requete_recevoir, $nom_base_de_donnees, $nom_de_la_table)
    {
        $this->recevoirDonnees($requete_recevoir, $nom_base_de_donnees, $nom_de_la_table);
        // calculer le nombre d'enregistrements
        $tableau2D = array();
        $i = 0;

        $nombre_de_lignes = $this->resultat->num_rows;

        for ($j = 0; $j < $nombre_de_lignes; $j++) {
            $each_row = $this->resultat->fetch_array(MYSQLI_ASSOC);
            // Sauvegarder toutes les colonnes retournées par la requête
            $tableau2D[$j] = $each_row;
            $i++;
        }
        // retourner le tableau 2D
        return $tableau2D;
    }
}
