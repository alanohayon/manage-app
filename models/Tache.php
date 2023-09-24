<?php

require_once '../config.php';

class Tache {

    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function creerTache($data) {
        try {
            // Extraction des données
            $titre = $data['titre'];
            $description = $data['description'];
            $statut = $data['statut'];
            $date_de_fin = $data['date_de_fin'];
            $id_projet = $data['id_projet'];

            // Requête SQL
            $stmt = $this->db->prepare("INSERT INTO taches (titre, description, statut, date_de_fin, id_projet) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$titre, $description, $statut, $date_de_fin, $id_projet]);

            return true;
        } catch (PDOException $e) {
            return "Erreur lors de la création de la tâche: " . $e->getMessage();
        }
    }

    public function getOneTache($id_tache) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM taches WHERE id_tache = ?");
            $stmt->execute([$id_tache]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }



    public function getTachesByProjet($id_projet) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM taches WHERE id_projet = ?");
            $stmt->execute([$id_projet]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // à transférer sur models/Projet.php
    public function ajouterMembre($id_technicien, $id_projet) {
        try {
            $query = "INSERT INTO technicien_projet (id_technicien, id_projet) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_technicien, $id_projet]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function ajouterTechnicienSurTache($id_technicien, $id_tache) {

        try {
            $query = "INSERT INTO technicien_tache (id_technicien, id_tache) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_technicien, $id_tache]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getTechniciens($id_tache) {
        try {
            $query = "SELECT technicien.id, technicien.nom, technicien.prenom FROM technicien INNER JOIN technicien_tache ON technicien.id = technicien_tache.id_technicien WHERE technicien_tache.id_tache = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_tache]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }


    public function addTech($id_technicien, $id_tache) {
        $sql = "INSERT INTO technicien_tache (id_technicien, id_tache) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_technicien, $id_tache]);
    }

    public function removeTech($id_technicien, $id_tache) {
        $sql = "DELETE FROM technicien_tache WHERE id_technicien = ? AND id_tache = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_technicien, $id_tache]);
    }


    public function isTechnicianAssigned($techId, $taskId) {
        try {
            $requete = "SELECT * FROM technicien_tache 
                        WHERE id_technicien = :id_technicien AND id_tache = :id_tache";

            $stmt = $this->db->prepare($requete);
            $stmt->execute([':id_technicien' => $techId, ':id_tache' => $taskId]);

            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch(PDOException $e) {
            return false;
        }
    }

    public function isOnTache($id_technicien, $id_tache) {
        $sql = "SELECT COUNT(*) as count FROM technicien_tache WHERE id_technicien = :id_technicien AND id_tache = :id_tache";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_technicien' => $id_technicien, ':id_tache' => $id_tache]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // modifier le statut d'une tâche
    public function updateStatutTache($id_tache, $statut) {
        try {
            $query = "UPDATE taches SET statut = ? WHERE id_tache = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$statut, $id_tache]);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getStatut($id_tache) {
        try {
            $query = "SELECT statut FROM taches WHERE id_tache = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_tache]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['statut'];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getTitreTache($id_tache) {
        try {
            $query = "SELECT titre FROM taches WHERE id_tache = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_tache]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['titre'];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }




}
