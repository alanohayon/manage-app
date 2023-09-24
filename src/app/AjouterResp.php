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
}


//la variable 'idp' retient l'id de la tache de la ligne selectionné
$idt = $_GET["idt"];
//la variable 'resp' retient le responsable ajouté à la tache 
$resp = $_POST["resp"];

//recuperer les responsable du ticket avant d'en ajouter d'autre
$result = mysqli_query($id, " Select * from tickets where idt = '$idt' ");
$ligne = mysqli_fetch_assoc($result);

//variable qui stock les responsables deja attaché à ce ticket
$respTicket = $ligne["responsable"];

//Verif si le resp ajouter ne fait pas deja parti des resp
if (substr_count($respTicket, $resp) != 0) {

  echo "<script>alert('$resp fait déjà parti des responsables du ticket !');</script>";
  echo "<script>window.location = 'MesTickets.php';</script>";
}else {

  //si le champ responsable contient + de 3 virgule (+ de 4 resp) alors le faire revenir à la page "Mes tickets"
  if (substr_count($respTicket, ',') == 3) {

    echo "<script>alert('Vous ne pouvez pas ajouter + de 4 responsables !!');</script>";
    echo "<script>window.location = 'MesTickets.php';</script>";
  } else {

    $allRespTicket = "$respTicket, $resp";
    //requette qui met à jour lenombre de resp du ticket
    $req = " Update tickets set responsable = '$allRespTicket' where idt='$idt' ";
    //executon de la requette
    if (mysqli_query($id, $req)) {

      echo "<script>alert('Ajout de $resp à la tache $idt.');</script>";
      echo "<script>window.location = 'MesTickets.php';</script>";
    } else {

      die("La modif à échoué : " . mysqli_error($connexion));
    }
  }
}

?>
