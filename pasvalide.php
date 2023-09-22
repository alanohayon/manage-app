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
<?php
$idp = $_GET[ "idp"];
$id = mysqli_connect("127.0.0.1:8889","root","root","SA");
$req="update Probleme set statut = 'En attente' where idp='$idp'";
$resultat = mysqli_query ($id, $req) ;
header("location:Responsable.php");
?>
