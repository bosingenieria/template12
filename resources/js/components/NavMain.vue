<script setup lang="ts">
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuAction,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ListCollapse } from 'lucide-vue-next';
import { computed } from 'vue';
defineProps<{
    items: NavItem[];
    label: string;
}>();

const routePath = computed(() => {
    return props.page.url.split('/').slice(3).join('/').toLowerCase();
});
const page = usePage<SharedData>();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>{{ label }}</SidebarGroupLabel>
        <SidebarMenu>
            <template v-for="item in items" :key="item.title">
                <!-- Si tiene submenús, usar Collapsible -->
                <Collapsible
                    v-if="item.submenus && item.submenus.length"
                    class="group/collapsible"
                    :defaultOpen="page.url.includes(item.href.toLowerCase())"
                >
                    <SidebarMenuItem>
                        <CollapsibleTrigger asChild>
                            <SidebarMenuButton as-child class="hover:bg-teal-600 hover:text-white">
                                <button>
                                    <component :is="item.icon" />
                                    <span>{{ item.title }}</span>
                                </button>
                            </SidebarMenuButton>
                            <SidebarMenuAction> <ListCollapse /></SidebarMenuAction>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem
                                    v-for="sub in item.submenus"
                                    :key="sub.title"
                                    :class="{ 'rounded-md bg-teal-600 text-white': page.url.split(item.href).pop().includes(sub.key.toLowerCase()) }"
                                >
                                    <Link
                                        :href="sub.href"
                                        class="flex gap-1 rounded-md px-1 py-1 text-sm transition duration-200"
                                        :class="{
                                            'hover:bg-gray-300 dark:hover:bg-gray-700': !page.url
                                                .split(item.href)
                                                .pop()
                                                .includes(sub.key.toLowerCase()),
                                        }"
                                    >
                                        <component :is="sub.icon" width="18" />
                                        <span>{{ sub.title }}</span>
                                    </Link>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>

                <!-- Si NO tiene submenús, renderizar el botón normal -->
                <SidebarMenuItem v-else>
                    <SidebarMenuButton as-child :is-active="page.url.includes(item.title.toLowerCase())" class="hover:bg-teal-600 hover:text-white">
                        <Link :href="item.href">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>
