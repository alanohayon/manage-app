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

echo "Bonjour $prenomResp !";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style-header.css">
</head>

<body>

  <table class="content-table">
    <tr>
      <!-- Tableau affichant ses taches et ces options -->
      <th>idt</th>
      <th width="15%">Date</th>
      <th>Emetteur</th>
      <th>Tâche</th>
      <th>Precision</th>
      <th>Details</th>
      <th>Prioritée</th>
      <th>Complexité</th>
      <th>Fichier</th>
      <th>Responsable</th>
      <th>Ajouter + (Max 4)</th>
      <th>Chat</th>
      <th>Statut</th>
      <th>Valider</th>
      <th>Ne Pas validé</th>
    </tr>

    <?php

    //Recuperer les tickets où il est responsable
    $resul = mysqli_query($id, "Select * from tickets where responsable like '%$prenomResp%' order by date DESC");

    //execute la boucle autant de fois que le nombre de ligne recu
    while ($ligne = mysqli_fetch_assoc($resul)) {

      //recuperation de la premiere ligne (1ere tache)
      $idt = $ligne["idt"];
      //enregistre le nom du fichier du probleme dans la variable 'fichier'
      $fichier = $ligne["fichier"];
      $statut = $ligne["statut"];

      //afficher les proprietés de la tache dans les differentes colonnes
      echo
      "<tr>
<td> $idt </td>
<td>" . $ligne["date"] . "</td>
<td>" . $ligne["createur"] . "</td>
<td>" . $ligne["tache"] . "</td>
<td>" . $ligne["precision"] . "</td>
<td>" . $ligne["details"] . "</td>
<td>" . $ligne["priorite"] . "</td>
<td>" . $ligne["complexite"] . "</td>

<td>";
      //si il existe un fichier
      if ($fichier) {  
        //afficher le fichier
        echo "<img src='doc/$fichier' alt = '$fichier' width='70'>";
      } else {
       // si il il n'y a pas de fichier afficher 'pas de ficheier'
        echo "Pas de fichier";
      }
      echo "</td>

<td>" . $ligne["responsable"] . "</td>

<td>";

      //fil deroulante pour ajouter une personne a la tache
      echo "<form action='AjouterResp.php?idt=$idt' method='POST'><select name='resp'>";
      $resultat = mysqli_query($id, 'select * from responsable ');
      while ($ligne = mysqli_fetch_assoc($resultat)) {
        echo "<option value = " . $ligne["prenom"] . " > " . $ligne["prenom"] . " </option>";
      }
      echo " </select><input type='submit' value='Ajouter'></form>";
      echo "</td>

<td>";
    //possibilité de parler avec une personne
      echo "<a href='messages.php?id_to=null'><img src='../assets/chat.png' width='20'>";
      echo "</td>
      <td> $statut </td>
<td>";

      //si le statut du probleme est 'en attente'
      if ($statut == "En attente") {  
        echo " 
  <a href='commencer.php?idt=$idt' ><img src='../assets/jouer.png' width='20'><a/>";
        //alors afficher l'icone 'jouer' et si il clique dessus le statut et l'icone change
      }

      if ($statut == "En cours") {  //si le statut du probleme est 'en cours'
        echo "
  <img src='../assets/oeil.png' width='20'>";
        //alors afficher l'icone 'oeil' et si il clique dessus le statut et l'icone change
      }

      if ($statut == "Termine") { //si le statut du probleme est 'termine'
        echo "
 <img src='../assets/fait.gif' width='20'>";
        //alors afficher le gif 'fait' 
      }

      echo "</td>
<td>";
      if ($statut == "En cours") {  //si le statut du probleme est 'en cours'
        echo "
   <a href='terminer.php?idt=$idt'><img src='../assets/verifier.png' width='20'><a/>";
        //alors afficher l'icone 'verifier' et si il clique dessus le statut et l'icone change
      }

      "</td>

</th>";
    }
    ?>

  </table>
  <a href='affichearchive.php'>Archive Probleme</a>
  <a href='Deco.php'>Deconnexion</a>
  <a href='inscrittech.php'>Ajouter un technicien</a>
</body>

</html>