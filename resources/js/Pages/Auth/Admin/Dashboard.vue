<!-- resources/js/Pages/Auth/Admin/Dashboard.vue -->
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

    <div class="p-4">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';

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
</script>