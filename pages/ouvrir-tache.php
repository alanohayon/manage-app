<?php
session_start();

//print('$_GET=<pre>'.print_r($_GET, true).'</pre><br><br>');

require_once '../models/Tache.php';
require_once '../models/Project.php';

$tache = new Tache();
$data = $tache->getOneTache($_GET['id_tache']);
$tech_on_tache = $tache->getTechniciens($_GET['id_tache']);

$projet = new Project();
$tech_on_project = $projet->getTechniciansByProjectId($data['id_projet']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTech'])) {
        $tache->addTech($_POST['id_technicien'], $_POST['id_tache']);
    }

    if (isset($_POST['removeTech'])) {
        $tache->removeTech($_POST['id_technicien'], $_POST['id_tache']);
    }

    // Après avoir effectué l'opération, rafraîchissez les données pour refléter les changements.
    $tech_on_tache = $tache->getTechniciens($_GET['id_tache']);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâche <?php echo $data['description']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div id="body">
    <?php include '../header.php'; ?>



    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="ajout-tache-dans projet">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto border border-green-500 border-2 flex justify-center">



            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0 w-3/4">



                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full  sm:p-6">

                    <!-- NAVIGATION  -->
                    <nav class="flex w-full justify-left mb-8 -ml-2" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-4 w-3/4 pt-2">
                            <li>
                                <div class="flex items-center">


                                    <a href="dashboard.php" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700 flex flex-row h-full ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 -mt-0.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-2.25-1.313M21 7.5v2.25m0-2.25l-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3l2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75l2.25-1.313M12 21.75V19.5m0 2.25l-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                    </svg>
                                    <a href="projet.php?id_projet=<?=$data['id_projet']?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Projet: </a>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <div class="">
                        <h1 class="text-3xl font-semibold leading-6 text-gray-900 mb-10">Tâche : <?php echo $data['titre']; ?></h1>
                        <h1 class="text-xl font-semibold leading-6 text-gray-900 mb-10">Description : <?php echo $data['description']; ?></h1>

                        <h2 class="underline">Liste des techniciens (à affecter au choix à la tâche)</h2>


                        <table class="w-1/2">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ajouter</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tech_on_project as $tech): ?>
                            <?php $isAssigned = $tache->isOnTache($tech['id'], $data['id_tache']); ?>

                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $tech['nom'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $tech['prenom'] ?></td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_technicien" value="<?= $tech['id'] ?>">
                                        <input type="hidden" name="id_tache" value="<?= $data['id_tache'] ?>">
                                        <input type="hidden" name="addTech" value="1">
                                        <button type="submit" class="text-white font-bold p-1.5 rounded-full <?= $isAssigned ? 'bg-gray-500 cursor-not-allowed' : 'bg-green-500' ?>" <?= $isAssigned ? 'disabled' : '' ?>>Ajouter</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_technicien" value="<?= $tech['id'] ?>">
                                        <input type="hidden" name="id_tache" value="<?= $data['id_tache'] ?>">
                                        <input type="hidden" name="removeTech" value="1">
                                        <button type="submit" class="text-white font-bold p-1.5 rounded-full <?= $isAssigned ? 'bg-red-500' : 'bg-gray-500 cursor-not-allowed' ?>" <?= !$isAssigned ? 'disabled' : '' ?>>Supprimer</button>
                                    </form>
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

</body>
</html>
