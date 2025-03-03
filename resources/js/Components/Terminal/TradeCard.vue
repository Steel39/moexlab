<template>
    <div :style="{ boxShadow: shadowStyle }" class="bg-gray-800 rounded-lg p-4
    hover:scale-105 transition-transform duration-300">
        <h2 class="text-xl font-semibold text-orange-400">{{ ticker }}</h2>
        <div class="flex justify-between mt-2">
            <div>
                <p class="text-green-400 font-bold">{{ purchaseVolume }}</p>
                <p class="text-red-400 first:font-bold">{{ saleVolume }}</p>
            </div>
            <div>
                <p class="text-white"><span :class="priceChangeClass">{{ priceChange }}</span></p>
                <p class="text-white">{{ relativeVolume }}</p>
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
        type: Float32Array,
        required: true,
    },
    relativeVolume: {
        type: Float32Array,
        required: true,
    },
});

// Вычисляемое свойство для стиля тени
const shadowStyle = computed(() => {
    // Определяем размер тени в зависимости от относительного объема, увеличивая его в 3 раза
    let shadowSize = 80 * props.relativeVolume;
    if (shadowSize > 80) {
        shadowSize = 80;
    }

    // Определяем цвет тени в зависимости от преобладания покупок или продаж
    let shadowColor = 'rgba(0, 0, 0, 0.8)'; // Цвет по умолчанию

    const totalVolume = props.purchaseVolume + props.saleVolume;
    const purchaseRatio = props.purchaseVolume / totalVolume;
    const saleRatio = props.saleVolume / totalVolume;

    if (totalVolume > 0) {
        // Определяем цвет тени в зависимости от преобладания покупок или продаж
        if (purchaseRatio > saleRatio) {
            // Преобладают покупки
            const ratio = Math.min(1, purchaseRatio); // Убедимся, что ratio не превышает 1
            const redIntensity = Math.round(255 * (1 - ratio)); // Красный компонент уменьшается
            const greenIntensity = Math.round(255 * ratio); // Зеленый компонент увеличивается
            shadowColor = `rgba(${redIntensity}, ${greenIntensity}, 0, 1)`; // Переход от красного к зеленому
        } else {
            // Преобладают продажи
            const ratio = Math.min(1, saleRatio); // Убедимся, что ratio не превышает 1
            const greenIntensity = Math.round(255 * (1 - ratio)); // Зеленый компонент уменьшается
            const redIntensity = Math.round(255 * ratio); // Красный компонент увеличивается
            shadowColor = `rgba(${redIntensity}, ${greenIntensity}, 0, 1)`; // Переход от зеленого к красному
        }
    }

    return `0 0 ${shadowSize}px ${shadowColor}`; // Устанавливаем размер и цвет тени
});
</script>

<style scoped>
/* Добавьте любые дополнительные стили, если необходимо */
</style>

Найти еще
