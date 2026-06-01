<script setup>
import { Link, router } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/NavbarAdmin.vue';
import { ref, onMounted } from 'vue';

defineProps(['brands']);

const user = ref(null);

onMounted(() => {
    const token = localStorage.getItem('token');
    const userData = localStorage.getItem('user');

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

const deleteBrand = (id) => {
    if (confirm('¿Eliminar esta marca?')) {
        // Lógica de eliminación
    }
};
</script>

<template>
    <div class="min-h-screen bg-amber-50 dark:bg-neutral-800 transition-colors duration-300">
        <NavbarAdmin :user-name="user?.name || 'Admin'" @logout="logout" />

        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-300">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-black dark:text-white">Marcas</h2>
                    <Link href="/admin/brands/create" class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black px-4 py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300">
                        + Nueva
                    </Link>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-amber-100 dark:bg-gray-800 rounded-lg">
                        <thead>
                            <tr class="bg-amber-50 dark:bg-neutral-800 border-b border-amber-200 dark:border-gray-700">
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">ID</th>
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Logo</th>
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Nombre</th>
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">País</th>
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="brand in brands" :key="brand.id" class="border-t border-amber-200 dark:border-gray-700 hover:bg-amber-50 dark:hover:bg-neutral-700 transition-colors duration-300">
                                <td class="p-3 text-black dark:text-white">{{ brand.id }}</td>
                                <td class="p-3">
                                    <img
                                        v-if="brand.logo_url"
                                        :src="brand.logo_url"
                                        :alt="brand.name"
                                        class="w-10 h-10 object-cover rounded-full border border-amber-200 dark:border-gray-700"
                                    />
                                    <div
                                        v-else
                                        class="w-10 h-10 bg-neutral-800 dark:bg-amber-50 rounded-full flex items-center justify-center text-white dark:text-black text-sm font-bold"
                                    >
                                        {{ brand.name.charAt(0) }}
                                    </div>
                                </td>
                                <td class="p-3 font-medium text-black dark:text-white">{{ brand.name }}</td>
                                <td class="p-3 text-black dark:text-white">{{ brand.country ?? '—' }}</td>
                                <td class="p-3">
                                    <Link :href="`/admin/brands/${brand.id}/edit`" class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-500 underline mr-3">
                                        Editar
                                    </Link>
                                    <button @click="deleteBrand(brand.id)" class="text-red-500 hover:text-red-600 underline">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="brands.length === 0">
                                <td colspan="5" class="p-8 text-center text-black dark:text-white">No hay marcas registradas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>