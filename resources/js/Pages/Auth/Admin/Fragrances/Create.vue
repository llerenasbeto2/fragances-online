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
  image_url: '',
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
    form.image_url = props.fragrance.image_url || '';
  }
});


</script>
<template>
  <div class="min-h-screen bg-amber-50 dark:bg-neutral-800 py-8 transition-colors duration-300">
    <div class="max-w-2xl mx-auto px-4">
      <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md p-8 transition-colors duration-300">
        <h2 class="text-2xl font-bold mb-6 text-black dark:text-white">{{ isUpdating ? 'Editar' : 'Nueva' }} Fragancia</h2>
        
        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">Nombre *</label>
            <input 
              v-model="form.name" 
              type="text" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            >
          </div>

          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">Marca *</label>
            <select 
              v-model="form.brand_id" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            >
              <option value="">Seleccionar</option>
              <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                {{ brand.name }}
              </option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">Colección</label>
            <select 
              v-model="form.collection_id" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
            >
              <option value="">Sin colección</option>
              <option v-for="collection in collections" :key="collection.id" :value="collection.id">
                {{ collection.nombre }}
              </option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">Precio *</label>
            <input 
              v-model="form.price" 
              type="number" 
              step="0.01" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            >
          </div>

          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">Stock *</label>
            <input 
              v-model="form.stock" 
              type="number" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            >
          </div>

          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">Concentración *</label>
            <select 
              v-model="form.concentration" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            >
              <option value="">Seleccionar</option>
              <option value="EDT">EDT</option>
              <option value="EDP">EDP</option>
              <option value="Parfum">Parfum</option>
              <option value="Elixir">Elixir</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">URL de la Imagen</label>
            <input 
              v-model="form.image_url" 
              type="url" 
              placeholder="https://ejemplo.com/imagen.jpg" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
            >
            <div v-if="form.image_url" class="mt-2">
              <p class="text-xs text-black dark:text-white mb-1">Vista previa:</p>
              <img :src="form.image_url" class="h-20 w-20 object-cover rounded border border-amber-200 dark:border-gray-700" alt="Vista previa">
            </div>
          </div>

          <div class="mb-4">
            <label class="block text-black dark:text-white mb-2">Descripción</label>
            <textarea 
              v-model="form.description" 
              class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
              rows="3"
            ></textarea>
          </div>

          <div class="flex justify-end gap-3">
            <Link 
              href="/admin/fragrances" 
              class="bg-gray-300 dark:bg-gray-600 text-black dark:text-white px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-300"
            >
              Cancelar
            </Link>
            <button 
              type="submit" 
              class="bg-neutral-800 dark:bg-amber-50 text-white dark:text-black px-4 py-2 rounded-lg hover:bg-amber-500 dark:hover:bg-amber-500 hover:text-white transition-colors duration-300"
            >
              {{ isUpdating ? 'Actualizar' : 'Crear' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>