<template>
    <form @submit.prevent="submit" class="space-y-8 bg-white p-8 rounded-lg shadow-lg max-w-xl mx-auto">
        <div>
            <label for="name" class="block text-lg font-medium text-gray-800">Nom</label>
            <input
                id="name"
                v-model="form.name"
                type="text"
                class="mt-2 block w-full rounded-md border-2 border-gray-300 bg-gray-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-lg"
                :class="{ 'border-red-500': form.errors.name }"
            />
            <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
        </div>

        <div>
            <label for="email" class="block text-lg font-medium text-gray-800">Email</label>
            <input
                id="email"
                v-model="form.email"
                type="email"
                class="mt-2 block w-full rounded-md border-2 border-gray-300 bg-gray-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-lg"
                :class="{ 'border-red-500': form.errors.email }"
            />
            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</p>
        </div>

        <div>
            <label for="phone" class="block text-lg font-medium text-gray-800">Téléphone</label>
            <input
                id="phone"
                v-model="form.phone"
                type="text"
                class="mt-2 block w-full rounded-md border-2 border-gray-300 bg-gray-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-lg"
                :class="{ 'border-red-500': form.errors.phone }"
            />
            <p v-if="form.errors.phone" class="mt-2 text-sm text-red-600">{{ form.errors.phone }}</p>
        </div>

        <div>
            <label for="company" class="block text-lg font-medium text-gray-800">Entreprise</label>
            <input
                id="company"
                v-model="form.company"
                type="text"
                class="mt-2 block w-full rounded-md border-2 border-gray-300 bg-gray-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-lg"
                :class="{ 'border-red-500': form.errors.company }"
            />
            <p v-if="form.errors.company" class="mt-2 text-sm text-red-600">{{ form.errors.company }}</p>
        </div>

        <div>
            <label for="country" class="block text-lg font-medium text-gray-800">Pays</label>
            <select
                id="country"
                v-model="form.country"
                class="mt-2 block w-full rounded-md border-2 border-gray-300 bg-gray-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-lg"
                :class="{ 'border-red-500': form.errors.country }"
            >
                <option value="" disabled>Sélectionnez un pays</option>
                <option v-for="country in countries" :key="country.name" :value="country.name">
                    {{ country.name }}
                </option>
            </select>
            <p v-if="form.errors.country" class="mt-2 text-sm text-red-600">{{ form.errors.country }}</p>
        </div>

        <div class="flex justify-between space-x-4">
            <Link
                :href="route('dashboard')"
                class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition duration-200"
            >
                Annuler
            </Link>
            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-200"
                :disabled="form.processing"
            >
                {{ isEdit ? 'Mettre à jour' : 'Créer' }}
            </button>
        </div>
    </form>
</template>


<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    contact: Object,
    isEdit: Boolean,
    countries: Array,
});

// Débogage

// Initialiser le formulaire avec useForm
const form = useForm({
    name: props.contact?.name || '',
    email: props.contact?.email || '',
    phone: props.contact?.phone || '',
    company: props.contact?.company || '',
    country: props.contact?.country || '',
});

// const submit = () => {
//     if (props.isEdit) {
//         form.put(route('contacts.update', props.contact.id), {
//             onSuccess: () => form.reset(),
//         });
//     } else {
//         form.post(route('contacts.store'), {
//             onSuccess: () => form.reset(),
//         });
//     }
// };

import Swal from 'sweetalert2';

const submit = () => {
    if (props.isEdit) {
        form.put(route('contacts.update', props.contact.id), {
            onSuccess: () => {
                form.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Contact mis à jour',
                    text: 'Le contact a été mis à jour avec succès.',
                });
            },
            onError: (errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Impossible de mettre à jour le contact.',
                });
                console.error(errors);
            }
        });
    } else {
        form.post(route('contacts.store'), {
            onSuccess: () => {
                form.reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Contact créé',
                    text: 'Le contact a été ajouté avec succès.',
                });
            },
            onError: (errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Impossible d\'ajouter le contact.',
                });
                console.error(errors);
            }
        });
    }
};

</script>