<?php
session_start();
//retient toutes les varianles sessions
$prenom=($_SESSION["prenom"]);  //variable prenom qui retient le prenom du responsable
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); 
//connexion a la bdd
$resul = mysqli_query($id, "Select * from responsable where prenom ='$prenom'" );
//requete qui verifie si le prenom est bien dans la table responsable
$ligne = mysqli_fetch_assoc($resul);
$pren=$ligne["prenom"]; //variable 'pren' qui retient le resultat si il y en a
if($pren == null  ) //si la variable 'pren' est null alors renvoyer l'utilisateur à la page de connexion
{
header("location:Connexion.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Affiche Archive</title>
  <link rel="stylesheet" href="style-techni_resp.css">
    <link rel="stylesheet" href="style-header.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

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

            <a href="Responsable.php" class="pages"><i class="fa fa-eye" aria-hidden="true"></i> Afficher les problemes</a>
            <a href="#" class="pages">|</a>
            <a href="chatResp.php" class="pages"><img src='chat.png' width='20'></i> Envoyer un message</a>
            <a href="InscritClient.php" class="pages"><i class="fa fa-database" aria-hidden="true"></i> Ajouter un client</a>
          
            <a href="Deco.php" class="pages"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</i></a>
        </div>
    </nav>
  </header>
<table> 
  <tr> 
    <!-- Tabeau affichant les differente colonnes renseignant les problemes arvchivés -->
    <th>date debut</th>
    <th>date fin</th>
    <th>produit</th>
    <th>descripton</th>
    <th>fichier</th>
    <th>Email Client</th>
    <th>Email Technicien</th>
    <th>Statut</th>
    <th>Supprimer</th>

</tr>
<?php
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); 
//connexion à la bdd
$resul = mysqli_query($id, "select * from archiveprob "); 
//executer une requete et stockage du resultat dans $resul
while($ligne = mysqli_fetch_assoc($resul)){
//recuperation de la premiere ligne (1er probleme)
$fichier =$ligne["fichier"];  
// enregistre le nom du fichier du probleme dans la variable 'fichier'
  echo //afficher les proprietes du probleme dans les differentes colonnes
"<tr>
<td>". $ligne["datedebut"]."</td>
<td>". $ligne["datefin"]."</td>
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
<td>". $ligne["mail"]."</td>
<td>". $ligne["technicien"]."</td>
<td>";
  echo "Termine <img src='../img/verifier.png' width='10'>";
  echo "</td>
<td>";
  echo"<a href='supp.php?idp=". $ligne["idp"]."'><img src='poubelle.png' width='20'><a/>";  //si le responsable souhaite supprimer un probleme des archives
  echo "</td>


</th>";
}
?>
</table>
<a href='Deco.php'>Deconnexion</a> 
<!-- lien qui deconnecte le responsable et le redirige à la page de connexion  -->
<a href='Acceuil.php'>Page d'acceuil</a>
<!-- lien qui redirige le responsable à la page d'acceuil  -->
<a href='Responsable.php'>Page Responsable</a>
<!-- lien qui redirige le responsable à la page d'acceuil  -->
</body>
</html>

