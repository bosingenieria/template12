<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import Button from 'primevue/button';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    back?: boolean;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    back: false,
});
const goBack = () => {
    window.history.back();
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="back" class="m-0 flex justify-start p-0">
            <Button severity="primary" variant="text" class="mb-0" @click="goBack" label="Regresar" icon="pi pi-arrow-left "> </Button>
        </div>
        <slot />
    </AppLayout>
</template>
