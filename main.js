function verifierNomUtilisateur() {
    var username = document.getElementById('nom_utilisateur').value;
    var statusDiv = document.getElementById('message_ajax');

    if (username.length === 0) {
        statusDiv.innerHTML = '<span class="block p-2 bg-red-100 text-red-700 border border-red-200 rounded">Vous n\'avez rien entré!</span>';
    } else {
        var xmlhttp = new XMLHttpRequest();
        var data = "nom_utilisateur=" + encodeURIComponent(username);
        xmlhttp.open("POST", "verification-nom-utilisateur.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader("Content-length", data.length);
        xmlhttp.setRequestHeader("Connection", "close");
        xmlhttp.send(data);
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText != null) {
                    var cleanData = this.responseText.replace(/Fichier SQL exécuté avec succès !<br><br>/g, '').trim();
                    statusDiv.innerHTML = cleanData;
                } else {
                    statusDiv.innerHTML = '<span class="block p-2 bg-orange-100 text-orange-700 border border-orange-200 rounded">La réponse reçue du fichier est vide!</span>';
                }
            }
        };
    }
}

// Fonction pour vérifier si l'utilisateur existe lors de la connexion
function verifierUtilisateurALaConnexion() {
    var username = document.getElementById('nom_utilisateur').value;
    var statusDiv = document.getElementById('message_ajax_connexion');

    if (username.length === 0) {
        statusDiv.innerHTML = "Vous n'avez rien entré!";
        statusDiv.style.color = "red";
    }
    else {
        // Si le formulaire d'entrée n'est pas vide
        // Créer un objet de la classe XMLHTTPRequest()
        var xmlhttp = new XMLHttpRequest();

        // Envoyer les données reçu au clavier
        // au fichier "verification-nom-utilisateur-connexion.php" (requête)
        var data = "nom_utilisateur=" + encodeURIComponent(username);
        xmlhttp.open("POST", "verification-nom-utilisateur-connexion.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.setRequestHeader("Content-length", data.length);
        xmlhttp.setRequestHeader("Connection", "close");

        xmlhttp.send(data);

        // Recevoir les données reçues du fichier "verification-nom-utilisateur-connexion.php" (réponse)
        xmlhttp.onreadystatechange = function () {
            // Si statut de la requête est complété : readyState = 4
            // Et la connexion a réussi : Code de statut HTTP retourné = 200
            if (this.readyState == 4 && this.status == 200) {
                // Afficher les données reçues
                if (this.responseText != null) {
                    var cleanData = this.responseText.trim();

                    if (cleanData === 'NON_EXISTE') {
                        statusDiv.innerHTML = '<span class="block p-2 bg-red-100 text-red-700 border border-red-200 rounded">Utilisateur inexistant.</span>';
                        statusDiv.style.color = "";
                    } else if (cleanData === 'EXISTE') {
                        statusDiv.innerHTML = "";
                        statusDiv.style.color = "";
                        // statusDiv.innerHTML = "Utilisateur trouvé.";
                    } else {
                        // En cas d'erreur ou réponse vide
                        statusDiv.innerHTML = "";
                        statusDiv.style.color = "";
                    }
                }
                // Informer que la réponse reçue du fichier est vide
                else {
                    statusDiv.innerHTML = "";
                    statusDiv.style.color = "";
                }
            }
        };
    }
}

// Fonction pour mettre le focus sur un champ spécifique
function focusChamp(idChamp) {
    // Si le DOM est déjà chargé, focus immédiatement
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        const champ = document.getElementById(idChamp);
        if (champ) {
            champ.focus();
            console.log('Focus mis sur:', idChamp); // Debug
        }
    } else {
        // Sinon, attendre que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function () {
            const champ = document.getElementById(idChamp);
            if (champ) {
                champ.focus();
                console.log('Focus mis sur (après DOMContentLoaded):', idChamp); // Debug
            }
        });
    }
}