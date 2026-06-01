<template>
    <nav class="bg-amber-50 dark:bg-neutral-800 shadow border-b border-amber-500 dark:border-amber-500">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <img 
                            src="/images/logo.png" 
                            alt="Royal Aromas Logo" 
                            class="h-10 w-auto object-contain dark:brightness-0" 
                        />
                    <div class="w-24 h-7"></div>
                </div>

                <!-- Login Button -->
                <div class="flex items-center">
                    <a
                        href="/login"
                        class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-neutral-800 text-sm px-5 py-2 rounded hover:bg-neutral-700 dark:hover:bg-amber-100 transition"
                    >
                        Iniciar Sesión
                    </a>
                    <DarkMode class="ml-4" />
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import DarkMode from '@/Components/DarkMode.vue'
</script>