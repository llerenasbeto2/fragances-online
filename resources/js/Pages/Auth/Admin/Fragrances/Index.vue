<script setup>
import { ref, onMounted } from 'vue';  // ← agregar ref y onMounted
import { Link, useForm, router } from '@inertiajs/vue3';  // ← agregar router
import NavbarAdmin from '@/Components/NavbarAdmin.vue';  // ← agregar NavbarAdmin

defineProps({
  fragrances: Array
});

// ← agregar esto
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

const form = useForm({});

const deleteFragrance = (id) => {
  if (confirm('¿Eliminar esta fragancia?')) {
    form.delete(`/admin/fragrances/${id}`);
  }
};
</script>

<template>
  <div class="min-h-screen bg-amber-50 dark:bg-neutral-800 transition-colors duration-300">
    <NavbarAdmin :user-name="user?.name || 'Admin'" @logout="logout" />

    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-300">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-black dark:text-white">Fragancias</h2>
          <Link href="/admin/fragrances/create" class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black px-4 py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300">
            + Nueva
          </Link>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full bg-amber-100 dark:bg-gray-800 rounded-lg">
            <thead>
              <tr class="bg-amber-50 dark:bg-neutral-800 border-b border-amber-200 dark:border-gray-700">
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">ID</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Nombre</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Marca</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Colección</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Precio</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Stock</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Concentración</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Imagen</th>
                <th class="p-3 text-left text-xs font-medium text-black dark:text-white uppercase">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="fragrance in fragrances" :key="fragrance.id" class="border-t border-amber-200 dark:border-gray-700 hover:bg-amber-50 dark:hover:bg-neutral-700 transition-colors duration-300">
                <td class="p-3 text-black dark:text-white">{{ fragrance.id }}</td>
                <td class="p-3 text-black dark:text-white">{{ fragrance.name }}</td>
                <td class="p-3 text-black dark:text-white">{{ fragrance.brand?.name }}</td>
                <td class="p-3 text-black dark:text-white">{{ fragrance.collection?.nombre || 'Sin colección' }}</td>
                <td class="p-3 text-black dark:text-white">${{ fragrance.price }}</td>
                <td class="p-3 text-black dark:text-white">{{ fragrance.stock }}</td>
                <td class="p-3 text-black dark:text-white">{{ fragrance.concentration }}</td>
                <td class="p-3">
                  <img 
                    v-if="fragrance.image_url" 
                    :src="fragrance.image_url" 
                    alt="Fragancia" 
                    class="w-12 h-12 object-cover rounded border border-amber-200 dark:border-gray-700"
                  />
                  <span v-else class="text-black dark:text-white text-xs">Sin imagen</span>
                </td>
                <td class="p-3">
                  <Link :href="`/admin/fragrances/${fragrance.id}/edit`" class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-500 underline mr-3">
                    Editar
                  </Link>
                  <button @click="deleteFragrance(fragrance.id)" class="text-red-500 hover:text-red-600 underline">
                    Eliminar
                  </button>
                </td>
              </tr>
              <tr v-if="fragrances.length === 0">
                <td colspan="9" class="p-8 text-center text-black dark:text-white">No hay fragancias registradas</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>