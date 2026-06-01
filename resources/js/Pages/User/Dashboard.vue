<script setup>
import { ref, onMounted, computed } from 'vue'; 
import { router } from '@inertiajs/vue3';
import DarkMode from '@/Components/DarkMode.vue';

const user = ref(null);
const activeSection = ref('pedidos');


const formData = ref({
    name: '',
    email: ''
});


const productosFavoritos = ref([]);


const menuItems = [
    { id: 'pedidos', label: 'Mis Pedidos', icon: '📦' },
    { id: 'direcciones', label: 'Direcciones', icon: '📍' },
    { id: 'metodos-pago', label: 'Métodos de Pago', icon: '💳' },
    { id: 'detalles-cuenta', label: 'Detalles de Cuenta', icon: '👤' },
    { id: 'me-gustas', label: 'Lista de deseos', icon: '❤️' }
];


const getSectionTitle = () => {
    const item = menuItems.find(m => m.id === activeSection.value);
    return item ? item.label : 'Mi Cuenta';
};

onMounted(() => {
    const userData = localStorage.getItem('user');
    const token = localStorage.getItem('token');
    
    if (!token) {
        router.visit('/login');
        return;
    }
    
    if (userData) {
        const parsedUser = JSON.parse(userData);
        user.value = parsedUser;
        
        
        formData.value.name = parsedUser.name || '';
        formData.value.email = parsedUser.email || '';
        
     
        if (parsedUser.role !== 'user') {
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
    router.visit('/');
};
</script>
<template>
    <div class="min-h-screen bg-amber-50 dark:bg-neutral-800 transition-colors duration-300">
        <!-- User Navbar -->
        <nav class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black shadow-lg transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-8">
                        <h1 class="text-xl font-bold">Mi Cuenta</h1>
                        <div class="hidden md:flex space-x-4">
                            <a href="/user/dashboard" class="hover:bg-amber-500 dark:hover:bg-amber-500 px-3 py-2 rounded transition-colors duration-300">Dashboard</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <DarkMode />
                        <span class="text-white dark:text-black">{{ user?.name }}</span>
                        <button @click="logout" class="bg-amber-500 hover:bg-amber-600 dark:bg-amber-500 dark:hover:bg-amber-600 px-4 py-2 rounded transition-colors duration-300">
                            Salir
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Sidebar - Menú lateral -->
                <div class="md:col-span-1">
                    <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
                        <div class="bg-amber-50 dark:bg-neutral-800 px-6 py-4 border-b border-amber-200 dark:border-gray-700">
                            <h2 class="font-semibold text-black dark:text-white">MI CUENTA</h2>
                        </div>
                        
                        <nav class="divide-y divide-amber-200 dark:divide-gray-700">
                            <button 
                                v-for="item in menuItems" 
                                :key="item.id"
                                @click="activeSection = item.id"
                                :class="[
                                    'w-full text-left px-6 py-3 transition-all duration-300 flex items-center gap-3',
                                    activeSection === item.id 
                                        ? 'bg-amber-50 dark:bg-neutral-700 text-amber-600 dark:text-amber-400 border-l-4 border-amber-500' 
                                        : 'hover:bg-amber-50 dark:hover:bg-neutral-700 text-black dark:text-white'
                                ]"
                            >
                                <span class="text-xl">{{ item.icon }}</span>
                                <span>{{ item.label }}</span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Contenido principal -->
                <div class="md:col-span-3">
                    <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-300">
                        <!-- Cabecera -->
                        <div class="mb-6 pb-4 border-b border-amber-200 dark:border-gray-700">
                            <h2 class="text-2xl font-bold text-black dark:text-white">
                                {{ getSectionTitle() }}
                            </h2>
                            <p class="text-black dark:text-white mt-1">
                                Hola <strong>{{ user?.name || 'Usuario' }}</strong> 
                                (¿no eres tú? <button @click="logout" class="text-amber-500 hover:text-amber-600 dark:text-amber-500 dark:hover:text-amber-400 hover:underline">Cerrar sesión</button>)
                            </p>
                        </div>

                        <!-- Sección Pedidos -->
                        <div v-if="activeSection === 'pedidos'">
                            <div>
                                <div class="mb-4">
                                    <p class="text-black dark:text-white">Pedidos recientes</p>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-amber-200 dark:divide-gray-700">
                                        <thead class="bg-amber-50 dark:bg-neutral-800">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-black dark:text-white uppercase">Pedido</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-black dark:text-white uppercase">Fecha</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-black dark:text-white uppercase">Total</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-black dark:text-white uppercase">Estado</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-black dark:text-white uppercase">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-amber-100 dark:bg-gray-800 divide-y divide-amber-200 dark:divide-gray-700">
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-black dark:text-white">No hay pedidos aún</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Direcciones -->
                        <div v-else-if="activeSection === 'direcciones'">
                            <div>
                                <div class="flex justify-between items-center mb-6">
                                    <p class="text-black dark:text-white">Direcciones de envío.</p>
                                    <button class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black px-4 py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300">
                                        + Agregar nueva dirección
                                    </button>
                                </div>
                                <div class="text-center py-8">
                                    <p class="text-black dark:text-white">No hay direcciones guardadas</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Métodos de Pago -->
                        <div v-else-if="activeSection === 'metodos-pago'">
                            <div>
                                <div class="flex justify-between items-center mb-6">
                                    <p class="text-black dark:text-white">Métodos de pago guardados.</p>
                                    <button class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black px-4 py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300">
                                        + Agregar método de pago
                                    </button>
                                </div>
                                <div class="text-center py-8">
                                    <p class="text-black dark:text-white">No hay métodos de pago guardados</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Detalles de Cuenta -->
                        <div v-else-if="activeSection === 'detalles-cuenta'">
                            <div>
                                <p class="text-black dark:text-white mb-6">Gestiona tu información personal.</p>
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-black dark:text-white mb-2">Nombre</label>
                                        <input 
                                            v-model="formData.name"
                                            type="text" 
                                            class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                        >
                                    </div>
                                    <div>
                                        <label class="block text-black dark:text-white mb-2">Email</label>
                                        <input 
                                            v-model="formData.email"
                                            type="email" 
                                            class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                        >
                                    </div>
                                    <button class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black px-4 py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300">
                                        Actualizar información
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Sección Lista de deseos -->
                        <div v-else-if="activeSection === 'me-gustas'">
                            <div>
                                <p class="text-black dark:text-white mb-6">Tus fragancias favoritas.</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Aquí irían los productos favoritos -->
                                </div>
                                <div v-if="productosFavoritos.length === 0" class="text-center py-8">
                                    <p class="text-black dark:text-white">No tienes productos favoritos aún.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>