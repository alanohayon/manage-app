<?php
session_start();
?>
<?php
$idp = $_GET[ "idp"];   //la variable 'idp' retient l'id du probleme de la ligne selectionné
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); //connexion à la bdd
$req="delete from Probleme where idp='$idp'"; //requete qui supprime le probleme
$resultat = mysqli_query ($id, $req) ; //execution de la requette
header("location:afficheClient.php"); //redirection pour le client à l'affichage des problemes deja envoyé
?>

<?php
$idp = $_GET[ "idp"];  //la variable 'idp' retient l'id du probleme de la ligne selectionné
$id = mysqli_connect("127.0.0.1:8889","root","root","SA"); //connexion à la bdd
$req="delete from archiveprob where idp='$idp'";//requete qui supprime le probleme de la table probleme
$resultat = mysqli_query ($id, $req) ;//execution de la requette
header("location:affichearchive.php");//redirection pour le responsable à l'affichage des problemes
?>

