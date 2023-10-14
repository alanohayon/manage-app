<?php

require_once '../authentication.php';

// from authentication.php :

// $user_email
// $user_id

var_dump($_SESSION["mail_user"]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['project_name']) && !empty($_POST['project_name'])) {
        $project_name = $_POST['project_name'];
        $id_createur = $user_id;

        // Créez un nouveau projet
        $project_id = $projectModel->createProject($project_name, $id_createur);

        if ($project_id) {
            // Ajoutez l'email du créateur du projet à la table `user_link_project`
            $projectModel->addUserToProject($user_email, $project_id);

            // Ajouter les collaborateurs
            if (isset($_POST['collaborateurs']) && is_array($_POST['collaborateurs'])) {
                foreach ($_POST['collaborateurs'] as $collaborateur_email) {
                    if (!empty($collaborateur_email)) {
                        $projectModel->addUserToProject($collaborateur_email, $project_id);
                    }
                }
            }

            // Redirigez vers une page de réussite ou affichez un message de succès
            echo "Projet créé avec succès!";
        } else {
            // Message d'erreur
            echo "Erreur lors de la création du projet.";
        }
    } else {
        // Message d'erreur
        echo "Veuillez fournir un nom de projet.";
    }
}

//todo : traitement pour récuperer tous les projets de l'utilisateur
$all_projects = $projectModel->getAllProjectsForUser($user_email);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body>

<div id="body" x-data="{ openProfile: false, createProject: false }">

    <?php include_once '../components/little-nav.php'; ?>
    <?php include_once '../components/header-nav.php'; ?>


    <div id="project-page" class="h-screen">
        <div id="head" class="flex flex-row justify-between px-10 py-3 border-b border-b-gray-500 ">
            <div id="title" class="flex flex-row items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13.5H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                <h1 class="text-3xl pl-3">
                    Projets
                </h1>
            </div>
            <div id="create-project">
                <button @click="createProject = ! createProject" class="bg-black hover:bg-gray-700 text-white text-lg py-2 px-4 rounded-full border-b border-b-red-500 border-b-2">
                    Créer un projet
                </button>
            </div>
        </div>



    <div id="body-all-projects" class="p-10">
        <div id="all-projects" class="grid grid-cols-3 gap-4">
            <?php foreach ($all_projects as $project): ?>
                <div class="bg-white shadow-md rounded-md p-4 border border-1 border-black">
                    <h2 class="text-xl font-bold"><?= $project['nom_projet'] ?></h2>
                    <p class="text-sm text-gray-500">Créé par <?= $project['createur'] ?></p>
                    <?php var_dump($project['id_projet']);?>
                    <a href="projet.php?id_projet=<?= $project['id_projet'] ?>" class="text-red-500 hover:text-red-700 hover:underline">Voir le projet</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



        <div x-show="createProject"  class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-data="{ collaborators: [''] }" @click.away="createProject = false"  class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                        <form action="projects-page.php" method="post">
                            <div>
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                    <svg class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Créer un projet</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Donner un nom à votre projet pour démarrer.</p>
                                    </div>

                                    <div>
                                        <input type="text" name="project_name" id="project_name" required class="mt-1 p-2 w-full border rounded-md">
                                    </div>

                                </div>

                                <div class="mt-3 text-center sm:mt-5">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900">Ajouter des collaborateurs</h3>
                                    <p class="text-sm text-gray-500">Inviter des collaborateurs à rejoindre votre projet.</p>

                                    <template x-for="(collaborator, index) in collaborators" :key="index">
                                        <div class="flex items-center mt-2">
                                            <input type="text" name="collaborateurs[]" x-model="collaborators[index]" class="p-2 w-full border rounded-md" placeholder="e-mail d'un collaborateur">
                                            <button type="button" @click="collaborators.splice(index, 1)" class="ml-2 text-red-500">
                                                &times;
                                            </button>
                                        </div>
                                    </template>

                                    <button type="button" @click="collaborators.push('')" class="mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                            </div>
                            <input type="submit"  class="mt-5 sm:mt-6 inline-flex hover:cursor-pointer sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 shadow-sm rounded-md px-3 py-2 text-sm font-semibold w-full text-white bg-black"  value="Créer">
                            <button type="button" @click="createProject = !createProject" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Annuler</button>

                    </form>
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- project page -->

</div> <!-- end body -->

</body>
</html>