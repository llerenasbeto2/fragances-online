<template>
  
  <div class="max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">{{ isUpdating ? 'Editar' : 'Nueva' }} Fragancia</h2>
    
    <form @submit.prevent="submit" class="bg-white shadow p-4">
      <div class="mb-3">
        <label class="block mb-1">Nombre *</label>
        <input v-model="form.name" type="text" class="w-full border p-2" required>
      </div>

      <div class="mb-3">
        <label class="block mb-1">Marca *</label>
        <select v-model="form.brand_id" class="w-full border p-2" required>
          <option value="">Seleccionar</option>
          <option v-for="brand in brands" :key="brand.id" :value="brand.id">
            {{ brand.name }}
          </option>
        </select>
      </div>

      <div class="mb-3">
        <label class="block mb-1">Colección</label>
        <select v-model="form.collection_id" class="w-full border p-2">
          <option value="">Sin colección</option>
          <option v-for="collection in collections" :key="collection.id" :value="collection.id">
            {{ collection.nombre }}
          </option>
        </select>
      </div>

      <div class="mb-3">
        <label class="block mb-1">Precio *</label>
        <input v-model="form.price" type="number" step="0.01" class="w-full border p-2" required>
      </div>

      <div class="mb-3">
        <label class="block mb-1">Stock *</label>
        <input v-model="form.stock" type="number" class="w-full border p-2" required>
      </div>

      <div class="mb-3">
        <label class="block mb-1">Concentración *</label>
        <select v-model="form.concentration" class="w-full border p-2" required>
          <option value="">Seleccionar</option>
          <option value="EDT">EDT</option>
          <option value="EDP">EDP</option>
          <option value="Parfum">Parfum</option>
          <option value="Elixir">Elixir</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="block mb-1">Descripción</label>
        <textarea v-model="form.description" class="w-full border p-2" rows="3"></textarea>
      </div>

      <div class="flex justify-end gap-2">
        <Link href="/admin/fragrances" class="bg-gray-300 px-3 py-2 rounded">
          Cancelar
        </Link>
        <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded">
          {{ isUpdating ? 'Actualizar' : 'Crear' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  fragrance: Object,
  brands: Array,
  collections: Array,
  isUpdating: Boolean
});

const form = useForm({
  name: '',
  brand_id: '',
  collection_id: '',
  description: '',
  price: '',
  stock: '',
  concentration: '',
});

const submit = () => {
  if (props.isUpdating) {
    form.put(`/admin/fragrances/${props.fragrance.id}`);
  } else {
    form.post('/admin/fragrances');
  }
};

onMounted(() => {
  if (props.isUpdating && props.fragrance) {
    form.name = props.fragrance.name;
    form.brand_id = props.fragrance.brand_id;
    form.collection_id = props.fragrance.collection_id || '';
    form.description = props.fragrance.description || '';
    form.price = props.fragrance.price;
    form.stock = props.fragrance.stock;
    form.concentration = props.fragrance.concentration;
  }
});
</script>