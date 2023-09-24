<?php

require_once '../config.php';

class User {

    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    // Fonction pour obtenir l'ID du technicien à partir de son e-mail
    public function getIdByEmail($email) {
        try {
            $requete = "SELECT id FROM technicien WHERE mail = :email";
            $stmt = $this->db->prepare($requete);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ? $user['id'] : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getPrenomById($id) {
        try {
            $requete = "SELECT prenom FROM technicien WHERE id = :id";
            $stmt = $this->db->prepare($requete);
            $stmt->execute([':id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ? $user['prenom'] : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getDataByEmail($email) {
        try {
            $technicienId = $this->getIdByEmail($email);

            if ($technicienId === null) {
                return null;
            }

            $requete = "SELECT * FROM technicien WHERE id = :id";
            $stmt = $this->db->prepare($requete);
            $stmt->execute([':id' => $technicienId]);
            $dataUser = $stmt->fetch(PDO::FETCH_ASSOC);

            return $dataUser;
        } catch (PDOException $e) {
            return null;
        }
    }


}
