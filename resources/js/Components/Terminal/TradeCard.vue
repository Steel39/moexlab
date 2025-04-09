<template>
    <div v-if="isLoading" class="flex justify-center items-center h-20">
        <svg class="animate-spin h-5 w-5 text-blue-500" viewBox="0 0 24 24"></svg>
    </div>
    <div
        v-else
        :style="{ boxShadow: shadowStyle }"
        class="bg-stone-800/40 border-2 border-gray-950 rounded-lg p-4 hover:scale-105 transition-all duration-300"
    >
        <!-- Заголовок с кликабельным тикером -->
        <h2
            aria-label="Stock ticker"
            class="text-2xl font-bold font-mono text-gray-200/60 drop-shadow-2xl cursor-pointer"
            @click="handleTickerClick"
        >
            {{ ticker }}
        </h2>


        <!-- Основная информация -->
        <div class="flex justify-between mt-2">
            <div>
                <!-- Объем покупок -->
                <p
                    v-tippy="'Объем покупок'"
                    class="text-green-500 text-shadow font-bold flex items-center"
                >
                    {{ formattedPurchaseVolume }}
                </p>

                <!-- Объем продаж -->
                <p
                    v-tippy="'Объем продаж'"
                    class="text-red-600 font-bold flex items-center"
                >
                    {{ formattedSaleVolume }}
                </p>
            </div>
            <div>
                <p class="text-green-500 text-shadow font-bold flex items-center">
                    {{ avgPriceBuy }}
                </p>
                <p class="text-red-600 font-bold flex items-center">
                    {{ avgPriceSell }}
                </p>
            </div>

            <div>
                <!-- Изменение цены -->
                <p class="text-white font-serif">
                    <span :class="priceChangeClass">{{ formattedPriceChange }}%</span>
                </p>

                <!-- Относительный объем -->
                <p class="text-gray-100/40">{{ formattedRelativeVolume }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from 'vue';

// Определение свойств компонента
const props = defineProps({
    ticker: {
        type: String,
        required: true,
    },
    purchaseVolume: {
        type: Number,
        required: true,
    },
    saleVolume: {
        type: Number,
        required: true,
    },
    priceChange: {
        type: Number,
        required: true,
    },
    relativeVolume: {
        type: Number,
        required: true,
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
    avgPriceBuy: {
        type: Number
    },
    avgPriceSell: {
        type: Number
    }

});

// Форматирование чисел
const formattedPurchaseVolume = computed(() => {
    return new Intl.NumberFormat('en-US').format(props.purchaseVolume);
});

const formattedSaleVolume = computed(() => {
    return new Intl.NumberFormat('en-US').format(props.saleVolume);
});

const formattedPriceChange = computed(() => {
    return props.priceChange.toFixed(2);
});

const formattedRelativeVolume = computed(() => {
    return props.relativeVolume.toFixed(2);
});

// Вычисляемое свойство для класса изменения цены
const priceChangeClass = computed(() => {
    return props.priceChange > 0 ? 'text-green-500' : 'text-red-500';
});

// Вычисляемое свойство для соотношения покупок и продаж
const purchaseRatio = computed(() => {
    const totalVolume = props.purchaseVolume + props.saleVolume;
    return totalVolume > 0 ? props.purchaseVolume / totalVolume : 0;
});

const gradientStyle = computed(() => {
    const totalVolume = props.purchaseVolume + props.saleVolume;
    if (totalVolume === 0) return {};

    const purchaseRatio = props.purchaseVolume / totalVolume;

    // Градиент от зеленого (покупки) до красного (продажи)
    return {
        background: `linear-gradient(90deg, #10b981 ${purchaseRatio * 100}%, #f43f5e ${purchaseRatio * 100}%)`,
        width: '100%',
    };
});
// Вычисляемое свойство для стиля тени
const shadowStyle = computed(() => {
    let shadowSize = 80 * props.relativeVolume;
    if (shadowSize > 80) {
        shadowSize = 80;
    }

    let shadowColor = 'rgba(0, 0, 0, 0.8)'; // Цвет по умолчанию

    const totalVolume = props.purchaseVolume + props.saleVolume;
    const purchaseRatio = props.purchaseVolume / totalVolume;
    const saleRatio = props.saleVolume / totalVolume;

    if (totalVolume > 0) {
        if (purchaseRatio > saleRatio) {
            const ratio = Math.min(1, purchaseRatio);
            const redIntensity = Math.round(255 * (1 - ratio));
            const greenIntensity = Math.round(255 * ratio);
            shadowColor = `rgba(${redIntensity}, ${greenIntensity}, 0, 1)`;
        } else {
            const ratio = Math.min(1, saleRatio);
            const greenIntensity = Math.round(255 * (1 - ratio));
            const redIntensity = Math.round(255 * ratio);
            shadowColor = `rgba(${redIntensity}, ${greenIntensity}, 0, 1)`;
        }
    }

    return `0 0 ${shadowSize}px ${shadowColor}`;
});

// Обработчик клика по тикеру
const handleTickerClick = () => {
    console.log(`Clicked on ticker: ${props.ticker}`);
    // Здесь можно добавить логику для перехода на другую страницу или открытия модального окна
};
</script>

<style scoped>
/* Добавьте любые дополнительные стили, если необходимо */
.text-shadow {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}
</style>
