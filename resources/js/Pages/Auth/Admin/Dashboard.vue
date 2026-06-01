<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/NavbarAdmin.vue';

const user = ref(null);
const activeSection = ref('usuarios');


const adminMenuItems = [
    { id: 'usuarios', label: 'Gestionar Usuarios', icon: '👥' },
    { id: 'pedidos', label: 'Pedidos', icon: '📦' },
    { id: 'reportes', label: 'Reportes y Analytics', icon: '📈' },
    { id: 'configuracion', label: 'Configuración', icon: '⚙️' }
];

// Función simple para el título
const getSectionTitle = () => {
    const item = adminMenuItems.find(i => i.id === activeSection.value);
    return item ? item.label : 'Panel de Control';
};

onMounted(() => {
    const userData = localStorage.getItem('user');
    const token = localStorage.getItem('token');
    
    if (!token) {
        router.visit('/login');
        return;
    }
    
    if (userData) {
        user.value = JSON.parse(userData);
        if (user.value.role !== 'admin') {
            router.visit('/user/dashboard');
        }
    }
});

const logout = async () => {
    const token = localStorage.getItem('token');
    
    await fetch('/api/auth/logout', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        }
    });

    localStorage.removeItem('token');
    localStorage.removeItem('user');
    router.visit('/');
};
</script>

<template>
    <div class="min-h-screen bg-amber-50 dark:bg-neutral-800 transition-colors duration-300">
        <NavbarAdmin :user-name="user?.name || 'Admin'" @logout="logout" />

        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Sidebar Admin -->
                <div class="md:col-span-1">
                    <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
                        <div class="bg-amber-50 dark:bg-neutral-800 px-6 py-4 border-b border-amber-200 dark:border-gray-700">
                            <h2 class="font-semibold text-black dark:text-white">MENÚ ADMINISTRADOR</h2>
                        </div>
                        
                        <nav class="divide-y divide-amber-200 dark:divide-gray-700">
                            <button 
                                v-for="item in adminMenuItems" 
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
                       
                        <div class="mb-6 pb-4 border-b border-amber-200 dark:border-gray-700">
                            <h2 class="text-2xl font-bold text-black dark:text-white">
                                {{ getSectionTitle() }}
                            </h2>
                            <p class="text-black dark:text-white mt-1">
                                Bienvenido, <strong>{{ user?.name || 'Administrador' }}</strong> | 
                                Rol: <span class="text-amber-500 dark:text-amber-400">Administrador</span>
                            </p>
                        </div>

                       
                        <div v-if="activeSection === 'usuarios'">
                            
                        </div>
                        <div v-else-if="activeSection === 'pedidos'">
                           
                        </div>
                        <div v-else-if="activeSection === 'reportes'">
                           
                        </div>
                        <div v-else-if="activeSection === 'configuracion'">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>