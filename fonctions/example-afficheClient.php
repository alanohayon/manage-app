<?php

// Inclure le fichier de configuration pour se connecter à la base de données
require_once 'config.php';

// Écrire la requête pour récupérer tous les clients de la table clients
$sql = "SELECT * FROM client";

try {
    $stmt = $db->query($sql);

    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Liste des clients</h1>";

    // Vérifier si des clients ont été trouvés
    if($clients) {
        echo "<ul>";
        foreach ($clients as $client) {
            echo "<li>" . $client['nom'] . " " . $client['prenom'] . "</li>";  // Remplacez 'nom' et 'prenom' par les noms réels des colonnes si différents.
        }
        echo "</ul>";
    } else {
        echo "Aucun client trouvé.";
    }

} catch (PDOException $e) {
    die("Erreur lors de la récupération des données: " . $e->getMessage());
}


