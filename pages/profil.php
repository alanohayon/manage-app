<?php
session_start();

require_once '../models/User.php';

if(isset($_SESSION["mail_user"])) {
    $useremail = $_SESSION["mail_user"];
} else {
    header("location:../index.php");
}

$user = new User();
$dataUser = $user->getDataByEmail($useremail);





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
<div id="body">
<?php include '../header.php'; ?>

    <div class="w-full flex flex-col items-center">
        <div class="w-10/12">

            <div class="w-full flex p-7 justify-between items-center">
                <div id="name_and_picture" class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div class="ml-4">
                        <p class="text-2xl"><?php echo $dataUser['prenom']." ".$dataUser['nom']; ?></p>
                        <p class="text-sm text-gray-700">Votre profil personnel</p>
                    </div>
                </div>
                <div>
                    <button class="bg-gray-100 hover:bg-gray-200 font-bold py-1 px-3 rounded border border-gray-300" style="font-size: 0.7rem;">
                        Aller au Dashboard
                    </button>
                </div>

            </div>


        </div>
        <div class="w-10/12 h-screen flex flex-row">

            <div class="w-1/2 lg:w-1/3 xl:w-1/4 flex pt-3 pb-5 px-5 h-full">

                <div id="colonne" class="flex flex-col w-full">

                    <div class="my-1" style="border-left-color: rgb(59 130 246); border-width: 4px;">
                        <div class="w-full py-1 px-3 rounded-md my-1 flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>

                            <span class="ml-2 font-bold">Profile </span>

                        </div>
                    </div>
                    <div class="my-1" style="border-width: 4px;">
                        <div class="w-full py-1 px-3 rounded-md my-1 flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                            <span class="ml-2">Compte </span>

                        </div>
                    </div>
                    <div class="my-1" style="border-width: 4px;">
                        <div class="w-full py-1 px-3 rounded-md my-1 flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>

                            <span class="ml-2">Accessibilité </span>

                        </div>
                    </div>




                </div>

            </div>

            <div class="w-full pt-6 px-10">
                <form action="">
                    <div class="py-2" style="border-bottom-color: grey; border-bottom-width: 2px">
                        <span class="text-2xl">Informations du Profil</span>
                    </div>

                    <div class="w-1/2 flex flex-col h-full">
                        <!--NOM ET PRENOM -->
                        <div class="w-full flex flex-row p-4 space-between" id="prenom-nom">
                            <div class="">
                                <label for="prenom" class="block text-sm font-medium leading-6 text-gray-900">Prénom</label>
                                <div class="mt-2">
                                    <input type="text" name="prenom" id="prenom" autocomplete="given-name" value="<?= $dataUser['prenom'] ?>" class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div class="ml-6">
                                <label for="nom" class="block text-sm font-medium leading-6 text-gray-900">Nom</label>
                                <div class="mt-2">
                                    <input type="text" name="nom" id="nom" autocomplete="family-name" value="<?= $dataUser['nom'] ?>" class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>

                        <!--EMAIL -->
                        <div class="w-full flex flex-row pl-4 space-between mt-1.5">
                            <div class="w-10/12">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <div class="mt-2">
                                    <input type="text" name="email" id="email" autocomplete="family-name" value="<?= $dataUser['mail'] ?>" class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>

                        <!--Bio -->
                        <div class="w-full flex flex-row pl-4 space-between mt-1.5">
                            <div class="w-10/12">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Bio</label>
                                <div class="mt-2">
                                    <input type="text" name="email" id="email" autocomplete="family-name" value="Dites-en un peu plus sur vous" class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>


                    </div>

                </form>
            </div>


        </div>
    </div>

</div>
</body>
</html>
