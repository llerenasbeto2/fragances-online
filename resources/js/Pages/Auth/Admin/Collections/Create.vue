<script setup>
import { onMounted } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    collection: Object,
    isUpdating: Boolean
});

const form = useForm({
    nombre:      '',
    descripcion: '',
});

onMounted(() => {
    if (props.isUpdating && props.collection) {
        form.nombre      = props.collection.nombre;
        form.descripcion = props.collection.descripcion ?? '';
    }
});

const submit = () => {
    if (props.isUpdating) {
        form.put(`/admin/collections/${props.collection.id}`);
    } else {
        form.post('/admin/collections');
    }
};
</script>

<template>
    <div class="min-h-screen bg-amber-50 dark:bg-neutral-800 py-8 transition-colors duration-300">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-amber-100 dark:bg-gray-800 rounded-lg shadow-md p-8 transition-colors duration-300">
                <h2 class="text-2xl font-bold mb-6 text-black dark:text-white">{{ isUpdating ? 'Editar' : 'Nueva' }} Colección</h2>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-black dark:text-white mb-2 font-medium">Nombre *</label>
                        <input 
                            v-model="form.nombre" 
                            type="text" 
                            class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
                            required
                        >
                        <p v-if="form.errors.nombre" class="text-red-500 text-xs mt-1">{{ form.errors.nombre }}</p>
                    </div>

                    <div>
                        <label class="block text-black dark:text-white mb-2 font-medium">Descripción</label>
                        <textarea 
                            v-model="form.descripcion" 
                            class="w-full px-3 py-2 border rounded-lg bg-amber-50 dark:bg-neutral-800 text-black dark:text-white border-amber-500/20 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
                            rows="4"
                            placeholder="Describe el estilo o temporada de esta colección..."
                        ></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <Link 
                            href="/admin/collections" 
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