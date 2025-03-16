<template>
    <button @click="getLink(link)" :class="`block bg-gray-800 p-6 rounded-lg  transition-shadow-transform duration-300
     transform hover:scale-105 shadow-lg ${shadowColor}`">
        <h3 class="text-2xl font-semibold text-white">{{ title }}</h3>
        <p class="text-gray-300">{{ description }}</p>
    </button>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
const form = useForm({})

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
    link: {
        type: String,
        required: true,
    },
    shadowColor: {
        type: String,
        required: true
    },
})


const getLink = (link) => {
    form.get(route(link))
}
</script>

<style scoped>
/* Добавьте дополнительные стили, если необходимо */
</style>
