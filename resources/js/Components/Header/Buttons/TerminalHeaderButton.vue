<template>
    <button @click="getRoute(route)" :class="`p-1 text-orange-500/30 text-xl font-mono bg-red-400/20
 rounded-md
 hover:text-orange-500 hover:scale-110 transition-all duration-300 font-semibold`">
{{ name }}
    </button>

</template>

<script setup>

import { useForm } from '@inertiajs/vue3';

const form = useForm({})

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    route: {
        type: String,
        required: true,
    }
})

const getRoute = (routeName) => {
    form.get(route(routeName), {
        preserveScroll: true
    })
}
</script>
