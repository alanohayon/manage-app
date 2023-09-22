<?php
session_start();
$prenom=($_SESSION["prenom"]);  //variable prenom qui retient le prenom de la personne connecté
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
    <link rel="stylesheet" href="style-header.css">
    <link rel="stylesheet" href="style.css">

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
<h1>
<?php echo"Bonjour $prenom";?>
</h1>

    <form action="" method="post">
    <input type="text" name="message" placeholder="Message :">

       
        <br>
        <?php
        $id = mysqli_connect("127.0.0.1:8889","root","root","SA");
        echo"<select name='tech'>";
        $resultat = mysqli_query($id, "select * from technicien "); 
        while($ligne = mysqli_fetch_assoc($resultat)){
          echo"<option ligne=". $ligne["prenom"].">". $ligne["prenom"]."</option>";
         }
         echo" </select>";
        ?>
        <input type="submit" value="Envoyer" name="bout"> <br><br>
    </form>
     
<?php
$id = mysqli_connect("127.0.0.1:8889","root","root","SA");
if(isset($_POST["bout"]))
{
    if(!isset($_POST["message"]) or empty($_POST["message"]))
    {
        echo "Vous avez oublié de saisir votre message!!!";
    }else{
    $message = $_POST["message"];
    $dest = $_POST["tech"];
    $req = "insert into messages values (NULL, now(), '$prenom', '$dest', '$message')";
    $resultat = mysqli_query($id, $req);
    ?>

               <ul>
               <?php
                   $req = "SELECT * FROM messages
                   WHERE (expediteur='$prenom' AND destinataire = '$dest') 
                   or (expediteur='$dest' AND destinataire = '$prenom')order by idm desc";
                $resultat = mysqli_query($id, $req);
                while($ligne = mysqli_fetch_assoc($resultat)){ ?>
                    <li><div class="date"><?=$ligne["date"]?></div><div class="prenom">
                          <?=$ligne["expediteur"];echo':';?></div>
                        <div class="msg"><?=$ligne["message"]?></div></li>
                 <?php } ?>  
               </ul>
<br><br>
<?php } ?>   
<?php
 }
?>

</body>
</html>