<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    shares: {
        type: Array,
        default: () => []
    }
});

const handleUpload = () => {
    router.get(route('stocks.upload'), {
        preserveScroll: true,
        onSuccess: () => alert('Акции успешно загружены')
    });
};

const handleDelete = () => {
    if (confirm('Вы уверены, что хотите удалить все акции?')) {
        router.delete(route('stocks.delete-all'), {
            preserveScroll: true,
            onSuccess: () => alert('Акции успешно удалены')
        });
    }
};

const updateVolume = (stockId) => {
    router.patch(route('stocks.update-volume', stockId), {
        preserveScroll: true,
        onSuccess: () => alert('Объем обновлен')
    });
};
</script>

<template>

    <Head title="Панель управления" />

    <AuthenticatedLayout>
        <div class="px-5">
            <div class="mx-auto ">
                <!-- Панель управления -->
                <div class="flex justify-end font-sans font-semibold text-stone-700 gap-4 p-4">
                    <button @click="handleUpload" class="rounded  hover:text-black hover:scale-105 duration-300">
                        Загрузить акции
                    </button>
                    <button @click="handleDelete" class="rounded hover:text-black hover:scale-105 duration-300">
                        Удалить акции
                    </button>
                    <button @click="" class="rounded hover:text-black hover:scale-105 duration-300">
                        Обновить объемы
                    </button>
                </div>

                <!-- Список акций -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-6">
                    <div v-for="share in shares" class="overflow-hidden rounded-lg bg-gray-400/70 p-6 shadow-xl
                    hover:bg-gray-400/40 shadow-stone-200/50 hover:scale-105 duration-200 transition-all">
                        <h3 class="mb-4 text-xl text-center font-bold text-gray-900/90 ">{{ share.company_name }}</h3>
                        <div class="space-y-2">
                            <p>Тикер: <span class="font-semibold">{{ share.ticker}}</span></p>
                            <p>Сектор: <span class="font-semibold">{{ share.sector }}</span></p>
                            <p>Лотность: <span class="font-semibold">{{ share.lot}}</span></p>
                            <p>Short:
                                <span v-if="share.short_enabled_flag" class="font-semibold text-green-400">Да</span>
                                <span v-else class="font-semibold text-red-400">Нет</span>
                            </p>
                            <p>Выпущено бумаг:
                                <span class="font-semibold">{{ share.issue_size}}</span>
                            </p>
                        </div>
                        <div class="mt-6 flex gap-4 text-gray-800/50 shadow-lg">
                            <button @click="updateVolume(stock.id)"
                                class="w-full rounded bg-slate-500 px-4 py-2 hover:scale-105 hover:text-black font-semibold duration-200 hover:bg-slate-600/50">
                                Обновить объем
                            </button>
                            <button @click="deleteStock(stock.id)"
                                class="w-full rounded bg-red-500/30 px-4 py-2 duration-200 hover:scale-105  hover:text-black font-semibold  hover:bg-red-600/50">
                                Удалить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
