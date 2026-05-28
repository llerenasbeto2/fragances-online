<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
            
            <form @submit.prevent="login">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input 
                        v-model="form.email" 
                        type="email" 
                        class="w-full px-3 py-2 border rounded-lg"
                        required
                    >
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input 
                        v-model="form.password" 
                        type="password" 
                        class="w-full px-3 py-2 border rounded-lg"
                        required
                    >
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 mb-4"
                >
                    Login
                </button>
                
                <a href="/" class="block text-center text-blue-500 hover:text-blue-700">
                    ← Volver al inicio
                </a>
                
                <p v-if="error" class="text-red-500 mt-4 text-center">{{ error }}</p>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

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