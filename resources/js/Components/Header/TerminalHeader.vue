<template>
    <h1 class="text-3xl  font-bold"></h1>
    <header class="flex p-2 gap-4 bg-transparent">
        <Logo/>
        <div class="flex gap-2 mx-10">
            <TerminalHeaderButton
                v-for="button in headerButton"
                :name="button.name"
                :color="button.color"
                :route="button.route"
            />
        </div>

    </header>
</template>

<script setup>

import TerminalHeaderButton from './Buttons/TerminalHeaderButton.vue';
import { ref } from 'vue';
import Logo from "@/Components/Header/Logo.vue";


const headerButton = ref([
    {
        name: 'Акции',
        color: 'red',
        route: 'getTradesOnSharesPerDay'
    },
    {
        name: 'Фьючерсы',
        color: 'orange',
        route: 'getTradeOnFuturesPerDay'
    }
])


</script>
