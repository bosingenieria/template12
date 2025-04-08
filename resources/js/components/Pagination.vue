<template>
  <div v-if="links.length > 3" class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0 w-full">
    <!-- Selector de Registros por Página (Ocupa todo el ancho en móviles) -->
    <div class="flex items-center justify-center space-x-2 w-full sm:w-auto">
      <div class="flex items-center space-x-2">
        <label for="perPage" class="text-sm text-gray-600 dark:text-gray-400">Mostrar:</label>
        <select
          id="perPage"
          v-model="selectedPerPage"
          @change="updatePerPage"
          class="px-2 py-1 border rounded text-sm sm:w-auto dark:bg-zinc-800 dark:text-white"
        >
          <option v-for="n in perPageOptions" :key="n" :value="n">{{ n }}</option>
        </select>
        <span class="text-sm text-gray-600 dark:text-gray-400">registros</span>
      </div>
      
    </div>

    <!-- Paginación (Ocupa todo el ancho en móviles) -->
    <div class="w-full sm:w-auto overflow-x-auto sm:overflow-visible">
      <div class="flex flex-wrap justify-center sm:justify-start -mb-1">
        <template v-for="(link, key) in links">
          <div 
            v-if="link.url === null" 
            :key="key"
            class="px-2 py-1 mr-1 mb-1 text-sm leading-4 dark:text-zinc-600 text-gray-400 rounded border font-8" 
            v-html="link.label"
          />
          
          <Link 
            v-else 
            :key="key + 1"
            :href="link.url"
            v-html="link.label"
            class="
              px-2 py-1 mr-1 mb-1 leading-4 rounded border font-8 
              transition-colors duration-200
              bg-transparent dark:text-gray-400 text-zinc-600 hover:bg-gray-200 hover:text-zinc-900
              focus:border-white focus:text-zinc-900 focus:bg-gray-300
              dark:hover:bg-transparent dark:hover:text-white
              dark:focus:border-zinc-500 dark:focus:text-white dark:focus:bg-transparent
            "
            :class="{ 
              'bg-gray-300 text-zinc-900 font-bold dark:text-white dark:bg-transparent': link.active 
            }"
          />
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  links: Array,
  perPage: Number, // 🔹 Recibimos el valor actual desde Laravel
});
console.log(props.links);
// 🔹 Opciones de registros por página (10, 20, ..., 100)
const perPageOptions = ref([10, 20, 30, 40, 50, 60, 70, 80, 90, 100]);

// 🔹 Mantener el valor seleccionado en `v-model`
const selectedPerPage = ref(props.perPage || 10);

// 🔹 Actualizar la URL cuando el usuario seleccione una cantidad
const updatePerPage = () => {
  router.get(window.location.pathname, { per_page: selectedPerPage.value }, { preserveState: true });
};
</script>