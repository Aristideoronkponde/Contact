<template>
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Détails du contact</h2>
                    <ContactCardComponent :contact="contact" />
                    <div class="mt-6">
                        <Link
                            :href="route('dashboard')"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                        >
                            Retour
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ContactCardComponent from '@/Components/ContactCardComponent.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    contact: Object,
});
</script>