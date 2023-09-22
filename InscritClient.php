<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style-header.css">
  <link rel="stylesheet" href="connexion.css">
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
            <a href="connexion.php" class="pages"><i class="fa fa-user-circle" aria-hidden="true"></i> Connexion</a>
        </div>
    </nav>
  </header>
<h1>Page Inscription Client</h1>
<form action="" method="post">  
  <input type="text" name="nom" placeholder="Nom :"required><br>
  <input type="text" name="prenom" placeholder="Prènom :"required><br>
  <input type="email" name="mail" placeholder="Mail :"required><br>
  <input type="password" name="mdp" placeholder="Mot de passe :"required><br>
  <input type="password" name="vmdp" placeholder="Verifier mot de passe :" required><hr>
  <input type="submit" value="S'inscrire" name="bout">
</form>

  <?php
  $id = mysqli_connect("127.0.0.1:8889","root","root","SA"); 
  if(isset($_POST["bout"])){ 
      $mdp=$_POST["mdp"];
      $vmdp=$_POST["vmdp"];
  if($mdp== $vmdp){
    $resul = mysqli_query($id, "Select * from client where mail ='$mail' and mdp ='$mdp' " );
    if( $ligne["mail"]==0){
      $nom=$_POST["nom"];
      $prenom=$_POST["prenom"];
      $mail=$_POST["mail"];
      $mdp=$_POST["mdp"];
      $_SESSION["prenom"] = $prenom;
      $resul = mysqli_query($id, "insert into client values (NULL, '$nom', '$prenom', '$mail','$mdp')" );
   header("location:ProbClient.php");
    }else{
      echo"un compte existe deja sous le mail de $mail";
    }
    }
    else{
      echo"Mail ou mot de passe incorrecte";
      }
  }
?>
</body>
</html>
