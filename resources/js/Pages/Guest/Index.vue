<template>
    <div class="flex flex-col min-h-screen bg-black text-white">
        <header class="text-center p-2">
            <div class="flex flex-row justify-between">
                <Logo />
            </div>
        </header>

        <main class="flex-grow">
            <section id="features" class="py-10">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                        <ServiceCard
                            title="Интерактивные графики"
                            description="Визуализированные данные о торгах на фондовом и срочном рынке."
                            link="graph"
                            shadowColor="hover:shadow-emerald-500 text-emerald-500"
                        />
                        <ServiceCard
                            title="Терминал"
                            description="Следите за торгами в режиме реального времени"
                            link="terminal"
                            shadowColor="hover:shadow-sky-500"
                        />
                        <ServiceCard
                            title="Аналитика по опционам"
                            description="Стройте прогнозы по данным опционов"
                            link="option"
                            shadowColor="hover:shadow-orange-500"
                        />
                    </div>
                </div>
            </section>

            <section id="examples" class="py-10 bg-gray-900">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold text-center mb-6">Наши сервисы</h2>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Терминал для отслеживания торгов в реальном времени по срочным и фондовым активам</li>
                        <li>Подробное изучение палитры сделок по инструментам</li>
                    </ul>
                </div>
            </section>
        </main>

        <footer class="text-right p-1">
            <p class="text-amber-500">&copy; 2024 MoexLAB.</p>
        </footer>
    </div>
</template>

<script setup>
import Logo from '@/Components/Header/Logo.vue';
import ServiceCard from '@/Components/MainPage/ServiceCard.vue';

</script>

<style scoped>
/* Дополнительные стили можно добавить здесь */
</style>
