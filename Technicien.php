<?php
session_start();
//retient toutes les varianles sessions
$prenom=($_SESSION["prenom"]);  //variable prenom qui retient le prenom du responsable
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); 
//connexion a la bdd
$resul = mysqli_query($id, "Select * from technicien where prenom ='$prenom'" );
//requete qui verifie si le prenom est bien dans la table technicien
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
  <title>Document</title>
  <link rel="stylesheet" href="style-techni_resp.css">
  <link rel="stylesheet" href="connexion.css">
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
            <a href="Deco.php" class="pages"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</i></a>
        </div>
    </nav>
  </header>
<h1>PageTechnicien</h1>
<?php
$prenom=$_SESSION["prenom"];  //variable prenom qui retient le prenom du technicien
echo"bonjour $prenom";//affiche bonjour avec le prenom du technicien connecté
?>
<table> 
    <!-- Tabeau affichant les differente colonnes renseignant les problemes  et les options du techcnicien-->
  <tr>
    <th>idp</th>
    <th>Produit</th>
    <th>Decription</th>
    <th>Fichier</th>
    <th>Date</th>
    <th>Mail Client</th>
    <th>Technicien</th>
    <th>Chat</th>
    <th>Statut</th>
    <th>Action</th>

</tr>
<?php
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); 
//connexion à la bdd
$resul = mysqli_query($id, "select * from probleme where technicien like '%$prenom%' or technicien like '' order by statut ='termine' desc"); 
//executer une requete et stockage du resultat dans $resul
while($ligne = mysqli_fetch_assoc($resul)){
//recuperation de la premiere ligne (1er medecin)
  $fichier =$ligne["fichier"];
//enregistre le nom du fichier du probleme dans la variable 'fichier'
  $statut =$ligne["statut"];
//enregistre le statut du probleme dans la variable 'statue'
echo //afficher les proprietes du probleme dans les differentes colonnes
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
echo"<a href='chatTech.php'><img src='chat.png' width='20'>";  //possibilité de parler avec le client ou le responsable
  echo "</td>
<td>". $ligne["statut"]."</td>
<td>";
if ($statut =="En attente"){  //si le statut du probleme est 'en attente'
  echo" 
  <a href='commencer.php?idp=". $ligne["idp"]."'><img src='jouer.png' width='20'><a/>";
  //alors afficher l'icone 'jouer' et si il clique dessus le statut et l'icone change
}
if ($statut =="En cours"){  //si le statut du probleme est 'en cours'
  echo"
  <img src='oeil.png' width='20'>";
  //alors afficher l'icone 'oeil' et si il clique dessus le statut et l'icone change
}
if ($statut =="Termine"){ //si le statut du probleme est 'termine'
  echo"
 <img src='fait.gif' width='20'>";
  //alors afficher le gif 'fait' 
}
echo "</td>
<td>";
if ($statut =="En cours"){  //si le statut du probleme est 'en cours'
  echo"
  <a href='terminer.php?idp=". $ligne["idp"]."'><img src='verifier.png' width='20'><a/>";
  //alors afficher l'icone 'verifier' et si il clique dessus le statut et l'icone change
}"</td>
</th>";
}
?>
</table>
<a href='Deco.php'>Deconnexion</a>
<!-- lien qui deconnecte le technicien -->
<a href='Acceuil.php'>Page d'acceuil</a>
<!-- lien qui redirige le technicien à la page d'acceuil  -->
</body>
</html>

