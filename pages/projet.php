<?php
//print('$techniciens=<pre>'.print_r($techniciens, true).'</pre><br><br>');
session_start();

require_once '../config.php';
require_once '../models/User.php';
require_once '../models/Tache.php';
require_once '../models/Project.php';

$userModel = new User();
$projetModel = new Project();
$tacheModel = new Tache();


/**
 ******* AUTHENTIFICATION ******
 */
    // Si l'URL contient 'manage-app/inscription', redirigez vers /pages/inscription.php
    if(isset($_GET['url'])) { $urlWanted = $_GET['url']; } else { $urlWanted = ''; }
    if ($urlWanted === 'inscription') {
        header('Location: inscription.php');
        exit;
    } elseif ($urlWanted === 'home') {
        header('Location: home.php');
        exit;
    } elseif ($urlWanted === 'connexion') {
        header('Location: connexion.php');
        exit;
    } elseif ($urlWanted === 'profil') {
        header('Location: profil.php');
        exit;
    }
    // Vérifiez si l'utilisateur est connecté
    if (!isset($_SESSION["mail_user"])) {
    header("Location: inscription.php"); // Redirigez vers la page d'inscription si l'utilisateur n'est pas connecté
    exit();
}
    // Récupérez l'argument GET
    $id_projet = isset($_GET['id_projet']) ? intval($_GET['id_projet']) : null;
    if (!$id_projet) {
        if(isset($_GET['idt'])) {
            $id_tache = $_GET['idt'];
            $id_projet = $_GET['idp'];
            header("Location: ouvrir-tache.php?id_tache=$id_tache&id_projet=$id_projet");
            exit();
        }else {
            die("L'ID du projet est manquant!"); // Si l'ID du projet n'est pas fourni, affichez une erreur
        }
    }
    // Obtenez l'ID du technicien à l'aide de son e-mail
    $idTechnicien = $userModel->getIdByEmail($_SESSION["mail_user"]);
    // Vérifiez si l'utilisateur est associé à ce projet
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM technicien_projet WHERE id_technicien = ? AND id_projet = ?");
    $stmt->execute([$idTechnicien, $id_projet]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['count'] == 0) {
        header("Location: inscription.php"); // Si l'utilisateur n'a pas accès au projet, redirigez-le vers la page d'inscription
        exit();
    }

// À ce stade, l'utilisateur a accès au projet et vous pouvez continuer le traitement pour cette page


/**
 ******* AJOUT D'UNE TACHE ******
 */
$projetDetails = $projetModel->getOneProject($id_projet);

// TRAITEMENT PHP POUR LA CRÉATION D'UNE TÂCHE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre_new_tache'])) {
    $tacheData = [
        'titre' => $_POST['titre_new_tache'],
        'description' => $_POST['description'],
        'statut' => $_POST['statut'],
        'date_de_fin' => $_POST['date_de_fin'],
        'id_projet' => $id_projet
    ];

    $result = $tacheModel->creerTache($tacheData);

    if ($result === true) {
        $messageSuccess = "Tâche créée avec succès!";
        header("Location: projet.php?id_projet=".$id_projet."&message=".$messageSuccess); // Redirigez vers la même page pour actualiser la liste des tâches.
        exit();
    } else {
        echo $result; // Affichez l'erreur.
    }
}


/**
 ******* RÉCUPÉRATION DES TACHES ******
 */
$taches = $tacheModel->getTachesByProjet($id_projet);


/**
 ******* AJOUT D'UN TECHNICIEN AU PROJET ******
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email_technicien'])) {
        $email = $_POST['email_technicien'];

        // Créez une nouvelle instance de votre modèle user.
        $tache2 = new Tache();

        // Obtenez l'ID du technicien à l'aide de l'adresse email.
        $id_technicien = $userModel->getIdByEmail($email);

        $prenom = $userModel->getPrenomById($id_technicien);

        if ($id_technicien) {

            $result = $tache2->ajouterMembre($id_technicien, $id_projet);

            if ($result) {
                $messageSuccess = $prenom." ajouté au projet avec succès!";
            } else {
                echo '
            <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="ajout-technicien-dans-projet">
                <div class="rounded-md bg-red-50 p-4">
                  <div class="flex">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                      </svg>
                    </div>
                    <div class="ml-3">
                      <h3 class="text-sm font-medium text-red-800">Erreur : '.$email.' est déjà dans affecté à ce projet</h3>
                     
                    </div>
                  </div>
                </div>
                
                
                ';

            }
        } else {
            echo "Aucun technicien trouvé avec cet e-mail.";
        }
    }
}

/**
 ******* RÉCUPÉRATION DES MEMBRES ******
 */
