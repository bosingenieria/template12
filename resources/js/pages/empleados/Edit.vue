<template>
    <Head title="Editar empleado" />
    <AppLayout :breadcrumbs="breadcrumbs" :back="true">
        <form @submit.prevent="submit" class="mt-5 px-10">
            <div class="grid grid-cols-3 gap-4">
                <div class="cols-span-1">
                    <InputLabel for="tipo_documento" value="Tipo de documento" />
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
                    <InputLabel for="documento" value="Número de documento" />
                    <InputText v-model="form.documento" class="font-8 mt-2 w-full" style="text-transform: uppercase" />
                    <InputError class="mt-2" :message="form.errors.documento" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="nombre" value="Nombre" />
                    <InputText v-model="form.nombre" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.nombre" />
                </div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-4">
                <div class="cols-span-1">
                    <InputLabel for="cargo" value="Cargo" />
                    <InputText v-model="form.cargo" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.cargo" />
                </div>
                <div class="cols-span-1">
                    <InputLabel for="Departamento" value="Area" />
                    <InputText v-model="form.departamento" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.departamento" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="fecha_nacimiento" value="Fecha Nacimiento" />
                    <DatePicker v-model="form.fecha_nacimiento" class="font-8 mt-2 w-full" dateFormat="yy-mm-dd" />
                    <InputError class="mt-2" :message="form.errors.fecha_nacimiento" />
                </div>
            </div>

            <div class="mt-2 grid grid-cols-4 gap-4">
                <div class="col-span-1">
                    <InputLabel for="email" value="Email" />
                    <InputText v-model="form.email" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="telefono" value="Telefono" />
                    <InputNumber v-model="form.telefono" class="font-8 mt-2 w-full" :useGrouping="false" fluid />
                    <InputError class="mt-2" :message="form.errors.telefono" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="direccion" value="Dirección" />
                    <InputText v-model="form.direccion" class="font-8 mt-2 w-full" />
                    <InputError class="mt-2" :message="form.errors.direccion" />
                </div>
                <div>
                    <InputLabel for="estado" value="Estado" />
                    <ToggleSwitch class="font-8 mt-2 w-full" v-model="form.estado" />
                    <InputError class="mt-2" :message="form.errors.estado" />
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
    empleado: {
        type: Object,
        default: () => ({}),
    },
});
console.log(props.empleado);
const toast = useToast();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Editar empleado', href: '/dashboard' }];

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
    tipo_doc: props.empleado.tipo_doc,
    documento: props.empleado.documento,
    nombre: props.empleado.nombre,
    cargo: props.empleado.cargo,
    email: props.empleado.email,
    telefono: props.empleado.telefono,
    direccion: props.empleado.direccion,
    departamento: props.empleado.departamento,
    fecha_nacimiento: new Date(props.empleado.fecha_nacimiento),
    estado: props.empleado.estado === 1,
});

const submit = () => {
    form.patch(route('empleados.update', props.empleado.id), {
        onSuccess: function () {
            toast.add({
                severity: 'success',
                summary: 'Registro Guardado',
                detail: 'El empleado se ha editado exitosamente',
                life: 5000,
            });
        },
    });
};

const goBack = () => {
    window.history.back();
};
</script>
