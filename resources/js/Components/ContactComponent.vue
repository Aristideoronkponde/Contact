<template>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Gestion des contacts</h2>
            <Link
                :href="route('contacts.create')"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                Ajouter un contact
            </Link>
        </div>

        <!-- Débogage -->
        <div v-if="!contacts || contacts.length === 0" class="text-gray-500">
            Aucun contact trouvé.
        </div>

        <!-- Liste des contacts -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <ContactCardComponent
                v-for="contact in contacts"
                :key="contact.id"
                :contact="contact"
                @delete="deleteContact"
            />
        </div>
    </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia'; // Ajout de l'importation
import { Link } from '@inertiajs/vue3';
import ContactCardComponent from '@/Components/ContactCardComponent.vue';
import Swal from 'sweetalert2';

defineProps({
    contacts: Array,
});


const deleteContact = (id) => {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Ce contact sera définitivement supprimé.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(route('contacts.destroy', id), {
                onSuccess: () => {
                    Swal.fire(
                        'Supprimé !',
                        'Le contact a été supprimé avec succès.',
                        'success'
                    );
                },
                onError: (errors) => {
                    Swal.fire(
                        'Erreur',
                        'Une erreur est survenue lors de la suppression.',
                        'error'
                    );
                    console.error('Erreur lors de la suppression:', errors);
                },
            });
        }
    });
};

</script>