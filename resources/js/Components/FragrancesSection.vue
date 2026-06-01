<script setup>
import { ref, onMounted } from 'vue';

const fragrances = ref([]);
const loading    = ref(true);
const error      = ref('');

onMounted(async () => {
    try {
        const res = await fetch('/api/fragrances');
        if (!res.ok) throw new Error('Error al cargar fragancias');
        fragrances.value = await res.json();
    } catch (e) {
        error.value = e.message;
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <section class="py-12 bg-amber-50 dark:bg-neutral-800 border-b border-amber-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4">

            <h2 class="text-3xl font-bold text-center mb-2 text-black dark:text-white">
                Nuestras Fragancias
            </h2>
            <p class="text-center text-neutral-600 dark:text-gray-400 mb-8">
                Catálogo cargado desde la API
            </p>

            <p v-if="loading" class="text-center text-neutral-500 dark:text-gray-400">Cargando...</p>
            <p v-else-if="error" class="text-center text-red-500">{{ error }}</p>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="fragrance in fragrances"
                    :key="fragrance.id"
                    class="border border-amber-100 dark:border-gray-800 rounded-xl overflow-hidden shadow-sm bg-white dark:bg-gray-800 flex flex-col"
                >
                    <!-- Imagen -->
                    <div class="w-full h-48 bg-neutral-800 dark:bg-neutral-800 overflow-hidden">
                        <img
                            v-if="fragrance.image_url"
                            :src="fragrance.image_url"
                            :alt="fragrance.name"
                            class="w-full h-full object-cover"
                        />
                        <div
                            v-else
                            class="w-full h-full flex items-center justify-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="p-4 flex flex-col flex-grow">

                        <!-- Marca + colección -->
                        <p class="text-xs text-neutral-500 dark:text-gray-400 mb-1 uppercase tracking-wide">
                            {{ fragrance.brand?.name }}
                            <span v-if="fragrance.collection"> · {{ fragrance.collection.nombre }}</span>
                        </p>

                        <!-- Nombre -->
                        <h3 class="font-bold text-base text-black dark:text-white mb-2">
                            {{ fragrance.name }}
                        </h3>

                        <!-- Descripción -->
                        <p class="text-sm text-neutral-600 dark:text-gray-400 flex-grow line-clamp-3">
                            {{ fragrance.description }}
                        </p>

                        <!-- Footer de la card -->
                        <div class="flex justify-between items-center mt-4 pt-3 border-t border-amber-100 dark:border-gray-700">
                            <span class="font-bold text-black dark:text-white text-lg">
                                ${{ Number(fragrance.price).toLocaleString('es-MX') }}
                            </span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs bg-amber-100 dark:bg-gray-700 text-neutral-800 dark:text-amber-50 px-2 py-1 rounded-full font-medium">
                                    {{ fragrance.concentration }}
                                </span>
                                <span class="text-xs text-neutral-500 dark:text-gray-400">
                                    Stock: {{ fragrance.stock }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
</template>