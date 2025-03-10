<template>
    <button
        @click="getRoute(route)"
        :class="`p-1 text-xl font-sans bg-red-400/20 rounded-md ${buttonColor} hover:scale-110 transition-all duration-300 font-semibold`">
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
    },
    color: {
        type: String,
        required: true
    }
});

const buttonColor = `text-${props.color}-400`;

const getRoute = (routeName) => {
    router.visit(route(routeName), {
        only: ['stockData']
    });
};
</script>

