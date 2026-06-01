<script setup>
import { Link } from '@inertiajs/vue3';
import DarkMode from '@/Components/DarkMode.vue';
defineProps({
    userName: {
        type: String,
        required: true
    }
});

const emit = defineEmits(['logout']);

const handleLogout = () => {
    emit('logout');
};
</script>

<template>
    <nav class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black shadow-lg transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo y enlaces principales -->
                <div class="flex items-center space-x-6">
                    <h1 class="font-bold text-xl">Admin Panel</h1>
                    <div class="hidden md:flex space-x-1">
                        <Link 
                            href="/admin/dashboard" 
                            class="hover:bg-amber-500 dark:hover:bg-amber-500 px-3 py-2 rounded transition-colors duration-300"
                            :class="{
                                'bg-amber-500 dark:bg-amber-500 text-white': $page.url === '/admin/dashboard'
                            }"
                        >
                            Dashboard
                        </Link>
                        <Link 
                            href="/admin/brands" 
                            class="hover:bg-amber-500 dark:hover:bg-amber-500 px-3 py-2 rounded transition-colors duration-300"
                            :class="{
                                'bg-amber-500 dark:bg-amber-500 text-white': $page.url === '/admin/brands' || $page.url.startsWith('/admin/brands/')
                            }"
                        >
                            Marcas
                        </Link>
                        <Link 
                            href="/admin/collections" 
                            class="hover:bg-amber-500 dark:hover:bg-amber-500 px-3 py-2 rounded transition-colors duration-300"
                            :class="{
                                'bg-amber-500 dark:bg-amber-500 text-white': $page.url === '/admin/collections' || $page.url.startsWith('/admin/collections/')
                            }"
                        >
                            Colecciones
                        </Link>
                        <Link 
                            href="/admin/fragrances" 
                            class="hover:bg-amber-500 dark:hover:bg-amber-500 px-3 py-2 rounded transition-colors duration-300"
                            :class="{
                                'bg-amber-500 dark:bg-amber-500 text-white': $page.url === '/admin/fragrances' || $page.url.startsWith('/admin/fragrances/')
                            }"
                        >
                            Fragancias
                        </Link>
                    </div>
                </div>
                <div>
                    <DarkMode />
                </div>
                <!-- Información usuario y logout -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm md:text-base">{{ userName }}</span>
                    <button 
                        @click="handleLogout" 
                        class="bg-amber-500 hover:bg-amber-600 dark:bg-amber-500 dark:hover:bg-amber-600 px-4 py-2 rounded transition-all duration-300 text-white dark:text-black font-medium"
                    >
                        Salir
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>