<template>
    <Head title="Usuarios" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="col-span-2 m-2 mb-2 grid grid-cols-3 pr-3">
            <div class="cols-span-1">
                <Select
                    v-model="selectedEstado"
                    :options="estados"
                    optionLabel="name"
                    placeholder="Seleccione un estado"
                    class="font-8 w-full md:w-56"
                    @change="filtrarPorEstado"
                />
            </div>
            <div class="col-span-1">
                <IconField>
                    <InputIcon class="pi pi-search" />
                    <InputText v-model="search" @keypress.enter="filtrarPorEstado" placeholder="Buscar..." />
                </IconField>
            </div>
            <div class="cols-span-1 flex justify-end">
                <Link :href="route('usuarios.create')">
                    <Button severity="primary" variant="text" class="font-8 mb-0"> <i class="pi pi-plus"></i> Agregar usuario </Button>
                </Link>
            </div>
        </div>
        <div class="w-full max-w-full overflow-hidden px-2">
            <div class="w-full overflow-x-auto">
                <TableResponsive :columns="columns" :data="usuariosList">
                    <template #status="{ item }: { item: { id: number; status: boolean } }">
                        <ToggleSwitch v-model="item.status" readonly />
                    </template>
                    <template #acciones="{ item }: { item: { id: number } }">
                        <div class="flex gap-3">
                            <Link :href="route('usuarios.edit', { id: String(item.id) })">
                                <Button class="font-8" icon="pi pi-pencil" size="small" severity="primary" rounded outlined aria-label="Editar" />
                            </Link>
                        </div>
                    </template>
                    <template #roles="{ item }: { item: { name: String } }">
                        <div class="flex flex-wrap gap-2">
                            <Tag v-for="role in item.roles" :key="role" :value="role.name"> </Tag>
                        </div>
                    </template>
                    <template #empty>
                        <div class="flex flex-col items-center justify-center py-5 text-gray-500">
                            <i class="pi pi-inbox mb-3 text-4xl"></i>
                            <p>No hay registros disponibles</p>
                        </div>
                    </template>
                </TableResponsive>
            </div>
            <div v-show="users.links.length > 3" class="xs:flex-row xs:justify-between flex flex-col items-center border-t px-2 py-2">
                <pagination :links="users.links" :perPage="per_page" />
            </div>
        </div>
        <Toast />
    </AppLayout>
</template>

<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import TableResponsive from '@/components/shared/TableResponsive.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Tag from 'primevue/tag';
import Toast from 'primevue/toast';
import ToggleSwitch from 'primevue/toggleswitch';
import { useToast } from 'primevue/usetoast';
import { ref, watch } from 'vue';

const toast = useToast();

const selectedEstado = ref();
const estados = ref([
    { name: 'Activo', code: 1 },
    { name: 'Inactivo', code: 0 },
]);

const search = ref('');

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Usuarios', href: '/dashboard' }];

const props = defineProps({
    users: {
        type: Object,
        default: () => ({ data: [], links: [], meta: {} }),
    },
    per_page: {
        type: Number,
        default: 10,
    },
});

const columns = [
    { field: 'contador', label: '#' },
    { field: 'name', label: 'Nombre' },
    { field: 'email', label: 'Correo electronico' },
    { field: 'roles', label: 'Roles' },
    { field: 'status', label: 'Estado' },
    { field: 'acciones', label: 'Acciones' },
];

const usuariosList = ref(
    props.users.data.map((item_reg: any, index: number) => ({
        id: item_reg.id,
        contador: index + 1,
        name: item_reg.name,
        email: item_reg.email,
        roles: item_reg.roles,
        status: item_reg.status === 1,
    })),
);

watch(
    () => props.users.data,
    (newData) => {
        usuariosList.value = newData.map((item_reg: any, index: number) => ({
            id: item_reg.id,
            contador: index + 1,
            name: item_reg.name,
            email: item_reg.email,
            roles: item_reg.roles,
            status: item_reg.status === 1,
        }));
    },
);

const filtrarPorEstado = () => {
    router.get(
        route('usuarios.index'),
        {
            estado: selectedEstado.value?.code,
            per_page: props.per_page,
            search: search.value,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
};
</script>

<style>
.p-dialog-title {
    font-size: 1rem !important;
}
</style>
