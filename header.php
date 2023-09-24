<?php

// Récupérez la requête URI et nettoyez-la des slashes inutiles
$requestUri = trim($_SERVER['REQUEST_URI'], '/');


// Si l'URL contient 'manage-app/inscription', redirigez vers /pages/inscription.php
if(isset($_GET['url'])) { $urlWanted = $_GET['url']; } else { $urlWanted = ''; }


if ($urlWanted === 'inscription') {
    header('Location: /APPLI-DE-GESTION/manage-app/pages/inscription.php');
    exit;
} elseif ($urlWanted === 'index') {
    header('Location: /APPLI-DE-GESTION/manage-app/index.php');
    exit;
} elseif ($urlWanted === 'connexion') {
    header('Location: /APPLI-DE-GESTION/manage-app/pages/connexion.php');
    exit;
} elseif ($urlWanted === 'profil') {
    header('Location: /APPLI-DE-GESTION/manage-app/pages/profil.php');
    exit;
}



if(isset($_SESSION["mail_user"])) {
    $userMail = $_SESSION["mail_user"];
}

?>

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<header class="h-24 flex items-center justify-between px-10" style="background-color: #3E497A">
    <!-- LOGO A GAUCHE -->
    <form action="" method="get" class="text-white">
        <input type="hidden" name="url" value="index">
        <input type="submit" value="Ticketing" class="hover:cursor-pointer text-xl font-bold underline">
    </form>

    <!-- TOUTES LES PAGES -->
    <div class="flex space-x-5 items-center">
        <!-- J'ai gardé ces liens comme exemple, vous pouvez les ajuster selon vos besoins -->
        <?php if (!isset($userMail)): ?>
        <form action="" method="get" class="text-white">
            <input type="hidden" name="url" value="inscription">
            <input type="submit" value="Inscription" class="hover:cursor-pointer">
        </form>

        <form action="" method="get" class="text-white">
            <input type="hidden" name="url" value="connexion">
            <input type="submit" value="Connexion" class="hover:cursor-pointer">
        </form>
        <?php else: ?>
            <form action="" method="get" class="text-white">
                <button type="submit" class="flex justify-center flex-row hover:cursor-pointer ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="hidden" name="url" value="profil" class="hover:cursor-pointer ">
                    <input type="submit" value="Profil" class="hover:cursor-pointer ">
                </button>
            </form>
        <?php endif; ?>
        <!-- Ajoutez ici d'autres liens si nécessaire -->
    </div>
</header>