<template>
    <div class="flex flex-col overflow-x-auto">
        <div class="inline-block">
            <div class="inline-block min-w-full">
                    <!-- Tabla Desktop -->
                    <table v-if="!esMovil" class="w-full overflow-hidden mt-2">
                        <thead>
                            <tr class="border-b">
                                <th v-for="(column, colIndex) in columns" :key="colIndex" class="p-1 text-left text-gray-700 dark:text-white font-8">
                                    {{ column.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="data && data.length > 0">
                            <tr v-for="(item, rowIndex) in data" :key="rowIndex" class="border-b">
                                <td v-for="(column, colIndex) in columns" :key="colIndex" class="p-1 text-gray-700 dark:text-white font-8">
                                    <slot :name="column.field" :item="item">
                                        {{ item[column.field] }}
                                    </slot>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td :colspan="columns.length">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:bg-zinc-900 dark:text-white py-5 w-full font-8">
                                        <i class="pi pi-inbox text-4xl mb-3"></i>
                                        <p>No hay registros disponibles</p>
                                    </div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                
                    <!-- Tabla Móvil -->
                    <div v-if="esMovil" class="w-full overflow-hidden mt-2">
                        <div v-if="data && data.length > 0" v-for="(item, rowIndex) in data" :key="rowIndex" class="w-full flex flex-col mb-3">
                            <template v-for="(column, colIndex) in columns" :key="colIndex">
                                <div class="flex w-full">
                                    <span class="p-3 text-left text-gray-700 dark:text-white border-b min-w-[100px] max-w-[200px] flex-1 font-8">
                                        <strong>{{ column.label }}</strong>
                                    </span>
                                    <span class="border-b p-3 text-gray-700 dark:text-white flex-[2] font-8">
                                        <slot :name="column.field" :item="item">
                                            {{ item[column.field] }}
                                        </slot>
                                    </span>
                                </div>
                            </template>
                        </div>
                        <div v-else>
                            <div>
                                <div class="flex flex-col items-center justify-center text-gray-500 dark:bg-zinc-900 dark:text-white py-5 w-full">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:text-white py-5 w-full font-8">
                                        <i class="pi pi-inbox text-4xl mb-3"></i>
                                        <p>No hay registros disponibles</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>


<script setup lang="ts">
import { nextTick, onMounted, onUnmounted, ref } from 'vue';

const props = withDefaults(
  defineProps<{
    data?: any[]; 
    columns?: { field: string; label: string }[];
  }>(), 
  {
    data: () => [],
    columns: () => []
  }
);


const esMovil = ref(false);

const detectarPantalla = () => {
  nextTick(() => {
    esMovil.value = window.innerWidth < 800;
  });
};

onMounted(() => {
  detectarPantalla();
  window.addEventListener("resize", detectarPantalla);
});

onUnmounted(() => {
  window.removeEventListener("resize", detectarPantalla);
});
</script>

<style>
@media (min-width: 640px) {
    table {
        display: inline-table !important;
    }

    thead tr:not(:first-child) {
        display: none;
    }
}

th {
    border-bottom: 1px solid rgba(0, 0, 0, .1);
    box-sizing: border-box;
}
</style>