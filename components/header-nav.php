<?php


$current_page = basename($_SERVER['PHP_SELF']);


?>



<div  class="w-full py-2 pl-6 border-b border-b-gray-500 flex flex-row justify-between items-center">
    <div id="section-navigation" class="flex flex-row">
        <div id="home-section">
            <a href="dashboard.php">
                <div id="home-section-button" class="flex items-center pr-3 border-r border-r-1 border-r-gray-500 px-3">
                    <div class="flex flex-row items-center <?= ($current_page == 'dashboard.php') ? 'border-b border-b-red-500 border-b-2' : '' ?>">
                        <div class="pl-1 py-1 ">
                            <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 text-xl">
                            Accueil
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <div id="projects-section">
            <a href="projects-page.php">
                <div id="projects-section-button" class="flex items-center pr-3 border-r border-r-1 border-r-gray-500 px-3">
                    <div class="flex flex-row items-center <?= ($current_page == 'projects-page.php') ? 'border-b border-b-red-500 border-b-2' : '' ?>">
                        <div class="pl-1 py-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13.5H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 text-xl">
                            Projets
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <div id="inbox-section">
            <a href="inbox.php">
                <div id="inbox-section-button" class="flex items-center pr-3 border-r border-r-1 border-r-gray-500 px-3">
                    <div class="flex flex-row items-center <?= ($current_page == 'inbox.php') ? 'border-b border-b-red-500 border-b-2' : '' ?>">
                        <div class="pl-1 py-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" />
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 text-xl">
                            Messagerie
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <div id="activity-section">
            <a href="activity.php">
                <div id="inbox-section-button" class="flex items-center pr-3 px-3">
                    <div class="flex flex-row items-center <?= ($current_page == 'activity.php') ? 'border-b border-b-red-500 border-b-2' : '' ?>">
                        <div class="pl-1 py-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                            </svg>
                        </div>
                        <span class="px-2 py-0.5 text-xl">
                            Activité
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div id="profile-options" class="flex flex-row items-center pr-3 relative" >
        <span class="px-2 py-0.5 text-xl">

        </span>

        <button @click="openProfile = ! openProfile">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
            </svg>
        </button>

    </div>


</div>

<!-- Profile Dropdown -->
<div  x-show="openProfile" @click.away="openProfile = false" class="absolute w-full flex flex-row justify-end pr-4">
    <div class="mt-2 w-80 rounded-md shadow-lg bg-white border border-1 border-gray-500">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

            <div class="flex">

                <div class="w-1/2 flex flex-col justify-center">
                    <a href="#" class="flex flex-row items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="px-2">Profil</span>
                    </a>


                    <a href="#" class="flex flex-row items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        <span class="px-2">Déconnexion</span>
                    </a>
                </div>


                <div class="w-1/2  flex flex-col justify-center">

                    <a href="#" class="flex flex-row items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <span class="px-2">Sécurité</span>
                    </a>


                    <a href="#" class="flex flex-row items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                        <span class="px-2">Aide</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>