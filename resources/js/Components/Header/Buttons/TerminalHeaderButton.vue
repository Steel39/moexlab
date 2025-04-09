<template>
    <button
        @click="getRoute(route)"
        :class="`p-1 text-xl font-sans  rounded-md text-slate-900 drop-shadow-md hover:scale-110 transition-all duration-300 font-semibold`">
        {{ name }}
    </button>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    route: {
        type: String,
        required: true,
    }
});

const getRoute = (routeName) => {
    router.visit(route(routeName), {
        only: ['stockData']
    });
};
</script>

