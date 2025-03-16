<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    streamStatus: {
        type: Object,
        default: () => ({})
    }
});

// Запуск стрима
const startStream = () => {
    if (confirm('Вы уверены, что хотите запустить стрим?')) {
        router.post(route('stream.start'), {
            preserveScroll: true,
            onSuccess: () => alert('Стрим успешно запущен')
        });
    }
};

// Остановка стрима
const stopStream = () => {
    if (confirm('Вы уверены, что хотите остановить стрим?')) {
        router.delete(route('stream.stop'), {
            preserveScroll: true,
            onSuccess: () => alert('Стрим успешно остановлен')
        });
    }
};

// Перезапуск стрима
const restartStream = () => {
    if (confirm('Вы уверены, что хотите перезапустить стрим?')) {
        router.patch(route('stream.restart'), {
            preserveScroll: true,
            onSuccess: () => alert('Стрим успешно перезапущен')
        });
    }
};

// Обновление данных стрима
const updateStreamData = () => {
    router.patch(route('stream.data.update'), {
        preserveScroll: true,
        onSuccess: () => alert('Данные стрима обновлены')
    });
};
</script>

<template>
    <Head title="Управление стримом" />

    <AuthenticatedLayout>
        <div class="px-5">
            <div class="mx-auto">
                <!-- Панель управления -->
                <div class="flex justify-end font-sans font-semibold text-stone-700 gap-4 p-4">
                    <button @click="startStream" class="rounded hover:text-black hover:scale-105 duration-300">
                        Запустить стрим
                    </button>
                    <button @click="stopStream" class="rounded hover:text-black hover:scale-105 duration-300">
                        Остановить стрим
                    </button>
                    <button @click="restartStream" class="rounded hover:text-black hover:scale-105 duration-300">
                        Перезапустить стрим
                    </button>
                    <button @click="updateStreamData" class="rounded hover:text-black hover:scale-105 duration-300">
                        Обновить данные
                    </button>
                </div>

                <!-- Информация о стриме -->
                <div v-if="streamStatus" class="bg-gray-400/70 rounded-lg p-6 shadow-xl hover:bg-gray-400/40 transition-all duration-200">
                    <h3 class="mb-4 text-xl text-center font-bold text-gray-900/90">Статус стрима</h3>
                    <div class="space-y-2">
                        <p>Статус:
                            <span v-if="streamStatus.is_active" class="font-semibold text-green-400">Активен</span>
                            <span v-else class="font-semibold text-red-500">Неактивен</span>
                        </p>
                        <p>Запущен: <span class="font-semibold">{{ streamStatus.started_at || 'Не запущен' }}</span></p>
                        <p>Остановлен: <span class="font-semibold">{{ streamStatus.stopped_at || 'Не остановлен' }}</span></p>
                        <p>Последнее обновление: <span class="font-semibold">{{ streamStatus.last_updated || 'Нет данных' }}</span></p>
                        <p>Ошибки: <span class="font-semibold">{{ streamStatus.errors || 'Нет ошибок' }}</span></p>
                    </div>
                </div>

                <!-- Сообщение, если данных о стриме нет -->
                <div v-else class="text-center text-gray-500 mt-6">
                    Данные о стриме недоступны.
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
