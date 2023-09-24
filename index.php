<?php

// Récupérez la requête URI et nettoyez-la des slashes inutiles
$requestUri = trim($_SERVER['REQUEST_URI'], '/');



// Si l'URL contient 'manage-app/inscription', redirigez vers /pages/inscription.php
if(isset($_GET['url'])) { $urlWanted = $_GET['url']; } else { $urlWanted = ''; }


if ($urlWanted === 'inscription') {
    header('Location: pages/inscription.php');
    exit;
} elseif ($urlWanted === 'home') {
    header('Location: pages/home.php');
    exit;
} elseif ($urlWanted === 'connexion') {
    header('Location: pages/connexion.php');
    exit;

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage-App</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<?php include 'header.php'; ?>

<div class="overflow-hidden bg-white pt-16">
    <div class="mx-auto max-w-7xl px-6 lg:flex lg:px-8">
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-12 gap-y-16 lg:mx-0 lg:min-w-full lg:max-w-none lg:flex-none lg:gap-y-8">
            <div class="lg:col-end-1 lg:w-full lg:max-w-lg lg:pb-8">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Ticketing - Gestion de projet</h2>
                <!-- CONTENU 1 A REDIGER -->
                <p class="mt-6 text-xl leading-8 text-gray-600">
                    À l'ère de la numérisation, la gestion de projet pour les étudiants n'a jamais été aussi simple. De la création de projets, à l'assignation des tâches et sous-tâches, en passant par le suivi en temps réel de chaque étape grâce à un système de statuts, tout est là. Mais ce n'est pas tout : facilitez la communication et l'échange d'idées avec un chat intégré pour chaque projet et tâche.
                </p>
                <!-- CONTENU 2 A REDIGER-->

                <div class="flex justify-between items-center mt-6">
                    <p class="text-base leading-7 text-gray-600">
                        Il vous suffit d'une adresse mail pour vous connecter et créer / collaborer sur notre plateforme.
                    </p>
                    <form action="" method="get" class="text-white px-3.5 py-2.5 rounded-md shadow-sm flex flex-row items-center" style="background-color: #3E497A">
                        <input type="hidden" name="url" value="inscription">
                        <input type="submit" value="Découvrir " class="hover:cursor-pointer">
                        <span aria-hidden="true">&rarr;</span>
                    </form>

                </div>
            </div>
            <div class="flex flex-wrap items-start justify-end gap-6 sm:gap-8 lg:contents">
                <div class="w-0 flex-auto lg:ml-auto lg:w-auto lg:flex-none lg:self-end">
                    <img src="https://images.unsplash.com/photo-1568992687947-868a62a9f521?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1152&h=842&q=80" alt="" class="aspect-[7/5] w-[37rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover">
                </div>
                <div class="contents lg:col-span-2 lg:col-end-2 lg:ml-auto lg:flex lg:w-[37rem] lg:items-start lg:justify-end lg:gap-x-8">
                    <div class="order-first flex w-64 flex-none justify-end self-end lg:w-auto">
                        <img src="https://images.unsplash.com/photo-1605656816944-971cd5c1407f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=768&h=604&q=80" alt="" class="aspect-[4/3] w-[24rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover">
                    </div>
                    <div class="hidden sm:block sm:w-0 sm:flex-auto lg:w-auto lg:flex-none">
                        <img src="https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=768&h=604&q=80" alt="" class="aspect-[4/3] w-[24rem] max-w-none rounded-2xl bg-gray-50 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>
</body>
</html>
