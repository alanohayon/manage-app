<?php

require_once '../config.php'; // Assurez-vous que ce chemin mène à votre fichier config.php

class Project {

    private $db;

    public function __construct() {
        global $db; // Utilisez la connexion à la base de données déjà établie dans config.php
        $this->db = $db;
    }

    public function createProject($project_name, $id_createur) {

        try {
            $requete = "INSERT INTO projets (nom_projet, date_creation, id_createur) VALUES (:nom_projet, NOW(), :id_createur)";

            $stmt = $this->db->prepare($requete);

            $stmt->execute([
                ':nom_projet' => $project_name,
                ':id_createur' => $id_createur
            ]);


            return $this->db->lastInsertId(); // Retourne l'ID du projet créé
        } catch(PDOException $e) {
            return false;
        }
    }

    public function getAllProjectsForUser($user_email) {
        try {
            $requete = "SELECT p.id_projet, p.nom_projet, t.mail as createur 
                    FROM projets p
                    JOIN user_link_project ulp ON p.id_projet = ulp.project_id
                    JOIN technicien t ON p.id_createur = t.id
                    WHERE ulp.user_email = :user_email";

            $stmt = $this->db->prepare($requete);
            $stmt->execute([':user_email' => $user_email]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }


    public function addUserToProject($user_email, $project_id) {
        try {
            $requete = "INSERT INTO user_link_project (user_email, project_id) VALUES (:user_email, :project_id)";

            $stmt = $this->db->prepare($requete);
            $stmt->execute([
                ':user_email' => $user_email,
                ':project_id' => $project_id
            ]);

            return true;
        } catch(PDOException $e) {
            return false;
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

    // Fonction pour obtenir un seul projet par son ID
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

    public function checkUserCurrentProject($email, $id_projet) {
        try {
            $requete = "SELECT * FROM user_link_project WHERE user_email = :email AND project_id = :id_projet";
            $stmt = $this->db->prepare($requete);
            $stmt->execute([':email' => $email, ':id_projet' => $id_projet]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? true : false;  // Retourne true si l'utilisateur est associé au projet, sinon false
        } catch (PDOException $e) {
            return false;
        }
    }



}


