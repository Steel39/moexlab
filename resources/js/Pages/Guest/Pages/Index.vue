<template>
    <Welcome >
        <header class="bg-blue-600 text-white py-20 rounded-lg">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-4xl text-gray-200 font-bold">Добро пожаловать в аналитический терминал</h1>
                <p class="mt-4 text-lg">Получайте актуальные данные и принимайте обоснованные решения</p>
            </div>
        </header>

        <!-- Основной контент -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Карточка 1 -->
                <button>
                    <div class="bg-white shadow rounded-lg p-6 hover:bg-gray-100 hover:shadow-md duration-200">
                        <h2 class="text-xl font-semibold">Акции</h2>
                        <p class="mt-2 text-gray-600">Здесь вы можете увидеть данные по сделкам на Московской бирже.</p>
                    </div>
                </button>

                <button>
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold">Фьючерсы</h2>
                    <p class="mt-2 text-gray-600">Срочные бумаги имеют интерес у более квалифицированных трейдеров.</p>
                </div>
                </button>
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold">Опционы</h2>
                    <p class="mt-2 text-gray-600">Стройте анализ решений на основе данных по опционам</p>
                </div>
            </div>
        </main>

    </Welcome>
</template>

<script setup>

import Welcome from "@/Pages/Welcome.vue";
import {useForm} from "@inertiajs/vue3";
const form = useForm;

const getShares = () => {

}

</script>

<style scoped>

</style>
