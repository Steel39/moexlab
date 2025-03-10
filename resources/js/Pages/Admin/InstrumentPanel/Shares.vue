<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    stocks: {
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
                </div>

                <!-- Список акций -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="overflow-hidden rounded-lg bg-gray-800/50 p-6 shadow-xl shadow-stone-200/50">
                        <h3 class="mb-4 text-xl text-center font-bold text-white">Apple</h3>
                        <div class="space-y-2">
                            <p class="text-gray-300">Тикер: <span class="font-semibold">AAPL</span></p>
                            <p class="text-gray-300">Сектор: <span class="font-semibold">Технологии</span></p>
                            <p class="text-gray-300">Лотность: <span class="font-semibold">10</span></p>
                            <p class="text-gray-300">Short:
                                <span class="font-semibold text-green-400">On</span>
                            </p>
                            <p class="text-gray-300">Выпущено бумаг:
                                <span class="font-semibold">8985416548465</span>
                            </p>
                            <p class="text-gray-300">Объем торгов (неделя):
                                <span class="font-semibold">159956</span>
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
