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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
  <header>
    <nav class="nav-header" role="navigation">
      <!-- LOGO A GAUCHE -->
      <div class="menu-gauche">
        <a href="Acceuil.php" class="logodaccueil">
          <h1 class="logogo">TICKETING INC.
        </a>
      </div>
      <!-- TOUTES LES PAGES -->
      <div class="menu-droite">
        <a href="afficheclient.php" class="pages"><i class="fa fa-user-circle" aria-hidden="true"></i> Mes demander</a>
        <a href="chatclient.php" class="pages"><img src='chat.png' width='20'></i> Envoyer un message</a>

        <a href="#" class="pages">|</a>
        <a href="Deco.php" class="pages"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</i></a>
      </div>
    </nav>
  </header>

  <body>
    <h1>
      <?php echo "Bonjour $prenomResp"; ?>
    </h1>

    <form name="form-tache" action="" method="POST" enctype='multipart/form-data'>
      <!-- Formulaire où le client remplie les differentes informations à fournir afin d'envoyer son probleme -->
      <div class="form-ticket">

        <a1>Tache :</a1><br><br>
        <select name="tache">
          <!-- file deroulante avec les differents types de taches -->
          <option value="OccuperTache">S'occuper d'une tache</option>
          <option value="Bug">Signaler un bug</option>
          <option value="BesoinAaide">Besoin d'aide</option>
          <option value="TacheAccomplir">Tache à accomplir</option>
          <option value="DmdModif">Demande de modification</option>
          <option value="ProposNvlFct">Proposer une fonctionnalité</option>
          <option value="autres">autres</option>
        </select>

        <a1>Prioritée :</a1><br><br>
        <select name="priorite">
          <!-- file deroulante avec les differentes prioritees -->
          <option value="faible">Faible</option>
          <option value="Normal">Normal</option>
          <option value="Elevee">Elevée</option>
          <option value="Urrgente">Urgente (Vraiment urgent)</option>
        </select>

        <a1>Précision :</a1><br><br>
        <select name="precision">
          <!-- file deroulante avec les differentes precisions du projet -->
          <option value="Interface">Interface (FrontEnd)</option>
          <option value="code">code (préciser la page)</option>
          <option value="bdd">Base de donnée</option>
          <option value="autres">autres</option>
        </select>

        <a1>Complexité :</a1><br><br>
        <select name="complexite">
          <!-- file deroulante de la complexite -->
          <option value="faible">Faible</option>
          <option value="moderee">Modérée</option>
          <option value="Elevee">Elevée</option>
        </select>

        <br><br>
        <a2>Détails :</a2><br><br>
        <input type="text" name="details" placeholder="Decrire la tâche, donner des le max de details ...:" required>

        <br>
        <a3>Ajouter un fichier :</a3><br><br>
        <input type="file" name="fichier">
        <!-- le client peut deposer un fichier -->
        <br><br>

        <?php

        echo "<select name='tech'>";
        $resultat = mysqli_query($id, 'select * from technicien order by prenom DESC');
        while ($ligne = mysqli_fetch_assoc($resultat)) {
          echo "<option value = " . $ligne["prenom"] . " > " . $ligne["prenom"] . "</option>";
        }

        echo "<option value = 'NPAJ' > Ne pas ajouter </option> </select>";

        ?>

        <input type="submit" value="Créer la tâche" name="boot">
        <!-- en cliquant sur 'enregistrer le probleme' le client envoyer ces information qui seront ajouter à la table 'probleme' dans la bdd -->
      </div>
    </form>
    <?php

    //si il clique sur 'enregistrer' le probleme' alors :
    if (isset($_POST["boot"])) {
      //recupere toutes les donnees du formulaire
      extract($_POST);

      $fichier = $_FILES["fichier"]['name'];

      // si il n'a pas ajouter de participant
      if ($tech == "NPAJ") {
        $tech = null;
      }

      //enregistrer les informations de la tache dans la bdd
      $result = mysqli_query($id, "Insert into tickets values (NULL, '$prenomResp', now(), '$tache', '$precision',
      '$details', '$priorite', '$complexite' ,'$fichier' ,'$prenomResp, $tech','En attente')");

      if (!$result) {

        die("L'insertion a échoué : " . mysqli_error($id));
      } else {

        echo "<script>alert('La nouvelle tâche a été crée avec succée !!');</script>";
        echo "<script>window.location = 'MesTickets.php';</script>";
      }

    }

    ?>
    <br>
    <a href="Deco.php">Deconnexion</a>
    <!-- lien qui deconnecte le client -->
    <a href="afficheClient.php">affiche Client</a>
    <!-- lien qui redirige le client à la page qui affiche ses problemes envoyé -->
    <a href='Acceuil.php'>Page d'acceuil</a>
    <!-- lien qui redirige le client à la page d'acceuil  -->
  </body>

</html>