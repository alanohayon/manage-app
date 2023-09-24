<?php

session_start();


require_once '../models/Project.php';
require_once '../models/User.php';
require_once '../config.php';


// Initialisation de l'objet Projet
$projet = new Project();

// Message d'erreur ou de succès
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom_projet'])) {
    $nomProjet = $_POST['nom_projet'];

    // Assurez-vous d'avoir l'id de l'utilisateur dans la session
    if (isset($_SESSION["mail_user"])) {
        $idUser = $_SESSION["mail_user"];

        // Préparation du tableau $data
        $data = array(
            'id_projet' => NULL,  // c'est un champ auto-incrémenté
            'nom_projet' => $nomProjet,
            'date_creation' => date("Y-m-d H:i:s"),  // Date et heure actuelle
            'id_createur' => $idUser
        );

        // Appel de la méthode pour créer le projet
        $result = $projet->creerProjet($data);

        if ($result === true) {
            $message = "Projet créé avec succès!";
        } else {
            $message = $result;  // Renvoie l'erreur de la base de données
        }
    } else {
        $message = "Erreur : ID de l'utilisateur non trouvé!";
    }
}

$projets = [];

if (isset($_SESSION["mail_user"])) {
    $emailUser = $_SESSION["mail_user"];

    // Instanciez l'objet User
    $userModel = new User();

    // Utilisez la méthode getIdByEmail du modèle User
    $idTechnicien = $userModel->getIdByEmail($emailUser);

    if ($idTechnicien) {
        $projets = $projet->recupProjets($idTechnicien);
    }




}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div id="body" x-data="{ isOpen: false }">
<?php include '../header.php'; ?>

<div class="bg-gray-200 h-screen flex justify-center">
<div class="bg-white p-8 rounded-lg shadow-md w-3/4">
    <h2 class="text-2xl mb-6 text-center font-bold shadow-md py-4"
        style=" color: black;
                border-bottom: 4px solid #f43f5e;
                line-height: 1.5;">
        <p style="  color: black;     display: inline-block;

                    border-bottom: 2px solid #f43f5e;
                    line-height: 1.5;">
            Dashboard
        </p>
    </h2>
    <div class="text-center">
        <button @click="isOpen = !isOpen" type="button" class="inline-flex items-center px-3 py-2 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2" >
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
        </button>
        <?php if ($projets === []) {
            echo "<h3 class='mt-2 text-sm font-semibold text-gray-900'>Aucun projet</h3>";
            echo "<p class='mt-1 text-sm text-gray-500'>Commencer par créer un nouveau projet.</p>";
        }
         ?>

        <div class="mt-2 mb-16">
            <button @click="isOpen = !isOpen" type="button" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 bg-rose-500" style="box-shadow: #f43f5e 0px 0px 0px 4px inset, rgb(255, 255, 255) -10px 10px 0px -3px, rgb(253, 164, 175) -10px 10px, rgb(255, 255, 255) -20px 20px 0px -10px;">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Nouveau Projet
            </button>
        </div>
    </div>

    <ul role="list" class="mx-auto mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 lg:gap-8">
        <?php
        foreach($projets as $p) {
        ?>
        <li class="rounded-2xl  h-32 flex justify-center flex-col" style="box-shadow: #f43f5e 0px 0px 0px 4px inset, rgb(255, 255, 255) 10px -10px 0px -3px, rgb(253, 164, 175) 10px -10px, rgb(255, 255, 255) 20px -20px 0px -3px;">
            <div class="w-full flex justify-end pr-3 text-black">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008z" />
                </svg>
            </div>
            <div class=" flex justify-center flex-col -mt-3">
                <h3 class="text-xl font-semibold leading-7 tracking-tight text-black text-center"><?php echo $p['nom_projet']; ?></h3>
                <p class="text-sm leading-6 text-gray-400 text-center py-1">créé par <?php echo $p['createur']; ?></p>
                <ul role="list" class="flex justify-center gap-x-6">
                    <li>
                        <a href="projet.php?id_projet=<?php echo $p['id_projet']; ?>" class="text-gray-400 hover:text-gray-300 flex flex-row">
                            <span class="">ouvrir&nbsp;&nbsp;</span>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>

                        </a>
                    </li>

                </ul>
            </div>
        </li>

        <!-- More project... -->

            <?php
                    }
        ?>
    </ul>


</div>
</div>


<div x-show="isOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <form action="dashboard.php" method="post">
                <div>
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Créer un projet</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Donner un nom à votre projet pour démarrer.</p>
                        </div>

                        <div>
                            <input type="text" name="nom_projet" id="nom_projet" required class="mt-1 p-2 w-full border rounded-md">
                        </div>

                    </div>
                </div>
                    <input type="submit"  class="mt-5 sm:mt-6 inline-flex hover:cursor-pointer sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 shadow-sm rounded-md px-3 py-2 text-sm font-semibold w-full text-white" style="background-color: #3E497A" value="Créer">
                    <button type="button" @click="isOpen = !isOpen" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Annuler</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Affichage du message d'erreur ou de succès si nécessaire -->
    <?php if ($message): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p><?= $message ?></p>
        </div>
    <?php endif; ?>
</div>

</div>
</body>
</html>