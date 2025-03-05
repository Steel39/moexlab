<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Панель управления" />

    <AuthenticatedLayout>


        <div class="py-12">
            <div class="mx-auto  sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-gray-900/80 shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
