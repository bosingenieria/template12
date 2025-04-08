<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Listbox from 'primevue/listbox';
import { ref, watch } from 'vue';

const props = defineProps({
    roles: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/dashboard',
    },
];

const selectedRole = ref();

// Observa los cambios en selectedRole y redirige cuando se seleccione un rol
watch(selectedRole, (newRole) => {
    if (newRole) {
        router.visit(route('roles.edit', { role: newRole }));
    }
});
</script>

<template>
    <Head title="Panel de control" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative">
                    <Button asChild v-slot="slotProps" severity="info" variant="text" class="mb-0">
                        <Link :href="route('roles.create')" :class="slotProps.class"> <i class="pi pi-plus"></i> Agregar rol </Link>
                    </Button>
                    <Listbox
                        v-model="selectedRole"
                        checkmark
                        :highlightOnSelect="false"
                        :options="props.roles"
                        filter
                        optionValue="id"
                        optionLabel="name"
                        class="mt-2 w-full text-sm md:w-56"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
