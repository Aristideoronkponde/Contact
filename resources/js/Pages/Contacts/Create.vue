<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-8">
        <!-- Le conteneur garde sa taille actuelle -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un contact</h2>
                    <ContactFormComponent :isEdit="false" :countries="countries" />
                </div>
            </div>
        </div>
    </div>
</template>



<script setup>
import ContactFormComponent from '@/Components/ContactFormComponent.vue';

defineProps({
    countries: Array,
});
</script>