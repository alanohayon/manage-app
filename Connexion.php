<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
            <a href="InscritClient.php" class="pages"><i class="fa fa-user-circle" aria-hidden="true"></i> S'inscrire</a>
            <!-- <a href="Responsable.php" class="pages"><i class="fa fa-eye" aria-hidden="true"></i> Responsable</a>
            <a href="ProbClient.php" class="pages"><i class="far fa-file-alt" aria-hidden="true"></i> Mes demandes</a>
            <a href="afficheClient.php" class="pages"><i class="fa fa-users" aria-hidden="true"></i> Nos Clients</a>
            <a href="#" class="pages">|</a>
            <a href="InscritClient.php" class="pages"><i class="fa fa-database" aria-hidden="true"></i> Inscription</a>
            <a href="Connexion.php" class="pages"><i class="fa fa-cubes" aria-hidden="true"></i> Connexion</a>
            <a href="Deco.php" class="pages"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</i></a> -->
        </div>
    </nav>
  </header>
  <h1> Se connecter</h1>

<div class="f">
  <form action="" method="post">
    <input type="email" name="mail" placeholder="Mail :"required><br><br>  
    <input type="password" name="mdp" placeholder="Mot de passe :" required><br><br>
    <input type="submit" value="Connexion" name="bout" >
  </form>
</div>
<?php         
    $mail = $_POST["mail"];
    $mdp = $_POST["mdp"];
    $id = mysqli_connect("127.0.0.1:8889","root","root","SA");
    $req1 = "select * from responsable where mail='$mail' and mdp='$mdp'" ;
    $resultat = mysqli_query($id, $req1);
    $recu = mysqli_fetch_assoc($resultat);
    $mailb =$recu["mail"];
    $mdpb =$recu["mdp"];

    if(isset($_POST["bout"])){
    $req = "select * from client where mail='$mail' and mdp='$mdp' " ;
    $resultat = mysqli_query($id, $req);
    $recu = mysqli_fetch_assoc($resultat); //recuperation de la requete
    $mailb =$recu["mail"];
    $prenom =$recu["prenom"];
    $mdpb =$recu["mdp"];
      if($mail== $mailb and $mdp==$mdpb){ 
        $_SESSION["id"] = $id;
        $_SESSION["prenom"] = $prenom;
        $_SESSION["mail"] = $mailb;
          header("location:ProbClient.php");
        }
        $req1 = "select * from responsable where mail='$mail' and mdp='$mdp'" ;
        $resultat = mysqli_query($id, $req1);
        $recu = mysqli_fetch_assoc($resultat);
        $mailb =$recu["mail"];
        $mdpb =$recu["mdp"];
        $prenom =$recu["prenom"];
        if($mail== $mailb and $mdp==$mdpb ) {
         $_SESSION["id"] = $id;
         $_SESSION["mail"] = $mail;
         $_SESSION["prenom"] = $prenom;
         header("location:Responsable.php");
        }
          $req2 = "select * from technicien where mail='$mail' and mdp='$mdp' " ;
          $resultat = mysqli_query($id, $req2);
          $recu = mysqli_fetch_assoc($resultat);
          $mailb =$recu["mail"];
         $mdpb =$recu["mdp"];
          $prenom =$recu["prenom"];
          if($mail== $mailb and $mdp==$mdpb) {
           $_SESSION["id"] = $id;
           $_SESSION["mail"] = $mail;
           $_SESSION["prenom"] = $prenom;
            header("location:Technicien.php");
             }else{ 
             echo"Mail ou mot de passe incorrect !";
             }
  }

?>

</body>
</html>