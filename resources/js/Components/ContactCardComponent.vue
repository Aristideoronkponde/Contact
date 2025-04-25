<template>
    <div
        class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 max-w-sm mx-auto"
    >
        <div class="p-6">
            <!-- En-tête avec drapeau et nom -->
            <div class="flex items-center mb-4">
                <img
                    v-if="contact.country_flag"
                    :src="contact.country_flag"
                    alt="Drapeau"
                    class="w-8 h-5 mr-3 rounded-sm border border-gray-200"
                />
                <h3 class="text-xl font-bold text-gray-900 truncate">{{ contact.name }}</h3>
            </div>

            <!-- Informations du contact -->
            <div class="space-y-3">
                <p class="flex items-center text-sm text-gray-600">
                    <EnvelopeIcon class="w-5 h-5 mr-2 text-gray-500" />
                    <span class="font-semibold">Email :</span>
                    <span class="ml-1">{{ contact.email }}</span>
                </p>
                <p class="flex items-center text-sm text-gray-600">
                    <PhoneIcon class="w-5 h-5 mr-2 text-gray-500" />
                    <span class="font-semibold">Téléphone :</span>
                    <span class="ml-1">{{ contact.phone || 'N/A' }}</span>
                </p>
                <p class="flex items-center text-sm text-gray-600">
                    <BriefcaseIcon class="w-5 h-5 mr-2 text-gray-500" />
                    <span class="font-semibold">Entreprise :</span>
                    <span class="ml-1">{{ contact.company || 'N/A' }}</span>
                </p>
                <p class="flex items-center text-sm text-gray-600">
                    <GlobeAltIcon class="w-5 h-5 mr-2 text-gray-500" />
                    <span class="font-semibold">Pays :</span>
                    <span class="ml-1">{{ contact.country }}</span>
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
            <Link
                :href="route('contacts.show', contact.id)"
                class="flex items-center text-blue-600 hover:text-blue-800 transition-colors"
            >
                <EyeIcon class="w-5 h-5 mr-1" />
                Voir
            </Link>
            <Link
                :href="route('contacts.edit', contact.id)"
                class="flex items-center text-green-600 hover:text-green-800 transition-colors"
            >
                <PencilIcon class="w-5 h-5 mr-1" />
                Modifier
            </Link>
            <button
                @click="$emit('delete', contact.id)"
                class="flex items-center text-red-600 hover:text-red-800 transition-colors"
            >
                <TrashIcon class="w-5 h-5 mr-1" />
                Supprimer
            </button>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import {
    EyeIcon,
    PencilIcon,
    TrashIcon,
    EnvelopeIcon,
    PhoneIcon,
    BriefcaseIcon,
    GlobeAltIcon,
} from '@heroicons/vue/24/outline';

defineProps({
    contact: Object,
});

defineEmits(['delete']);
</script>