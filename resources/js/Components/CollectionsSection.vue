<script setup>
import { ref, onMounted } from 'vue';

const collections        = ref([]);
const loading            = ref(true);
const error              = ref('');
const selectedCollection = ref(null);
const loadingFragrances  = ref(false);

onMounted(async () => {
    try {
        const res = await fetch('/api/collections');
        if (!res.ok) throw new Error('Error al cargar colecciones');
        collections.value = await res.json();
    } catch (e) {
        error.value = e.message;
    } finally {
        loading.value = false;
    }
});

async function openModal(collection) {
    selectedCollection.value = { ...collection, fragrances: null };
    loadingFragrances.value  = true;

    try {
        const res = await fetch(`/api/collections/${collection.id}`);
        if (!res.ok) throw new Error('Error al cargar detalles');
        const data = await res.json();
        selectedCollection.value = data;
    } catch (e) {
        selectedCollection.value.fragrances = [];
    } finally {
        loadingFragrances.value = false;
    }
}

function closeModal() {
    selectedCollection.value = null;
}
</script>

<template>
    <section class="py-10 border-b border-amber-100 dark:border-gray-800 bg-amber-50 dark:bg-neutral-800">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-2 text-black dark:text-white">Colecciones</h2>
            <p class="text-center text-neutral-600 dark:text-gray-400 mb-6">Explora nuestras colecciones</p>

            <p v-if="loading" class="text-center text-neutral-500 dark:text-gray-400">Cargando...</p>
            <p v-else-if="error" class="text-center text-red-500">{{ error }}</p>

            <div v-else class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div
                    v-for="collection in collections"
                    :key="collection.id"
                    @click="openModal(collection)"
                    class="h-32 bg-neutral-800 dark:bg-gray-800 rounded-lg flex flex-col justify-end p-4 cursor-pointer hover:bg-neutral-700 dark:hover:bg-gray-700 transition-colors duration-200 relative overflow-hidden group"
                >
                    <!-- Fondo decorativo -->
                    <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-neutral-800 to-neutral-700 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 group-hover:from-neutral-800 group-hover:to-neutral-600 transition-all duration-200"></div>

                    <!-- Acento decorativo -->
                    <div class="absolute top-0 right-0 w-12 h-1 bg-amber-500 rounded-bl"></div>

                    <!-- Texto -->
                    <div class="relative z-10">
                        <p class="text-amber-500 text-xs uppercase tracking-widest mb-1">Colección</p>
                        <h3 class="text-white font-bold text-sm leading-tight">{{ collection.nombre }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div
            v-if="selectedCollection"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @click.self="closeModal"
        >
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>

            <!-- Contenido del modal -->
            <div class="relative bg-amber-50 dark:bg-neutral-800 rounded-2xl w-full max-w-3xl max-h-[85vh] overflow-y-auto shadow-2xl">

                <!-- Header -->
                <div class="sticky top-0 bg-amber-50 dark:bg-neutral-800 border-b border-amber-100 dark:border-gray-700 px-6 py-4 flex justify-between items-start rounded-t-2xl z-10">
                    <div>
                        <p class="text-amber-500 text-xs uppercase tracking-widest mb-1">Colección</p>
                        <h2 class="text-xl font-bold text-black dark:text-white">
                            {{ selectedCollection.nombre }}
                        </h2>
                        <p class="text-sm text-neutral-600 dark:text-gray-400 mt-1">
                            {{ selectedCollection.descripcion }}
                        </p>
                    </div>
                    <button
                        @click="closeModal"
                        class="ml-4 text-neutral-500 hover:text-neutral-800 dark:text-gray-400 dark:hover:text-white transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Fragancias de la colección -->
                <div class="p-6">
                    <p class="text-sm font-medium text-neutral-500 dark:text-gray-400 mb-4">
                        {{ selectedCollection.fragrances?.length || 0 }} fragancias en esta colección
                    </p>

                    <p v-if="loadingFragrances" class="text-center text-neutral-500 dark:text-gray-400 py-8">Cargando fragancias...</p>

                    <p v-else-if="!selectedCollection.fragrances?.length" class="text-center text-neutral-500 dark:text-gray-400 py-8">
                        Esta colección no tiene fragancias aún.
                    </p>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div
                            v-for="fragrance in selectedCollection.fragrances"
                            :key="fragrance.id"
                            class="border border-amber-100 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm bg-white dark:bg-gray-800 flex flex-col"
                        >
                            <!-- Imagen -->
                            <div class="w-full h-36 bg-neutral-800 dark:bg-neutral-800 overflow-hidden">
                                <img
                                    v-if="fragrance.image_url"
                                    :src="fragrance.image_url"
                                    :alt="fragrance.name"
                                    class="w-full h-full object-cover"
                                />
                                <div v-else class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Contenido -->
                            <div class="p-3 flex flex-col flex-grow">
                                <p class="text-xs text-neutral-500 dark:text-gray-400 uppercase tracking-wide mb-1">
                                    {{ fragrance.brand?.name }}
                                </p>
                                <h3 class="font-bold text-sm text-black dark:text-white mb-1">
                                    {{ fragrance.name }}
                                </h3>
                                <p class="text-xs text-neutral-600 dark:text-gray-400 flex-grow line-clamp-2">
                                    {{ fragrance.description }}
                                </p>
                                <div class="flex justify-between items-center mt-3 pt-2 border-t border-amber-100 dark:border-gray-700">
                                    <span class="font-bold text-black dark:text-white">
                                        ${{ Number(fragrance.price).toLocaleString('es-MX') }}
                                    </span>
                                    <span class="text-xs bg-amber-100 dark:bg-gray-700 text-neutral-800 dark:text-amber-50 px-2 py-1 rounded-full font-medium">
                                        {{ fragrance.concentration }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>