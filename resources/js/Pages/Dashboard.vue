<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ContactComponent from '@/Components/ContactComponent.vue';
import { useToast } from 'vue-toastification';
import { onMounted, onUnmounted } from 'vue';
defineProps({
    contacts: Array,
});

const toast = useToast();

onMounted(() => {
    window.Echo.channel('contacts')
        .listen('.contact.created', (event) => {
            toast.success(event.message, {
                timeout: 7000,
                position: 'top-right', // Position du toast
            });
            // Recharger les contacts pour mettre à jour la liste
            Inertia.reload({ only: ['contacts'] });
        });

    window.Echo.channel('contacts')
        .listen('.contact.deleted', (event) => {
            toast.success(event.message, {
                timeout: 7000,
                position: 'top-right', // Position du toast
                // coleur du toast
            });
            // Recharger les contacts pour mettre à jour la liste
            Inertia.reload({ only: ['contacts'] });
        });

    window.Echo.channel('contacts')
        .listen('.contact.updated', (event) => {
            toast.success(event.message, {
                timeout: 7000,
                position: 'top-right', // Position du toast
            });
            // Recharger les contacts pour mettre à jour la liste
            Inertia.reload({ only: ['contacts'] });
        });
});

onUnmounted(() => {
    window.Echo.leave('contacts');

});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <ContactComponent :contacts="contacts" />

                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
