<template>
    <div class="min-h-screen bg-gray-900 text-white flex flex-col">
        <header class="p-4 bg-gray-800">
            <h1 class="text-3xl font-bold">Аналитический терминал</h1>
        </header>

        <main class="flex-grow p-2">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <TradeCard v-for="(data, index) in stockData" :key="index" :ticker="data.ticker"
                    :purchaseVolume="data.purchaseVolume" :saleVolume="data.saleVolume" :priceChange="data.priceChange"
                    :relativeVolume="data.relativeVolume" />
            </div>
        </main>
    </div>
</template>

<script>
import TradeCard from '@/Components/Terminal/TradeCard.vue';

export default {
    name: 'Terminal',
    components: {
        TradeCard,
    },
    data() {
        return {
            stockData: [
                {
                    ticker: 'AAPL',
                    purchaseVolume: 12000,
                    saleVolume: 9000,
                    priceChange: '+2.5%',
                    relativeVolume: '0.05',
                },
                {
                    ticker: 'GOOGL',
                    purchaseVolume: 4000,
                    saleVolume: 8000,
                    priceChange: '+3.1%',
                    relativeVolume: '0.51'
                },
                {
                    ticker: 'GOOGL',
                    purchaseVolume: 12200,
                    saleVolume: 8000,
                    priceChange: '+3.1%',
                    relativeVolume: '0.42'
                },
                {
                    ticker: 'GOOGL',
                    purchaseVolume: 6500,
                    saleVolume: 7000,
                    priceChange: '+3.1%',
                    relativeVolume: '0.6'
                },
                {
                    ticker: 'GOOGL',
                    purchaseVolume: 4650,
                    saleVolume: 6500,
                    priceChange: '+3.1%',
                    relativeVolume: '0.45'
                },
                {
                    ticker: 'GOOGL',
                    purchaseVolume: 4000,
                    saleVolume: 6000,
                    priceChange: '+3.1%',
                    relativeVolume: '0.2'
                },
            ],
        };
    },
};
</script>

<style scoped>
/* Дополнительные стили, если необходимо */
</style>
