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
</head>

<body>

  <h1> Se connecter</h1>

  <div class="formulaire-connexion">
    <form action="" method="post">
      <input type="email" name="mail" placeholder="@" required><br><br>
      <input type="password" name="mdp" placeholder="Mot de passe :" required><br><br>
      <input type="submit" value="Se connecter" name="bout">
    </form>
  </div>

  <?php

  if (isset($_POST["bout"])) {

    // On recupere les donnees du formulaire
    extract($_POST); 
    // connexion a la bdd
    $id = mysqli_connect("127.0.0.1:8889", "root", "root", "ticketing"); 
    //verifie si il existe dans la bdd
    $req = "select * from responsable where mail='$mail' and mdp='$mdp'"; 
    $resul = mysqli_query($id, $req);

    //Verifie si la requete renvoie un resultat 
    if (mysqli_num_rows($resul) > 0) {

    // on met les resultat de la requete dans la variable recu
      $recu = mysqli_fetch_assoc($resul); 
      $mailb = $recu["mail"];
      $prenomResp = $recu["prenom"];

      $_SESSION["id"] = 
      $_SESSION["prenomResp"] = $prenomResp;
      $_SESSION["mail"] = $mailb;

      header("location:home.php");
    } else {

      echo ("Erreur ou n'existe pas");
    }

  }


  // $req = "select * from client where mail='$mail' and mdp='$mdp' " ;
  // $resultat = mysqli_query($id, $req);
  // $recu = mysqli_fetch_assoc($resultat); //recuperation de la requete
  // $mailb =$recu["mail"];
  // $prenom =$recu["prenom"];
  // $mdpb =$recu["mdp"];
  // if($mail== $mailb and $mdp==$mdpb){
  // $_SESSION["id"] = $id;
  // $_SESSION["prenom"] = $prenom;
  // $_SESSION["mail"] = $mailb;
  // header("location:ProbClient.php");
  // }

  // $req2 = "select * from technicien where mail='$mail' and mdp='$mdp' " ;
  // $resultat = mysqli_query($id, $req2);
  // $recu = mysqli_fetch_assoc($resultat);
  // $mailb =$recu["mail"];
  // $mdpb =$recu["mdp"];
  // $prenom =$recu["prenom"];
  // if($mail== $mailb and $mdp==$mdpb) {
  // $_SESSION["id"] = $id;
  // $_SESSION["mail"] = $mail;
  // $_SESSION["prenom"] = $prenom;
  // header("location:Technicien.php");
  // }else{
  // echo"Mail ou mot de passe incorrect !";
  // }
  ?>


</body>

</html>