<?php
session_start();

//variable prenom qui retient le prenom du responsable
$prenomResp = $_SESSION["prenomResp"];
//ud de connexion
$id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing");

//requete pour verifier qu'il s'est bien identifier avant d'arriver ici
$resulVerif = mysqli_query($id, "Select * from responsable where prenom ='$prenomResp'");

//si il ne renvoit pas de resultat alors il est redirigé vers la page de connexion
if (mysqli_num_rows($resulVerif) == 0) {

    header("location:Connexion.php");
} else {
    $idt = $_GET["idt"];  //la variable 'idp' retient l'id du probleme de la ligne selectionné
    $req = "Update tickets set statut = 'En cours',  responsable = '$prenomResp' where idt='$idt'"; //requette qui met a jour le statut du probleme et qui enregistre le technicien ayant pis en charge le problemme 
    $resultat = mysqli_query($id, $req); //executon de la requette
    header("location:MesTickets.php");
}

?>