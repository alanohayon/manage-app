<div x-show="isOpenMembre" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="ajout-technicien-dans-projet">

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
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Ajouter un technicien au projet</h3>
                            <div class="mt-2 mb-4">
                                <p class="text-sm text-gray-500">Sélectionnez un technicien pour l'ajouter au projet.</p>
                            </div>

                            <!-- Champ Email du Technicien -->
                            <div>
                                <label for="email_technicien" class="block text-sm font-medium text-gray-700 text-left mt-2 mr-1.5">Adresse e-mail du nouveau membre</label>
                                <input type="email" name="email_technicien" id="email_technicien" required class="mt-1 p-2 w-full border rounded-md" placeholder="mail@example.com">
                            </div>

                        </div>
                    </div>
                    <input type="submit" name="ajouter_technicien" class="mt-5 sm:mt-6 inline-flex hover:cursor-pointer sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 shadow-sm rounded-md px-3 py-2 text-sm font-semibold w-full text-white" style="background-color: #3E497A" value="Ajouter">
                    <button type="button" @click="isOpenMembre = !isOpenMembre" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Annuler</button>
                </form>
            </div>
        </div>
    </div>


</div>
