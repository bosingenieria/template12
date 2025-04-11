<template>
    <Head title="Crear cliente" />
    <AppLayout :breadcrumbs="breadcrumbs" :back="true">
        <form @submit.prevent="submit" class="mt-5 px-10">
            <div class="grid grid-cols-4 gap-4">
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
                    <InputLabel for="documento_identidad" value="Número de documento" class="dark:text-gray-200" />
                    <InputText v-model="form.documento_identidad" class="font-8 mt-2 w-full" style="text-transform: uppercase" />
                    <InputError class="mt-2" :message="form.errors.documento_identidad" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="nombre" value="Nombre" class="dark:text-gray-200" />
                    <InputText v-model="form.nombre" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.nombre" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="apellido" value="Apellido" class="dark:text-gray-200" />
                    <InputText v-model="form.apellido" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.apellido" />
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-4">
                
                <div class="col-span-1">
                    <InputLabel for="email" value="Email" class="dark:text-gray-200" />
                    <InputText v-model="form.email" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="telefono_principal" value="Telefono principal" class="dark:text-gray-200" />
                    <InputNumber v-model="form.telefono_principal" class="font-8 mt-2 w-full" :useGrouping="false" fluid />
                    <InputError class="mt-2" :message="form.errors.telefono_principal" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="telefono_secundario" value="Telefono secundario" class="dark:text-gray-200" />
                    <InputNumber v-model="form.telefono_secundario" class="font-8 mt-2 w-full" :useGrouping="false" fluid />
                    <InputError class="mt-2" :message="form.errors.telefono_secundario" />
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-4">
                
                
                <div class="col-span-1">
                    <InputLabel for="direccion_principal" value="Dirección principal" class="dark:text-gray-200" />
                    <InputText v-model="form.direccion_principal" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.direccion_principal" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="direccion_secundaria" value="Dirección secundaria" class="dark:text-gray-200" />
                    <InputText v-model="form.direccion_secundaria" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.direccion_secundaria" />
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
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';

const toast = useToast();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Crear cliente', href: '/dashboard' }];

const tipos_doc = ref([{ name: 'Cédula de ciudadanía' }, { name: 'Cédula de extranjería' }, { name: 'Pasaporte' }]);

const form = useForm({
    tipo_doc: '',
    documento_identidad: '',
    nombre: '',
    apellido: '',
    email: '',
    telefono_principal: null,
    telefono_secundario: null,
    direccion_principal: '',
    direccion_secundaria: '',
    estado: 1,
});

const submit = () => {
    form.estado = 1;
    form.post(route('clientes.store'), {
        onSuccess: function () {
            toast.add({
                severity: 'success',
                summary: 'Registro Guardado',
                detail: 'El cliente se ha almacenado exitosamente',
                life: 5000,
            });
        },
    });
};

const goBack = () => {
    window.history.back();
};
</script>
