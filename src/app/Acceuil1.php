<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <link rel="stylesheet" href="style-header.css">
  <link rel="stylesheet" href="accueil.css">

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
            <a href="Technicien.php" class="pages"><i class="fa fa-user-circle" aria-hidden="true"></i> Technicien</a>
            <a href="Responsable.php" class="pages"><i class="fa fa-eye" aria-hidden="true"></i> Responsable</a>
            <a href="ProbClient.php" class="pages"><i class="far fa-file-alt" aria-hidden="true"></i> Mes demandes</a>
            <a href="afficheClient.php" class="pages"><i class="fa fa-users" aria-hidden="true"></i> Nos Clients</a>
            <a href="#" class="pages">|</a>
            <a href="InscritClient.php" class="pages"><i class="fa fa-database" aria-hidden="true"></i> Inscription</a>
            <a href="Connexion.php" class="pages"><i class="fa fa-cubes" aria-hidden="true"></i> Connexion</a>
            <a href="Deco.php" class="pages"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</i></a>
        </div>
    </nav>
  </header>

   
  <br><br>
    <div class="main">
      <h1>Pourquoi choisir notre solution ?</h1>
    </div>



</body>
</html>