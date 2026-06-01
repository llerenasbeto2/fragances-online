<script setup>
import { ref, onMounted } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/NavbarAdmin.vue';

defineProps({ collections: Array });

const user = ref(null);

onMounted(() => {
    const token    = localStorage.getItem('token');
    const userData = localStorage.getItem('user');
    if (!token) { router.visit('/login'); return; }
    if (userData) {
        user.value = JSON.parse(userData);
        if (user.value.role !== 'admin') router.visit('/user/dashboard');
    }
});

const logout = async () => {
    const token = localStorage.getItem('token');
    await fetch('/api/auth/logout', {
        method: 'POST',
        headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' }
    });
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    router.visit('/');
};

const form = useForm({});

const deleteCollection = (id) => {
    if (confirm('¿Eliminar esta colección?')) {
        form.delete(`/admin/collections/${id}`);
    }
};
</script>

<template>
    <div class="min-h-screen bg-amber-50 dark:bg-neutral-800 transition-colors duration-300">
        <!-- Navbar -->
        <NavbarAdmin :user-name="user?.name || 'Admin'" @logout="logout"></NavbarAdmin>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-300">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-black dark:text-white">Colecciones</h2>
                    <Link href="/admin/collections/create" class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black px-4 py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300">
                        + Nueva
                    </Link>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-amber-100 dark:bg-gray-800 rounded-lg">
                        <thead>
                            <tr class="bg-amber-50 dark:bg-neutral-800 border-b border-amber-200 dark:border-gray-700">
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">ID</th>
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Nombre</th>
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Descripción</th>
                                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="collection in collections" :key="collection.id" class="border-t border-amber-200 dark:border-gray-700 hover:bg-amber-50 dark:hover:bg-neutral-700 transition-colors duration-300">
                                <td class="p-3 text-black dark:text-white">{{ collection.id }}</td>
                                <td class="p-3 font-medium text-black dark:text-white">{{ collection.nombre }}</td>
                                <td class="p-3 text-black dark:text-white max-w-xs truncate">
                                    {{ collection.descripcion ?? '—' }}
                                </td>
                                <td class="p-3">
                                    <Link :href="`/admin/collections/${collection.id}/edit`" class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-500 underline mr-3">
                                        Editar
                                    </Link>
                                    <button @click="deleteCollection(collection.id)" class="text-red-500 hover:text-red-600 underline">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="collections.length === 0">
                                <td colspan="4" class="p-8 text-center text-black dark:text-white">No hay colecciones registradas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>