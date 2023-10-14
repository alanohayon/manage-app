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

<div id="body" x-data="{ openProfile: false }">

    <?php include_once '../components/little-nav.php'; ?>
    <?php include_once '../components/header-nav.php'; ?>


    <div id="activity-page">
        <div id="head" class="flex flex-row justify-between px-4 pt-6">
            <div id="title">
                <h1 class="text-2xl">
                    Mon activité
                </h1>
            </div>
            <div id="create-project">
                <button @click="isOpen = ! isOpen" class="bg-black hover:bg-gray-700 text-white text-lg py-2 px-4 rounded-full border-b border-b-red-500 border-b-2">
                    Créer un projet
                </button>
            </div>

        </div>
    </div>


</div>

</div>




</body>
</html>