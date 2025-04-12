<template>
    <Head title="Crear proveedor" />
    <AppLayout :breadcrumbs="breadcrumbs" :back="true">
        <form @submit.prevent="submit" class="mt-5 px-10">
            <div class="grid grid-cols-3 gap-4">
                <div class="cols-span-1">
                    <InputLabel for="tipo_documento" value="Tipo de documento" class="dark:text-gray-200" />
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
                    <InputLabel for="documento" value="Número de documento" class="dark:text-gray-200" />
                    <InputText v-model="form.documento" class="font-8 mt-2 w-full" style="text-transform: uppercase" />
                    <InputError class="mt-2" :message="form.errors.documento" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="nombre" value="Nombre" class="dark:text-gray-200" />
                    <InputText v-model="form.nombre" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.nombre" />
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-4">
                <div class="cols-span-1">
                    <InputLabel for="Area" value="Area" class="dark:text-gray-200" />
                    <InputText v-model="form.departamento" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.departamento" />
                </div>
                <div class="cols-span-1">
                    <InputLabel for="cargo" value="Cargo" class="dark:text-gray-200" />
                    <InputText v-model="form.cargo" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.cargo" />
                </div>
                <div class="cols-span-1">
                    <InputLabel for="fecha" value="Fecha nacimiento" class="dark:text-gray-200" />
                    <DatePicker v-model="form.fecha_nacimiento" class="font-8 mt-2 w-full" dateFormat="yy-mm-dd" />
                    <InputError class="mt-2" :message="form.errors.cargo" />
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-4">
                <div class="col-span-1">
                    <InputLabel for="email" value="Email" class="dark:text-gray-200" />
                    <InputText v-model="form.email" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="telefono" value="Telefono" class="dark:text-gray-200" />
                    <InputNumber v-model="form.telefono" class="font-8 mt-2 w-full" :useGrouping="false" fluid />
                    <InputError class="mt-2" :message="form.errors.telefono" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="direccion" value="Dirección" class="dark:text-gray-200" />
                    <InputText v-model="form.direccion" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.direccion" />
                </div>
            </div>
            <div class="mt-5 flex w-full justify-end gap-4">
                <Button type="button" label="Cancelar" variant="outlined" icon="pi pi-times" class="font-8" @click="goBack" />
                <Button type="submit" label="Guardar" icon="pi pi-save" :loader="true" class="font-8" />
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
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';

const toast = useToast();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Crear empleado', href: '/dashboard' }];

const tipos_doc = ref([{ name: 'Cédula de ciudadanía' }, { name: 'Cédula de extranjería' }, { name: 'Pasaporte' }]);

const form = useForm({
    tipo_doc: '',
    documento: '',
    nombre: '',
    cargo: '',
    email: '',
    telefono: null,
    direccion: '',
    departamento: '',
    fecha_nacimiento: '',
    estado: 0,
});

const submit = () => {
    form.estado = 1;
    form.post(route('empleados.store'), {
        onSuccess: function () {
            toast.add({
                severity: 'success',
                summary: 'Registro Guardado',
                detail: 'El proveedor se ha almacenado exitosamente',
                life: 5000,
            });
        },
    });
};

const goBack = () => {
    window.history.back();
};
</script>
