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
$idp = $_GET[ "idp"]; //la variable 'idp' retient l'id du probleme de la ligne selectionné
$id = mysqli_connect("127.0.0.1:8889","root","root","SA");
//connexion a la bdd
$req0="select * from Probleme where idp='$idp'";  //requete qui recupere les données du probleme concerné
$resultat0 = mysqli_query ($id, $req0) ; //execute la requete
$ligne = mysqli_fetch_assoc($resultat0);
//reitient chaque priorite dans une variable
$mail =$ligne["mail"];
$date =$ligne["date"];
$prod =$ligne["produit"];
$desc=$ligne["description"];
$fichier =$ligne["fichier"];
$mail =$ligne["mail"];
$tech =$ligne["technicien"];
$req="insert into ArchiveProb values ('$idp', '$mail', '$date', now(),'$prod','$desc','$fichier','$tech','Termine')";
//inserer dans les archives les problemes valides par le responsable 
$resultat = mysqli_query ($id, $req) ;
//execute la requete
$req1="delete from Probleme where idp='$idp'";
//requete qui supprime le probleme de la table probleme
$resultat1 = mysqli_query ($id, $req1) ;
//execute la requete
header("location:Responsable.php");
// redirection vers la page responsable
?>
