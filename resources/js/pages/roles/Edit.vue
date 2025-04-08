<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Fieldset from 'primevue/fieldset';
import InputText from 'primevue/inputtext';
import Message from 'primevue/message';
import MultiSelect from 'primevue/multiselect';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const props = defineProps({
    role: { type: Object },
    permission: Object,
    rolePermissions: Object,
});

const form = useForm({
    name: props.role.name,
    permisos: Object.values(props.rolePermissions),
});

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Editar Rol', href: '/dashboard' }];

const submit = () => {
    form.patch(route('roles.update', props.role.id), {
        onSuccess: () =>
            toast.add({
                severity: 'success',
                summary: 'Registro actualizado',
                detail: 'El rol se ha actualizado exitosamente',
                life: 5000,
            }),
    });
};

const agruparPorModulo = (permisos) => {
    return permisos.reduce((grupos, permiso) => {
        const [modulo] = permiso.split('-');
        grupos[modulo] = grupos[modulo] || [];
        grupos[modulo].push(permiso);
        return grupos;
    }, {});
};

const colorPorModulo = (modulo) => {
    const colores = {
        usuarios: 'bg-cyan-800 text-white dark:text-white',
        servicios: 'bg-sky-600 text-white dark:bg-sky-500 dark:text-white',
        empleados: 'bg-cyan-500 text-white',
        categorias: 'bg-teal-500 text-white dark:text-white',
        rol: 'bg-cyan-700 text-white dark:text-white',
        ubicaciones: 'bg-teal-600 text-white dark:text-white',
        inventario: 'bg-cyan-900 text-white dark:text-white',
        proveedores: 'bg-cyan-800 text-white dark:text-white',
        transacciones: 'bg-cyan-700 text-white dark:text-white',
        productos: 'bg-teal-500 text-white dark:text-white',
    };
    return colores[modulo] || 'bg-gray-200';
};
</script>

<template>
    <Head title="Panel de control" />
    <AppLayout :breadcrumbs="breadcrumbs" :back="true">
        <div class="grid grid-cols-1 p-5">
            <!-- Formulario -->
            <div class="p-6 shadow">
                <form @submit.prevent="submit" class="grid grid-cols-3 gap-4">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <InputText
                            id="name"
                            v-model="form.name"
                            autofocus
                            type="text"
                            class="mt-1 w-full"
                            :invalid="form.errors.name"
                            @input="form.clearErrors('name')"
                        />
                        <Message v-if="form.errors.name" severity="error">{{ form.errors.name }}</Message>
                    </div>

                    <!-- Permisos -->
                    <div>
                        <label for="permisos" class="text-sm font-medium text-gray-700 dark:text-gray-300">Permisos</label>
                        <MultiSelect
                            id="permisos"
                            v-model="form.permisos"
                            :options="Object.values(permission)"
                            filter
                            placeholder="Selecciona los permisos"
                            :maxSelectedLabels="7"
                            class="mt-1 w-full"
                        />
                    </div>

                    <!-- Botón Guardar -->
                    <div class="mt-7">
                        <Button type="submit" label="Guardar" icon="pi pi-save" class="bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" />
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-2 grid grid-cols-3 gap-4 p-5">
            <Fieldset v-for="(grupoPermisos, modulo) in agruparPorModulo(form.permisos)" :key="modulo" :legend="modulo" class="p-4">
                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="permiso in grupoPermisos"
                        :key="permiso"
                        :class="colorPorModulo(modulo)"
                        class="inline-block rounded px-3 py-1 text-sm font-medium"
                    >
                        {{ permiso }}
                    </span>
                </div>
            </Fieldset>
        </div>
    </AppLayout>
    <Toast />
</template>
