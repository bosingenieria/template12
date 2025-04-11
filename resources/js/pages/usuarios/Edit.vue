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
                <InputLabel for="estado" value="Estado" class="dark:text-white" />
                <ToggleSwitch v-model="form.status" />
                <InputError class="mt-2" :message="form.errors.status" />
            </div>
            <hr class="col-span-2" />
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
            <div class="col-span-2 flex justify-end">
                <div class="mt-4 flex flex-col items-end">
                    <Button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Guardar</Button>
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
import ToggleSwitch from 'primevue/toggleswitch';


const toast = useToast();
const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    roles: {
        type: Object,
        default: () => ({}),
    },
    userRole: {
        type: Object,
        default: () => ({}),
    },
});
const selectedRoles = Object.values(props.userRole);
const user = props.user;
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Editar usuario', href: '/dashboard' }];

console.log(user);
const form = useForm({
    name: user.name,
    email: user.email,
    status: user.status === 1,
    password: '',
    password_confirmation: '',
    roles_user: selectedRoles,
});

const submit = () => {
    form.patch(route('usuarios.update', user.id), {
        onSuccess: function () {
            toast.add({
                severity: 'success',
                summary: 'Registro Guardado',
                detail: 'Los cambios se han guardado correctamente',
                life: 5000,
            });
        },
    });
};

const goBack = () => {
    window.history.back();
};
</script>
