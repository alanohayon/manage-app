<?php

require_once '../config.php'; // Assurez-vous que ce chemin mène à votre fichier config.php

class Project {

    private $db;

    public function __construct() {
        global $db; // Utilisez la connexion à la base de données déjà établie dans config.php
        $this->db = $db;
    }

    public function creerProjet($data) {
        try {
            // Extraction des données
            $nom_projet = $data['nom_projet'];
            $date_creation = $data['date_creation'];
            $id_createur = $data['id_createur'];

            //get id by email
            $stmt2 = $this->db->prepare("SELECT id FROM technicien WHERE mail = ?");
            $stmt2->execute([$id_createur]);
            $user = $stmt2->fetch(PDO::FETCH_ASSOC);

            if($user) {

                $requete = "INSERT INTO projets (id_projet, nom_projet, date_creation, id_createur) VALUES (NULL, :nom_projet, :date_creation, :id_createur)";

                // Préparation de la requête
                $stmt = $this->db->prepare($requete);

                // Execution de la requête avec les paramètres bindés
                $stmt->execute([
                    ':nom_projet' => $nom_projet,
                    ':date_creation' => $date_creation,
                    ':id_createur' => $user['id']
                ]);

                // Récupération de l'id du projet créé
                $requete2 = "SELECT id_projet FROM projets WHERE nom_projet = :nom_projet AND date_creation = :date_creation AND id_createur = :id_createur";

                $stmt2 = $this->db->prepare($requete2);
                $stmt2->execute([
                    ':nom_projet' => $nom_projet,
                    ':date_creation' => $date_creation,
                    ':id_createur' => $user['id']
                ]);

                $id_projet = $stmt2->fetch(PDO::FETCH_ASSOC);



                // inscription dans la table technicien_projet
                // CREATE TABLE `technicien_projet` (
                //  `id_technicien` int(11) NOT NULL,
                //  `id_projet` int(11) NOT NULL
                //) ENGINE=InnoDB DEFAULT CHARSET=utf8;

                $requete3 = "INSERT INTO technicien_projet (id_technicien, id_projet) VALUES (:id_technicien, :id_projet)";

                $stmt3 = $this->db->prepare($requete3);

                $stmt3->execute([
                    ':id_technicien' => $user['id'],
                    ':id_projet' => $id_projet['id_projet']
                ]);


            }



            return true;
        } catch (PDOException $e) {
            return "Erreur lors de la création du projet: " . $e->getMessage();
        }
    }

    public function recupProjets($id_technicien) {
        try {
            $requete = "SELECT p.id_projet, p.nom_projet, t.mail as createur 
                    FROM projets p
                    JOIN technicien_projet tp ON p.id_projet = tp.id_projet
                    JOIN technicien t ON p.id_createur = t.id
                    WHERE tp.id_technicien = :id_technicien";

            $stmt = $this->db->prepare($requete);
            $stmt->execute([':id_technicien' => $id_technicien]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    public function recupInfosProjet($id_projet) {
        try {
            $requete = "SELECT p.nom_projet, t.mail as createur
                    FROM projets p
                    JOIN technicien t ON p.id_createur = t.id
                    WHERE p.id_projet = :id_projet";

            $stmt = $this->db->prepare($requete);
            $stmt->execute([':id_projet' => $id_projet]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    // Votre fonction pour obtenir un seul projet par son ID
    public function getOneProject($id_projet) {
        $stmt = $this->db->prepare("SELECT * FROM projets WHERE id_projet = ?");
        $stmt->execute([$id_projet]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Fonction pour récupérer les membres d'un projet
    public function getMembres($id_projet) {
        try {
            $requete = "SELECT t.id, t.nom, t.prenom, t.mail
                    FROM technicien t
                    JOIN technicien_projet tp ON t.id = tp.id_technicien
                    WHERE tp.id_projet = :id_projet";

            $stmt = $this->db->prepare($requete);
            $stmt->execute([':id_projet' => $id_projet]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }

    public function getTechniciansByProjectId($projectId) {
        try {
            $requete = "SELECT technicien.*
            FROM technicien
            INNER JOIN technicien_projet ON technicien.id = technicien_projet.id_technicien
            WHERE technicien_projet.id_projet = :id_projet";




            $stmt = $this->db->prepare($requete);
            $stmt->execute([':id_projet' => $projectId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }


}


