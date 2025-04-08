<template>
    <Head title="Editar cliente" />
    <AppLayout :breadcrumbs="breadcrumbs" :back="true">
        <form @submit.prevent="submit" class="mt-5 px-10">
            <div class="grid grid-cols-4 gap-4">
                <div class="cols-span-1">
                    <InputLabel class="dark:text-white" for="tipo_documento" value="Tipo de documento" />
                    <Select
                        v-model="form.tipo_doc"
                        :options="tipos_doc"
                        optionLabel="name"
                        optionValue="name"
                        placeholder="Seleccione un tipo"
                        class="font-8 mt-2 w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.tipo_doc" />
                </div>
                <div class="cols-span-1">
                    <InputLabel class="dark:text-white" for="documento_identidad" value="Número de documento" />
                    <InputText v-model="form.documento_identidad" class="font-8 mt-2 w-full" style="text-transform: uppercase" />
                    <InputError class="mt-2" :message="form.errors.documento_identidad" />
                </div>
                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="nombre" value="Nombre" />
                    <InputText v-model="form.nombre" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.nombre" />
                </div>
                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="apellido" value="Apellido" />
                    <InputText v-model="form.apellido" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.apellido" />
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-4">

                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="email" value="Email" />
                    <InputText v-model="form.email" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="telefono_principal" value="Telefono principal" />
                    <InputNumber v-model="form.telefono_principal" class="font-8 mt-2 w-full" :useGrouping="false" fluid />
                    <InputError class="mt-2" :message="form.errors.telefono_principal" />
                </div>
                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="telefono_secundario" value="Telefono secundario" />
                    <InputNumber v-model="form.telefono_secundario" class="font-8 mt-2 w-full" :useGrouping="false" fluid />
                    <InputError class="mt-2" :message="form.errors.telefono_secundario" />
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-4">
                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="direccion_principal" value="Dirección principal" />
                    <InputText v-model="form.direccion_principal" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.direccion_principal" />
                </div>
                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="direccion_secundaria" value="Dirección secundaria" />
                    <InputText v-model="form.direccion_secundaria" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.direccion_secundaria" />
                </div>
                <div class="col-span-1">
                    <InputLabel class="dark:text-white" for="estado" value="Estado" />
                    <ToggleSwitch class="w-full mt-2 font-8" v-model="form.estado"/>
                    <InputError
                        class="mt-2"
                        :message="form.errors.estado"
                    />
                </div>
            </div>
            <div class="mt-5 flex w-full justify-end gap-4">
                <Button type="button" label="Cancelar" variant="outlined" icon="pi pi-times" class="font-8" @click="goBack" />
                <Button type="submit" label="Guardar" icon="pi pi-save" class="font-8" />
            </div>
        </form>
    </AppLayout>
</template>
<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import DatePicker from 'primevue/datepicker';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import ToggleSwitch from 'primevue/toggleswitch';
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';

const props = defineProps({
    cliente: {
        type: Object,
        default: () => ({}),
    },
});
const toast = useToast();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Editar cliente', href: '/dashboard' }];

const tipos_doc = ref([
    { name: 'Cédula de ciudadanía' },
    { name: 'Cédula de extranjería' },
    { name: 'Pasaporte' },
    { name: 'Registro Único Tributario (RUT)' },
    { name: 'Número de Identificación Tributaria (NIT)' },
    { name: 'Licencia comercial' },
    { name: 'Identificación fiscal' },
    { name: 'Registro mercantil' },
]);

const form = useForm({
    tipo_doc: props.cliente.tipo_doc || '',
    documento_identidad: props.cliente.documento_identidad || '',
    nombre: props.cliente.nombre || '',
    apellido: props.cliente.apellido || '',
    email: props.cliente.email || '',
    telefono_principal: props.cliente.telefono_principal || null,
    telefono_secundario: props.cliente.telefono_secundario || null,
    direccion_principal: props.cliente.direccion_principal || '',
    direccion_secundaria: props.cliente.direccion_secundaria || '',
    estado: props.cliente.estado === 1,
});

const submit = () => {
    form.patch(route('clientes.update', props.cliente.id), {
        onSuccess: function () {
            toast.add({
                severity: 'success',
                summary: 'Registro Guardado',
                detail: 'El cliente se ha editado exitosamente',
                life: 5000,
            });
        },
    });
};

const goBack = () => {
    window.history.back();
};
</script>
