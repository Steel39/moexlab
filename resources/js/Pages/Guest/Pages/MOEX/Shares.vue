<script setup>
import {ref} from "vue";

const props = defineProps({
    tradeArray: {
        type: Array,
        required: true
    }
});
console.log(props.tradeArray)

</script>

<template>
    <div class="bg-gray-900 text-white min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-black p-4 flex flex-col">
            <button class="flex rounded-sm justify-center">
                <h1 class="text-3xl font-bold text-center text-red-600">Moex</h1>
                <h1 class="text-3xl bg-orange-500 rounded-md font-bold text-center text-black">lab</h1>
            </button>

            <nav class="mt-2">
                <ul class="flex justify-center space-x-4">
                    <li><a href="#" class="hover:text-orange-500">Главная</a></li>
                    <li><a href="#" class="hover:text-orange-500">Аналитика</a></li>
                    <li><a href="#" class="hover:text-orange-500">Торговля</a></li>
                    <li><a href="#" class="hover:text-orange-500">Контакты</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-grow p-4">
            <h2 class="text-2xl font-semibold text-center mb-4">Аналитика рынка</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="trade in props.tradeArray">
                    <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold">Акция 1</h3>
                        <p>Цена: 1000 ₽</p>
                        <p>Изменение: +5%</p>
                    </div>
                </div>

                <!-- Добавьте больше карточек по мере необходимости -->
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-black p-4 text-center">
            <p>&copy; 2025 MoexHub. Экономическое порно</p>
        </footer>
    </div>
</template>

<style scoped>

</style>
