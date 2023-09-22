<?php
session_start();
//retient toutes les varianles sessions
$prenom=($_SESSION["prenom"]);  //variable prenom qui retient le prenom du responsable
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); 
//connexion a la bdd
$resul = mysqli_query($id, "Select * from client where prenom ='$prenom'" );
//requete qui verifie si le prenom est bien dans la table client
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
  <!-- <link rel="stylesheet" href="inscrimed.css"> -->
  <link rel="stylesheet" href="../style/style.css">

  <link rel="stylesheet" href="../style/connexion.css">
  <link rel="stylesheet" href="../style/style-header.css">
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
            <a href="afficheclient.php" class="pages"><i class="fa fa-user-circle" aria-hidden="true"></i> Mes demander</a>
            <a href="chatclient.php" class="pages"><img src='../img/chat.png' width='20'></i> Envoyer un message</a>

            <a href="#" class="pages">|</a>
            <a href="../fonctions/Deco.php" class="pages"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</i></a>
        </div>
    </nav>
  </header>
<body>
<h1>
<?php echo"Bonjour $prenom";?>
</h1>
<form name ="ProbClient"action="" method="POST"enctype='multipart/form-data'> 
  <!-- Formulaire où le client remplie les differentes informations à fournir afin d'envoyer son probleme -->
<div class="formProb" >
<a1>Produit :</a1><br><br>
<select name="prod"> 
  <!-- file deroulante avec les differents produits et 'autres' si le produit ne s'y trouve paas -->
  <option value="ordinateur">Ordinateur</option>  
  <option value="Smartphonne">Smartphonne</option>
  <option value="Caftiere">Caftiere</option>
  <option value="Machine à laver">Machine à laver</option>
  <option value="autres">autres</option>
</select>

<br><br>
<a2>Description :</a2><br><br>
<input type="text" name="desc" placeholder="Decrivez votre probleme :"required>

<!-- zone de texte ou le client decrit son probleme -->
<br>
<a3>Ajouter une image :</a3><br><br>
<input type="file" name="fichier" >
<!-- le client peut deposer un fichier -->
<br><br>
<input type="submit" value="Enregistrer le probleme" name="boot">
<!-- en cliquant sur 'enregistrer le probleme' le client envoyer ces information qui seront ajouter à la table 'probleme' dans la bdd -->
</div>
</form>
<?php
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); //connexion a la bdd
$mailb=$_SESSION["mail"] ;  //la variable 'mail' retient le mail du client retenu dans la variable 
if(isset($_POST["boot"])){   //si il clique sur 'enregistrer' le probleme' alors :
extract($_POST);  //recupere toutes les donnees du formulaire
$fichier=$_FILES["fichier"]['name']; 
$resul= mysqli_query($id, "insert into probleme values (NULL, '$mailb', now(),'$prod','$desc','$fichier','','En attente')");  //enregistrer les informations du probleme dans la bdd
header("location:afficheClient.php");

}
?>
<br>
<a href="../fonctions/Deco.php">Deconnexion</a>
<!-- lien qui deconnecte le client -->
<a href="afficheClient.php">affiche Client</a>
<!-- lien qui redirige le client à la page qui affiche ses problemes envoyé -->
<a href='Acceuil.php'>Page d'acceuil</a>
<!-- lien qui redirige le client à la page d'acceuil  -->
</body>
</html>