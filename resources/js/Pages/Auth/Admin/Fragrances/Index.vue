<template>
  <div>

        <div class="bg-blue-600 text-white p-4 flex justify-between">
      <div class="flex gap-4">
        <h1 class="font-bold">Admin</h1>
        <Link href="/admin/dashboard" class="text-white underline">Dashboard</Link>
        <Link href="/admin/fragrances" class="text-white underline">Fragancias</Link>
      </div>
      <div class="flex gap-4">
        <span>{{ user?.name }}</span>
        <button @click="logout" class="bg-red-500 px-2 py-1 rounded">Salir</button>
      </div>
    </div>
    <div class="flex justify-between mb-4">
      <h2 class="text-xl font-bold">Fragancias</h2>
      <Link href="/admin/fragrances/create" class="bg-blue-500 text-white px-3 py-1 rounded">
        + Nueva
      </Link>
    </div>

    <table class="w-full bg-white shadow">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2 text-left">ID</th>
          <th class="p-2 text-left">Nombre</th>
          <th class="p-2 text-left">Marca</th>
          <th class="p-2 text-left">Colección</th>
          <th class="p-2 text-left">Precio</th>
          <th class="p-2 text-left">Stock</th>
          <th class="p-2 text-left">Concentración</th>
          <th class="p-2 text-left">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="fragrance in fragrances" :key="fragrance.id" class="border-t">
          <td class="p-2">{{ fragrance.id }}</td>
          <td class="p-2">{{ fragrance.name }}</td>
          <td class="p-2">{{ fragrance.brand?.name }}</td>
          <td class="p-2">{{ fragrance.collection?.nombre || 'Sin colección' }}</td>
          <td class="p-2">${{ fragrance.price }}</td>
          <td class="p-2">{{ fragrance.stock }}</td>
          <td class="p-2">{{ fragrance.concentration }}</td>
          <td class="p-2">
            <Link :href="`/admin/fragrances/${fragrance.id}/edit`" class="mr-2 text-blue-600 underline">
              Editar
            </Link>
            <button @click="deleteFragrance(fragrance.id)" class="text-red-600 underline">
              Eliminar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';  // ← agregar ref y onMounted
import { Link, useForm, router } from '@inertiajs/vue3';  // ← agregar router

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
  router.visit('/login');
};

const form = useForm({});

const deleteFragrance = (id) => {
  if (confirm('¿Eliminar esta fragancia?')) {
    form.delete(`/admin/fragrances/${id}`);
  }
};
</script>