<template>
    <div class="min-h-screen bg-gray-100">
        <!-- User Navbar -->
        <nav class="bg-green-600 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-8">
                        <h1 class="text-xl font-bold">Mi Cuenta</h1>
                        <div class="hidden md:flex space-x-4">
                            <a href="/user/dashboard" class="hover:bg-green-700 px-3 py-2 rounded">Dashboard</a>
                           
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span>{{ user?.name }}</span>
                        <button @click="logout" class="bg-red-500 px-4 py-2 rounded hover:bg-red-600 transition">
                            Cerrar Sesión
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- User Content -->
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">Mi Panel</h2>
                <p class="text-gray-600 mb-4">Bienvenido, {{ user?.name }}</p>
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    Usuario: {{ user?.email }}
                </div>
            </div>

            
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

const user = ref(null);

onMounted(() => {
    const userData = localStorage.getItem('user');
    const token = localStorage.getItem('token');
    
    if (!token) {
        router.visit('/login');
        return;
    }
    
    if (userData) {
        user.value = JSON.parse(userData);
        // Verificar que sea user
        if (user.value.role !== 'user') {
            router.visit('/admin/dashboard');
        }
    }
});

const logout = async () => {
    const token = localStorage.getItem('token');
    
    try {
        await fetch('/api/auth/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });
    } catch (err) {
        console.error('Error en logout:', err);
    }

    localStorage.removeItem('token');
    localStorage.removeItem('user');
    router.visit('/login');
};
</script>