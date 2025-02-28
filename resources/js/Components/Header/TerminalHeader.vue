<template>
    <h1 class="text-3xl  font-bold"></h1>
    <header class="flex p-2 gap-4 justify-center bg-transparent">
        <TerminalHeaderButton
        v-for="button in headerButton"
            :name="button.name"
            :color="button.color"
            :route="button.route"
        />
    </header>
</template>

<script setup>

import TerminalHeaderButton from './Buttons/TerminalHeaderButton.vue';
import { ref } from 'vue';


const headerButton = ref([
    {
        name: 'Акции',
        color: 'blue',
        route: 'getTradesOnSharesPerDay'
    },
    {
        name: 'Фьючерсы',
        color: 'emerald',
        route: 'getTradeOnFuturesPerDay'
    }
])


</script>
