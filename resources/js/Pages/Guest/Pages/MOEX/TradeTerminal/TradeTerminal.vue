<template>
    <div class="min-h-screen bg-gray-900 text-white flex flex-col">
        <TerminalHeader />

        <main class="flex-grow p-2">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <TradeCard v-for="(data, index) in stockData" :key="index" :ticker="data.ticker"
                    :purchaseVolume="data.purchaseVolume" :saleVolume="data.saleVolume" :priceChange="data.priceChange"
                    :relativeVolume="data.relativeVolume" />
            </div>
        </main>
    </div>
</template>

<script setup>
import TerminalHeader from '@/Components/Header/TerminalHeader.vue';
import TradeCard from '@/Components/Terminal/TradeCard.vue';
import { ref, onMounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';


const props = defineProps({
    stockData: {
        type: Array,
        required: true,
    }
})

const getSharesTrades = () => {
    router.reload({
        only: stockData
    })
}

console.log(props.stockData)
</script>

<style scoped>
/* Добавьте свои стили здесь */
</style>

