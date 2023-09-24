<?php
session_start();

//variable prenom qui retient le prenom du responsable
$prenomResp = $_SESSION["prenomResp"];  
//ud de connexion
$id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing"); 

//requete pour verifier qu'il s'est bien identifier avant d'arriver ici
$resulVerif = mysqli_query($id, "Select * from responsable where prenom ='$prenomResp'" );

//si il ne renvoit pas de resultat alors il est redirigé vers la page de connexion
if (mysqli_num_rows($resulVerif) == 0) {

header("location:Connexion.php");
}

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
<header>
    <nav class="nav-header" role="navigation">
        <!-- LOGO A GAUCHE -->
        <div class="menu-gauche">
            <a href="Acceuil.php" class="logodaccueil"><h1 class="logogo">TICKETING INC.</a>
        </div>
        <!-- TOUTES LES PAGES -->
        <div class="menu-droite">
            <a href="affichearchive.php" class="pages"><i class="fa fa-user-circle" aria-hidden="true"></i> Archive</a>
            <a href="Inscrittech.php" class="pages"><i class="fa fa-eye" aria-hidden="true"></i> Ajouter un technicien</a>
            <a href="#" class="pages">|</a>
            <a href="InscritClient.php" class="pages"><i class="fa fa-database" aria-hidden="true"></i> Ajouter un client</a>
            <a href="Deco.php" class="pages"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</i></a>
        </div>
    </nav>
  </header>

<?php
echo"Bonjour $prenomResp !";
?>

<table class="content-table"> 
  <tr>
    <!-- Tableau affichant les differentes colonnes renseignant les problemes et les options du responsble -->
   <th>idt</th>
   <th width="15%">Date</th>
   <th>Prénom</th>
    <th>Tâche</th>
    <th>Precision</th>
    <th>Details</th>
    <th>Prioritée</th>
    <th>Complexité</th>
    <th>Ajouter + (Max 4)</th>
    <th>Chat</th>
    <th>Statut</th>
    <th>Valider</th>
    <th>Pas validé</th>   
</tr>

<?php

$resul = mysqli_query($id, "select * from probleme order by statut ='termine' desc"); 
//executer une requete et stockage du resultat dans $resul
while($ligne = mysqli_fetch_assoc($resul)){
//recuperation de la premiere ligne (1er probleme)
$fichier =$ligne["fichier"];
$statut =$ligne["statut"];
//enregistre le nom du fichier du probleme dans la variable 'fichier'
echo //afficher les proprietés du probleme dans les differentes colonnes
"<tr>
<td>". $ligne["idp"]."</td>
<td>". $ligne["produit"]."</td>
<td>". $ligne["description"]."</td>
<td>";
if ($fichier){ //si il existe un fichier 
  echo "<img src='doc/$fichier' width='70'>"; //afficher le fichier
}
else{
  echo "Pas de fichier"; // si il il n'y a pas de fichier afficher 'pas de ficheier'
}
echo "</td>
<td>". $ligne["date"]."</td>
<td>". $ligne["mail"]."</td>
<td>". $ligne["technicien"]."</td>
<td>";
echo"<form action='ajouttech.php?idp=". $ligne["idp"]."' method='POST'><select name='tech'>";
$resultat = mysqli_query($id, 'select * from technicien '); 
while($lig = mysqli_fetch_assoc($resultat)){
  echo"<option ligne=". $lig["prenom"].">". $lig["prenom"]."</option>";
 }
 echo" </select><input type='submit' value='Ajouter'></form>";
echo "</td>
<td>";
echo"<a href='chatResp.php'><img src='chat.png' width='20'>";  //possibilité de parler avec le technicien 
  echo "</td>
<td>$statut</td>
<td>";
if($statut=='Termine'){ //si le statut du probleme est 'en attente'
  echo"<a href='valider.php?idp=". $ligne["idp"]."'><img src='bouclier-verifier.png' width='20'>";
echo "</td>
<td>";
  echo"<a href='pasvalide.php?idp=". $ligne["idp"]."'><img src='invalide.png' width='15'>";
}
  echo "</td>
</th>"; 
}
?>

</table>
<a href='affichearchive.php'>Archive Probleme</a>
<a href='Deco.php'>Deconnexion</a>
<a href='inscrittech.php'>Ajouter un technicien</a>
</body>
</html>
