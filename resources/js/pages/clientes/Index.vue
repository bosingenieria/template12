
<template>
    <Head title="clientes" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid lg:grid-cols-3 grid-cols-1 gap-4 col-span-2 mb-2 pr-3 m-2">
            <div class="cols-span-1">
                <Select 
                    v-model="selectedEstado"
                    :options="estados"
                    optionLabel="name"
                    placeholder="Seleccione un estado"
                    class="w-full md:w-56 font-8"
                    @change="filtrarPorEstado"
                />
            </div>
            <div class="col-span-1">
                <IconField class="w-full md:w-56">
                    <InputIcon class="pi pi-search" />
                    <InputText class="w-full" v-model="search" @keypress.enter="filtrarPorEstado" placeholder="Buscar..." />
                </IconField>
            </div>
            <div class="cols-span-1 flex justify-end">
                <Link :href="route('clientes.create')">
                    <Button severity="primary" variant="text" class="mb-0 font-8">
                        <i class="pi pi-plus"></i> Agregar Cliente
                    </Button>
                </Link>
                
            </div>

            
        </div>
        <div class="max-w-full w-full overflow-hidden px-2">
            <div class="w-full overflow-x-auto">
                <TableResponsive :columns="columns" :data="clientesList">
                    <template #estado="{ item }: { item: { id: number, estado: boolean } }">
                        <ToggleSwitch v-model="item.estado" readonly/>
                    </template>
                    <template #acciones="{ item }: { item: { id: number } }">
                        <div class="flex gap-3">
                            <Link :href="route('clientes.edit', { id: String(item.id) })">
                                <Button class="font-8" icon="pi pi-pencil" size="small" severity="primary" rounded outlined aria-label="Editar" />
                            </Link>
                            
                        </div>
                    </template>
                    <template #empty>
                        <div class="flex flex-col items-center justify-center text-gray-500 py-5">
                            <i class="pi pi-inbox text-4xl mb-3"></i>
                            <p>No hay registros disponibles</p>
                        </div>
                    </template>
                </TableResponsive>
            </div>
            <div v-show="clientes.links.length > 3"
                class="flex flex-col items-center border-t px-2 py-2 xs:flex-row xs:justify-between">
                <pagination :links="clientes.links" :perPage="per_page" />
            </div>
        </div>
        <Toast />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm, Link } from '@inertiajs/vue3';
import Button from 'primevue/button';
import { ref, watch } from 'vue';
import TableResponsive from "@/components/shared/TableResponsive.vue";
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";
import axios from "axios";
import ToggleSwitch from 'primevue/toggleswitch';
import Select from 'primevue/select';
import Pagination from '@/components/Pagination.vue'
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';

const toast = useToast();

const selectedEstado = ref();
const estados = ref([
    { name: 'Activo', code: 1 },
    { name: 'Inactivo', code: 0 }
]);

const search = ref('');

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Clientes', href: '/dashboard' },
];

const props = defineProps({
    clientes: {
        type: Object,
        default: () => ({ data: [], links: [], meta: {} })
    },
    per_page: {
        type: Number,
        default: 10
    }
});
console.log(props.clientes);

const columns = [
  { field: 'contador', label: '#' },
  { field: 'nombre', label: 'Nombre' },
  { field: 'apellido', label: 'Apellido' },
  { field: 'documento', label: 'Identificación' },
  { field: 'telefono', label: 'Telefono' },
  { field: 'direccion', label: 'Dirección' },
  { field: 'estado', label: 'Estado' },
  { field: 'acciones', label: 'Acciones' }
];

const clientesList = ref(
    props.clientes.data.map((item_reg: any, index: number) => ({
        id: item_reg.id,
        contador: index + 1,
        nombre: item_reg.nombre,
        apellido: item_reg.apellido,
        documento: item_reg.documento_identidad,
        telefono: item_reg.telefono_principal,
        direccion: item_reg.direccion_principal,
        estado: item_reg.estado === 1
    }))
);

watch(() => props.clientes.data, (newData) => {
    clientesList.value = newData.map((item_reg: any, index: number) => ({
        id: item_reg.id,
        contador: index + 1,
        nombre: item_reg.nombre,
        apellido: item_reg.apellido,
        documento: item_reg.documento_identidad,
        telefono: item_reg.telefono_principal,
        direccion: item_reg.direccion_principal,
        estado: item_reg.estado === 1
    }));
});

const filtrarPorEstado = () => {
    router.get(route("clientes.index"), {
        estado: selectedEstado.value?.code,
        per_page: props.per_page,
        search: search.value
    }, {
        preserveState: true,
        replace: true
    });
};
</script>

<style>
.p-dialog-title{
    font-size: 1rem !important;
}
</style>