// Traitement pour la récupération des membres d'un projet
$members = $projetModel->getMembres($id_projet);


/**
 ******* AJOUT D'UN TECHNICIEN À UNE TÂCHE ******
 */
if(isset($_POST['email_technicien_tache']) && isset($_POST['id_tache'])) {
    $email = $_POST['email_technicien_tache'];
    $id_tache = $_POST['id_tache'];

    // Obtention de l'ID du technicien via l'adresse e-mail
    $id_technicien = $userModel->getIdByEmail($email);

    $prenom = $userModel->getPrenomById($id_technicien);

    $titreTache = $tacheModel->getTitreTache($id_tache);

    if($id_technicien) {
        $result = $tacheModel->ajouterTechnicienSurTache($id_technicien, $id_tache);

        if($result) {
            $messageSuccess = $prenom." ajouté à la tâche: <span class='underline font-bold'>".$titreTache."</span> avec succès!";
        } else {
            echo "Erreur lors de l'ajout du technicien à la tâche.";
        }
    } else {
        echo "Aucun technicien trouvé avec cet e-mail.";
    }
}

/**
 ******* MODIFIER LE STATUT D'UNE TACHE ******
 */

    if(isset($_POST['modifierStatut'])){

        if(isset($_POST['modifierStatut']) && isset($_POST['id_tache']) && isset($_POST['statut'])) {
            $id_tache = $_POST['id_tache'];
            $statut = $_POST['statut'];

            // Appeler la méthode pour mettre à jour le statut de la tâche
            $result = $tacheModel->updateStatutTache($id_tache, $statut);

            $titreTache = $tacheModel->getTitreTache($id_tache);

            if($result === true) {
                $messageSuccess = "Statut de la tâche modifié avec succès: la tâche <span class='underline font-bold'>".$titreTache."</span> est maintenant sur le statut : <b>".$statut."</b>";
            } else {
                echo "Erreur lors de la modification du statut de la tâche: " . $result;
            }
        }


}

/**
 ******* GET MESSAGE FROM URL ******
 */
if(isset($_GET['message'])) {
    $messageSuccess = $_GET['message'];
}
/**
 ******* CLOSE NOTIFICATION ******
 */
