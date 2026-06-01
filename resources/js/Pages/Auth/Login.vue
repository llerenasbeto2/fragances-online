<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

const form = ref({
    email: '',
    password: ''
});

const error = ref('');

const login = async () => {
    try {
        const response = await fetch('/api/auth/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(form.value)
        });

        const data = await response.json();

        if (!response.ok) {
            error.value = data.error || 'Login failed';
            return;
        }

        localStorage.setItem('token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));

        // Redirigir según el rol
        if (data.user.role === 'admin') {
            router.visit('/admin/dashboard');
        } else {
            router.visit('/user/dashboard');
        }

    } catch (err) {
        error.value = 'Error de conexión';
    }
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-amber-50 dark:bg-neutral-800 transition-colors duration-300">
        <div class="bg-amber-50 dark:bg-neutral-800 p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center text-black dark:text-white">Login</h2>
            
            <form @submit.prevent="login">
                <div class="mb-4">
                    <label class="block text-black dark:text-white mb-2">Email</label>
                    <input 
                        v-model="form.email" 
                        type="email" 
                        class="w-full px-3 py-2 border rounded-lg bg-amber-100 dark:bg-gray-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        required
                    >
                </div>
                
                <div class="mb-6">
                    <label class="block text-black dark:text-white mb-2">Password</label>
                    <input 
                        v-model="form.password" 
                        type="password" 
                        class="w-full px-3 py-2 border rounded-lg bg-amber-100 dark:bg-gray-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        required
                    >
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-neutral-800 dark:bg-amber-50 text-white dark:text-black py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300 mb-4"
                >
                    Login
                </button>
                
                <a href="/" class="block text-center text-amber-500 hover:text-amber-600 dark:text-amber-500 dark:hover:text-amber-400 transition-colors duration-300">
                    ← Volver al inicio
                </a>
                
                <p v-if="error" class="text-red-500 mt-4 text-center">{{ error }}</p>
            </form>
        </div>
    </div>
</template>

<style>

* {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}
</style>