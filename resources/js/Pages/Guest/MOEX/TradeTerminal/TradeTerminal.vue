<template>
    <div class="min-h-screen bg-stone-950 text-white flex flex-col">
        <TerminalHeader />
        <main class="flex-grow p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8 gap-8">
                <TradeCard v-for="data in stockData"
                           :ticker="data.ticker"
                           :purchaseVolume="data.buy_volume"
                           :saleVolume="data.sell_volume"
                           :priceChange="data.price_difference"
                           :relativeVolume="data.relative_volume" />
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
        required: false,
    }
})


const getSharesTrades = () => {
    router.reload({
        only: stockData
    })
}

</script>

<style scoped>
/* Добавьте свои стили здесь */
</style>

