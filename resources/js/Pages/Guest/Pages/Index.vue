<template>
    <div class="min-h-screen bg-black text-white">
        <header class="text-center p-2">
            <div class="flex flex-row justify-between">
                <Logo />
            </div>
        </header>

        <section id="features" class="py-10">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <ServiceCard
                        title="Интерактивные графики"
                        description="Визуализированные данные о торгах на фондовом и срочном рынке."
                        link="/terminal"
                    />
                    <ServiceCard
                        title="Аналитический терминал"
                        description="Следите за торгами в режиме реального времени"
                        link="/terminal"
                    />
                </div>
            </div>
        </section>

        <section id="examples" class="py-10 bg-gray-900">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-6">Наши сервисы</h2>
                <ul class="list-disc list-inside space-y-2">
                    <li>Терминал для отслеживания торгов в реальном времени по срочным и фондовым активам</li>
                    <li>Подробное изучение палитры сделок по конкретным инструментам</li>
                </ul>
            </div>
        </section>

        <footer class="bg-gray-800 text-center py-5">
            <p class="mt-2">Если у вас есть вопросы или вы хотите узнать больше, свяжитесь с нами по электронной почте:
                <a href="mailto:info@analytics.com" class="text-yellow-300 underline">info@analytics.com</a>
            </p>
            <p class="mt-2">&copy; 2024 MoexLAB.</p>
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

Найти еще
