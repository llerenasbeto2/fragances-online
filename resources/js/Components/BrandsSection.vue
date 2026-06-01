<script setup>
import { ref, onMounted } from 'vue';

const brands  = ref([]);
const loading = ref(true);
const error   = ref('');

onMounted(async () => {
    try {
        const res = await fetch('/api/brands');
        if (!res.ok) throw new Error('Error al cargar marcas');
        brands.value = await res.json();
    } catch (e) {
        error.value = e.message;
    } finally {
        loading.value = false;
    }
});

function circleSize(index, total) {
    const mid = Math.floor(total / 2);
    return index === mid ? 'w-24 h-24' : 'w-16 h-16';
}
</script>

<template>
    <section class="py-10 border-b border-amber-100 dark:border-gray-800 bg-amber-50 dark:bg-neutral-800">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-2xl font-bold text-center mb-1 text-black dark:text-white">Marcas</h2>
            <p class="text-center text-neutral-600 dark:text-gray-400 mb-8 text-sm">
                Las mejores casas de perfumería
            </p>

            <p v-if="loading" class="text-center text-neutral-500 dark:text-gray-400">Cargando...</p>
            <p v-else-if="error" class="text-center text-red-500">{{ error }}</p>

            <div v-else class="grid grid-cols-3 gap-8 text-center">
                <div
                    v-for="(brand, index) in brands"
                    :key="brand.id"
                    class="flex flex-col items-center"
                >
                    
                    <div
                        :class="[
                            circleSize(index, brands.length),
                            'bg-neutral-800 dark:bg-amber-50 rounded-full mb-4 overflow-hidden flex items-center justify-center transition-all duration-200'
                        ]"
                    >
                        <img
                            v-if="brand.logo_url"
                            :src="brand.logo_url"
                            :alt="brand.name"
                            class="w-full h-full object-cover"
                        />
                        <span v-else class="text-white dark:text-neutral-800 font-bold text-xl">
                            {{ brand.name.charAt(0) }}
                        </span>
                    </div>

                   
                    <h3 class="font-bold text-sm text-black dark:text-white mb-1">
                        {{ brand.name }}
                    </h3>

                    
                    <p class="text-xs text-neutral-500 dark:text-gray-400">
                        {{ brand.country ?? 'Sin país' }}
                    </p>
                </div>
            </div>

        </div>
    </section>
</template>