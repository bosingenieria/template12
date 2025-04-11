<template>
    <Head title="Crear usuario" />
    <AppLayout :breadcrumbs="breadcrumbs" :back="true">
        <form @submit.prevent="submit" class="grid gap-4 p-4 lg:grid-cols-2">
            <div>
                <InputLabel for="name" value="Nombre" class="dark:text-white" />
                <InputText id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Correo electronico" class="dark:text-white" />
                <InputText id="email" type="email" class="mt-1 block w-full" v-model="form.email" autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel for="password" value="Contraseña" class="dark:text-white" />
                <InputText id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirmar contraseña" class="dark:text-white" />
                <InputText
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
            <div>
                <InputLabel for="roles" value="Roles" class="dark:text-white" />

                <div class="card justify-content-center flex">
                    <MultiSelect
                        id="roles"
                        v-model="form.roles_user"
                        display="chip"
                        :options="Object.values(roles)"
                        placeholder="Seleccione rol"
                        :maxSelectedLabels="3"
                        class="md:w-20rem w-full"
                    />
                </div>
                <InputError class="mt-2" :message="form.errors.roles_user" />
            </div>
            <div>
                <div class="mt-4 flex flex-col items-end">
                    <Button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Registrar Usuario </Button>
                </div>
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
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import { useToast } from 'primevue/usetoast';
const toast = useToast();
const props = defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    },
});

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Crear usuario', href: '/dashboard' }];

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    roles_user: '',
});

const submit = () => {
    form.estado = 1;
    form.post(route('usuarios.store'), {
        onSuccess: function () {
            toast.add({
                severity: 'success',
                summary: 'Registro Guardado',
                detail: 'El usuario se ha almacenado exitosamente',
                life: 5000,
            });
        },
    });
};

const goBack = () => {
    window.history.back();
};
</script>
