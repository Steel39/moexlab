<template>
    <div class="min-h-screen bg-stone-700/80 text-white flex flex-col">
        <TerminalHeader />
        <main class="flex-grow">
            <!-- Группировка по секторам -->
            <div v-for="(group, sector) in groupedStockData" :key="sector" class="p-8
             bg-gray-950  shadow-lg shadow-gray-800">
                <h2 class="text-2xl text-center mb-10 font-sans font-bold drop-shadow-xl text-stone-400/80">{{ sector }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 2xl:grid-cols-8 gap-8">
                    <TradeCard
                        v-for="data in group"
                        :key="data.ticker"
                        :ticker="data.ticker"
                        :purchaseVolume="data.buy_volume"
                        :saleVolume="data.sell_volume"
                        :priceChange="data.price_difference"
                        :relativeVolume="data.relative_volume"
                        :avgPriceBuy="data.average_price_buy"
                        :avgPriceSell="data.average_price_sell">
                    </TradeCard>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import TerminalHeader from '@/Components/Header/TerminalHeader.vue';
import TradeCard from '@/Components/Terminal/TradeCard.vue';
import { ref, onMounted, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    stockData: {
        type: Array,
        required: false,
        default: () => []
    }
});

// Группируем данные по полю `sector`
const groupedStockData = computed(() => {
    const grouped = {};
    props.stockData.forEach(item => {
        if (!grouped[item.sector]) {
            grouped[item.sector] = [];
        }
        grouped[item.sector].push(item);
    });
    return grouped;
});

// Функция для обновления данных
const getSharesTrades = () => {
    router.reload({
        only: ['stockData']
    });
};

onMounted(() => {
    // При необходимости можно вызвать функцию загрузки данных при монтировании
    // getSharesTrades();
});
</script>

<style scoped>
/* Добавьте свои стили здесь */
</style>