if(isset($_POST['fermerNotif'])) {
    unset($messageSuccess);
    unset($_POST['fermerNotif']);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div id="body" x-data="{ isOpen: false, modifierStatut: false, isOpenMembre: false, ajouterMembre: false, ajouterTechnicienSurTache: false,  currentTaskId: null}">

    <?php include '../header.php'; ?>


    <?php if (isset($messageSuccess)): ?>
        <!-- ALERTE SUCCESS  -->
        <div class="rounded-md bg-green-100 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800"><?php echo $messageSuccess; ?></p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <form method="post">
                        <button type="submit" name="fermerNotif" value="fermer" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                            <span class="sr-only">Fermer</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <!-- NAVIGATION  -->

    <nav class="flex justify-center items-center " aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4 w-3/4 my-4 p-4 border border-4">
            <li>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                    </svg>
                    <a href="dashboard.php" class="text-xl font-medium text-gray-700 hover:text-gray-800 hover:underline flex flex-row h-full ml-2">
                        Dashboard
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center -ml-2">
                    <svg class="h-10 w-10 flex-shrink-0 text-gray-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                    <a href="#" class="text-xl font-medium text-gray-700 hover:text-gray-700 hover:underline" aria-current="page"><p>Projet: <?php echo "" . $projetDetails['nom_projet'] . "</p>"; ?></a>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white p-8 w-full flex justify-center">
        <h2 class="text-4xl text-center font-bold border-emerald-500"
            style="     color: black;
                                    border-bottom: 5px solid #6ee7b7;
                                    display: inline-block;
                                    line-height: 1.5;">
            <?php echo "<p>" . $projetDetails['nom_projet'] . "</p>"; ?></h2>
    </div>
    <!-- FENETRE MESSAGE - EQUIPE - MODIFIER  -->
    <div class="flex justify-center my-1 mt-4 md:mt-0">

        <!-- MESSAGES  -->
        <div class="p-8 rounded-lg flex justify-center items-center flex-col px-2 mx-4 w-1/5" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
            </svg>
        </div>

        <!-- EQUIPE  -->
        <div class="rounded-lg lg:w-2/6 flex justify-center flex-col px-2 py-2" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div>
            <div class="sm:flex w-full flex justify-center mb-2">
                <div class="sm:flex-auto p-3">
                    <h1 class="text-lg leading-6 text-gray-900 border-orange-500 font-bold	"
                        style="     color: black;
                                    border-bottom: 5px solid #fbbf24;
                                    display: inline-block;
                                    line-height: 1.5;">
                        Membres de l'équipe :
                    </h1>
                </div>

                <!-- OUVERTURE DE LA FENETRE DE FORMULAIRE DE L'AJOUT D'UN MEMBRE  -->
                <div class="mt-2 sm:ml-16 sm:mt-0 sm:flex-none p-3">
                    <button @click="isOpenMembre = !isOpenMembre" type="button" class="block rounded-md bg-orange-500 px-3 py-2 text-center text-xs font-semibold text-white shadow-sm hover:bg-orange-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">Nouveau membre +</button>
                </div>
            </div>
            </div>

            <!-- AFFICHER LES MEMBRES-->
            <div class="flex justify-between w-1/2">
            <?php foreach($members as $member): ?>


                    <div class="flex flex-col justify-center items-center ml-2">
                        <div class="flex justify-center">
                            <img class="h-10 w-10 rounded-full" alt="icone-verte" src="../img/icons/icone-verte.png">
                        </div>
                        <div class="flex justify-center">
                            <p class="text-xs font-semibold text-gray-900 w-12 truncate text-center"><?= $member['prenom'] ?>&nbsp;</p>

                        </div>
                    </div>
            <?php endforeach; ?>
            </div>

        </div>

        <!-- MODIFIER PROJET  -->
        <div class="rounded-lg flex justify-center items-center flex-col px-2 mx-4 w-1/5" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>

        </div>

    </div>

    <!-- TACHES  -->
    <div class="flex w-full justify-center mt-6">

    <div id="tasks" class="rounded-lg w-3/4 flex justify-center" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
     <div class="mt-8 w-full px-4 sm:px-6 lg:px-8">
         <!-- TITRE TACHE + BOUTON AJOUT TACHE  -->
        <div class="sm:flex sm:items-center w-full flex justify-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-semibold leading-6 text--900"
                    style="     color: black;
                                    border-bottom: 5px solid #4f46e5;
                                    display: inline-block;
                                    line-height: 1.5;">
                    Tâches à effectuer :
                </h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <!-- OUVERTURE DE LA FENETRE DE FORMULAIRE DE NOUVELLE TACHE  -->
                <button @click="isOpen = !isOpen"  type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Ajouter</button>
            </div>
        </div>

        <div class="mt-8 flow-root w-full">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg  mb-32">


                        <!-- TABLEAU DE LA LISTE DES TACHES  -->

                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tâche</th>
                                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Assigné à...</th>
                                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Messages</th>
                                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Statut</th>
                                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Date de fin</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only ">Editer</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">

                            <?php foreach($taches as $tache): ?>
                                <?php $techniciens = $tacheModel->getTechniciens($tache['id_tache']); ?>
                                <tr>
<!-- AFFICHER LE TITRE-------------><td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?= $tache['titre'] ?></td>

<!------------------------------------------------------------------------------------------------>
<!-- AFFICHER LES TECHNICIENS -->
<!-- BOUTON AJOUTER UN TECH -->
<!-- FENETRE AJOUTER UN TECH -->    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 flex flex-row items-center justify-center">
<!------------------------------------------------------------------------------------------------>
 <!-- AFFICHER LES TECHNICIENS -->
                                        <div class="flex -space-x-0.5 mt-4">
                                            <div class="flex justify-between w-full items-end">
                                                <?php foreach($techniciens as $technicien): ?>
                                                    <div class="flex flex-col justify-center items-center ml-2">
                                                        <div class="flex justify-center">
                                                            <img class="h-10 w-10 rounded-full" alt="icone-verte" src="../img/icons/icone-verte.png">
                                                        </div>
                                                        <div class="flex justify-center">
                                                            <p class="text-xs font-semibold text-gray-900 w-12 truncate text-center"><?= $technicien['prenom'] ?>&nbsp;</p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

<!------------------------------------------------------------------------------------------------>
<!-- BOUTON AJOUTER UN TECHNICIEN -->   <button  @click="currentTaskId = <?= $tache['id_tache'] ?>; ajouterTechnicienSurTache = true">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-grey-700 w-8 h-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>

                                        </button>

<!------------------------------------------------------------------------------------------------>
<!-- FENETRE DE FORMULAIRE DE L'AJOUT D'UN TECHNICIEN A UNE TACHE  -->
                                        <div   x-show="ajouterTechnicienSurTache" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="ajout-technicien-sur tache">

                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                                            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                                    <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">



                                                        <div id="liste-techniciens">

                                                        </div>

                                                        <form action="" method="post">
                                                            <div>
                                                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                    </svg>
                                                                </div>
                                                                <div class="mt-3 text-center sm:mt-5">
                                                                    <!-- Titre de la fenêtre  -->
                                                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title" x-text="'Ajouter un technicien à cette tâche qui possède l'id' + currentTaskId"></h3>

                                                                    <div class="mt-2 mb-4">
                                                                        <p class="text-sm text-gray-500">Sélectionnez un technicien pour l'ajouter à la tâche.</p>
                                                                    </div>

                                                                    <!-- Liste des techniciens du projet avec bouton  -->


                                                                    <!-- Champ caché pour l'id de la tache -->
                                                                    <input type="hidden" name="id_tache" x-bind:value="currentTaskId">

                                                                    <!-- Champ Email du Technicien -->
                                                                    <div>
                                                                        <label for="email_technicien_tache" class="block text-sm font-medium text-gray-700 text-left mt-2 mr-1.5">Adresse e-mail du membre affecté à la tâche</label>
                                                                        <input type="email" name="email_technicien_tache" id="email_technicien_tache" class="mt-1 p-2 w-full border rounded-md" placeholder="mail@example.com">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <input type="submit" name="ajouter_technicien" class="mt-5 sm:mt-6 inline-flex hover:cursor-pointer sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 shadow-sm rounded-md px-3 py-2 text-sm font-semibold w-full text-white" style="background-color: #3E497A" value="Ajouter">
                                                            <button type="button" @click="ajouterTechnicienSurTache = !ajouterTechnicienSurTache" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Annuler</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

<!------------------------------------------------------------------------------------------------>
<!-- AFFICHER LES MESSAGES -->      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="flex w-16 gap-x-2.5 justify-center">
                                            <dt>
                                                <span class="sr-only">Total comments</span>
                                                <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                                </svg>
                                            </dt>
                                            <dd class="text-sm leading-6 text-gray-900">24</dd>
                                        </div>
                                    </td>

<!------------------------------------------------------------------------------------------------>
<!-- AFFICHER LE STATUT -->         <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="flex flex-col justify-center">

                                            <?php
                                            $currentStatut = $tacheModel->getStatut($tache['id_tache']);
                                            $class = '';

                                            switch ($currentStatut) {
                                                case "Terminé":
                                                    $class = 'bg-red-500 text-white';
                                                    break;
                                                case "Non commencée":
                                                    $class = 'bg-white text-black';
                                                    break;
                                                case "En cours":
                                                    $class = 'bg-yellow-400 text-white';
                                                    break;
                                                default:
                                                    $class = 'bg-indigo-500 text-white';
                                                    break;
                                            }
                                            ?>

                                            <p id="statut" class="flex justify-center p-1 border border-1 <?= $class ?>"><?= $currentStatut ?></p>

                                        <button type="button" @click="currentTaskId = <?= $tache['id_tache'] ?>; modifierStatut = !modifierStatut" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Modifier</button>
<!------------------------------------------------------------------------------------------------>
<!-- FENETRE DE FORMULAIRE DE L'AJOUT D'UN TECHNICIEN A UNE TACHE  --><div x-show="modifierStatut" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="ajout-technicien-dans-projet">

                                            <div class="fixed inset-0"></div>

                                            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                                <div class="flex min-h-full items-end justify-center p-4 text-center sm:p-0 mb-8">
                                                    <div class="relative transform overflow-hidden border border-2 rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                                        <form action="projet.php?id_projet=<?php echo $id_projet; ?>" method="post">

                                                            <div>
                                                                <!-- Modifier le statut avec un Select qui est soit "En cours", soit "Non commencée", soit "Terminé" -->
                                                                <div>
                                                                    <label for="statut" class="block text-sm font-medium text-gray-700 text-left mt-2 mr-1.5">Statut de la tâche</label>
                                                                    <select name="statut" id="statut" class="mt-1 p-2 w-full border rounded-md">
                                                                        <option value="Non commencée">Non commencée</option>
                                                                        <option value="En cours">En cours</option>
                                                                        <option value="Terminé">Terminé</option>
                                                                    </select>


                                                                </div>
                                                                <input type="hidden" name="id_tache" x-bind:value="currentTaskId">

                                                                <input type="submit" name="modifierStatut" class="mt-5 sm:mt-6 inline-flex hover:cursor-pointer sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 shadow-sm rounded-md px-3 py-2 text-sm font-semibold w-full text-white" style="background-color: #3E497A" value="Modifier">
                                                                <button type="button" @click="modifierStatut = !modifierStatut" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Annuler</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        </div>
                                    </td>

<!------------------------------------------------------------------------------------------------>
<!-- AFFICHER LA DATE FIN -->       <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= $tache['date_de_fin'] ?></td>

<!------------------------------------------------------------------------------------------------>
<!-- OUVRIR LA TACHE -->            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 ">
                                        <?php

                                        $idp = $_GET['id_projet'];
                                        $idt = $tache['id_tache'];
                                        ?>
                                        <a href="?idp=<?= $idp ?>&idt=<?= $idt ?>" class="text-grey-700 tracking-tighter hover:text-white hover:bg-gray-700 border border-2 p-2 rounded-full border-gray-700">OUVRIR<span class="sr-only">, <?= $tache['titre'] ?></span></a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>

                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
        <!-- FENETRE DE FORMULAIRE DE NOUVELLE TACHE  -->
    <div x-show="isOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="ajout-tache-dans projet">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <form action="projet.php?id_projet=<?php echo $id_projet; ?>" method="post">
                        <div>
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-5">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Créer une tâche</h3>
                                <div class="mt-2 mb-4">
                                    <p class="text-sm text-gray-500">Donner un titre et une description à votre tâche pour démarrer.</p>
                                </div>

                                <!-- Champ Titre de la tâche -->
                                <div>
                                    <label for="titre_new_tache" class="block text-sm font-medium text-gray-700  text-left mt-2 mr-1.5">Titre de la tâche</label>
                                    <input type="text" name="titre_new_tache" id="titre_new_tache" required class="mt-1 p-2 w-full border rounded-md">
                                </div>

                                <!-- Champ Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700  text-left mt-2 mr-1.5">Description</label>
                                    <textarea name="description" id="description" required class="mt-1 p-2 w-full border rounded-md"></textarea>
                                </div>

                                <!-- Champ caché pour le statut -->
                                <input type="hidden" name="statut" value="Non commencée">

                                <!-- Champ Date de fin -->
                                <div>
                                    <label for="date_de_fin" class="block text-sm font-medium text-gray-700 text-left mt-2 mr-1.5">Date de fin</label>
                                    <input type="date" name="date_de_fin" id="date_de_fin" class="mt-1 p-2 w-full border rounded-md">
                                </div>

                            </div>
                        </div>
                        <input type="submit" class="mt-5 sm:mt-6 inline-flex hover:cursor-pointer sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 shadow-sm rounded-md px-3 py-2 text-sm font-semibold w-full text-white" style="background-color: #3E497A" value="Créer">
                        <button type="button" @click="isOpen = !isOpen" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Annuler</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

        <!-- FENETRE DE FORMULAIRE DE L'AJOUT D'UN MEMBRE  -->
        <?php include 'windows/new-member.php'; ?>


</div>

</body>
</html>