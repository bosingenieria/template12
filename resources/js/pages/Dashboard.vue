<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Panel de control',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Panel de control" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="bg-surface-50 dark:bg-surface-950 px-4 py-8 md:px-6 lg:px-10">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <div class="bg-surface-0 rounded-border rounded-xl p-4 shadow dark:bg-zinc-900">
                        <div class="mb-4 flex justify-between">
                            <div>
                                <span class="text-surface-500 dark:text-surface-300 mb-4 block font-medium">Clientes</span>
                                <div class="text-surface-900 dark:text-surface-0 !text-xl font-medium">152</div>
                            </div>
                            <div class="rounded-border flex h-10 w-10 items-center justify-center">
                                <i class="pi pi-shopping-cart !text-4xl dark:text-teal-300" />
                            </div>
                        </div>
                        <span class="font-medium text-green-500">24 new </span>
                        <span class="text-surface-500 dark:text-surface-300">since last visit</span>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <div class="bg-surface-0 rounded-border rounded-xl p-4 shadow dark:bg-zinc-900">
                        <div class="mb-4 flex justify-between">
                            <div>
                                <span class="text-surface-500 dark:text-surface-300 mb-4 block font-medium">Users</span>
                                <div class="text-surface-900 dark:text-surface-0 !text-xl font-medium">$2.100</div>
                            </div>
                            <div class="rounded-border flex h-10 w-10 items-center justify-center">
                                <i class="pi pi-map-marker !text-4xl dark:text-teal-300" />
                            </div>
                        </div>
                        <span class="font-medium text-green-500">%52+ </span>
                        <span class="text-surface-500 dark:text-surface-300">since last week</span>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <div class="bg-surface-0 rounded-border rounded-xl p-4 shadow dark:bg-zinc-900">
                        <div class="mb-4 flex justify-between">
                            <div>
                                <span class="text-surface-500 dark:text-surface-300 mb-4 block font-medium">Modulo 3</span>
                                <div class="text-surface-900 dark:text-surface-0 !text-xl font-medium">28441</div>
                            </div>
                            <div class="rounded-border flex h-10 w-10 items-center justify-center">
                                <i class="pi pi-inbox !text-4xl dark:text-teal-300" />
                            </div>
                        </div>
                        <span class="font-medium text-green-500">520 </span>
                        <span class="text-surface-500 dark:text-surface-300">newly registered</span>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <div class="bg-surface-0 rounded-border rounded-xl p-4 shadow dark:bg-zinc-900">
                        <div class="mb-4 flex justify-between">
                            <div>
                                <span class="text-surface-500 dark:text-surface-300 mb-4 block font-medium">Comentarios</span>
                                <div class="text-surface-900 dark:text-surface-0 !text-xl font-medium">152 Unread</div>
                            </div>
                            <div class="rounded-border flex h-10 w-10 items-center justify-center">
                                <i class="pi pi-comment !text-4xl dark:text-teal-300" />
                            </div>
                        </div>
                        <span class="font-medium text-green-500">85 </span>
                        <span class="text-surface-500 dark:text-surface-300">responded</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
