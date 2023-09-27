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

    //Pas completement fini
    public function insertTechBDD($nom, $prenom, $mail, $id){
        if (empty($nom || $prenom || $mail)) {
            // Gérez la logique pour traiter le cas où $dataPost est vide.
        } else {
            // Mise à jour dans la base de données
            try {
                $stmt = $this->db->prepare("UPDATE `technicien` SET `nom`=?, `prenom`=?, `mail`=? WHERE `id`= ? ");
                $stmt->execute([$nom, $prenom, $mail, $id]);

                // Si la mise à jour est réussie, vous pouvez rediriger vers une autre page.
                // header("Location: dashboard.php");
                exit;
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour du profil : " . $e->getMessage();
            }
        }
    }

    //Pas completement fini
    public function updateProfilBDD($dataPost, $id){
        if (empty($dataPost)) {
            // Gérez la logique pour traiter le cas où $dataPost est vide.
        } else {
            // Mise à jour dans la base de données
            try {
                $stmt = $this->db->prepare("UPDATE `profil` SET `genre`=?, `ville`=?, `bio`=?, `affinite1`=?, `affinite2`=? WHERE `idp`= ?");
                $stmt->execute([$dataPost["genre"], $dataPost["ville"], $dataPost["bio"], $dataPost["affinite1"], $dataPost["affinite2"], $id]);
                
                // Si la mise à jour est réussie, vous pouvez rediriger vers une autre page.
                // header("Location: dashboard.php");
                exit;
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour du profil : " . $e->getMessage();
            }
        }
    }


}
