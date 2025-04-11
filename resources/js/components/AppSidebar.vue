<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, BookUser, Cloudy, Contact, Folder, LayoutGrid, Pickaxe, ScanBarcode, Users } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

const page = usePage();
const permissions = computed(() => page.props.auth.permissions);
const mainNavItems: NavItem[] = [
    {
        title: 'Panel de control',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Clientes',
        href: '/clientes',
        icon: BookUser,
        permission: 'clientes-listar',
    },
    {
        title: 'SubMenu',
        href: '/md_prod',
        icon: ScanBarcode,
        permission: null,
        submenus: [
            {
                title: 'Menu 1',
                key: 'llave1',
                href: '#',
                icon: ScanBarcode,
                permission: null,
            },
            {
                title: 'Menu 2',
                key: 'llave2',
                href: '#',
                icon: Folder,
                permission: null,
            },
            {
                title: 'Menu 3',
                key: 'llave3',
                href: '#',
                icon: Contact,
                permission: null,
            },
        ],
    },
    {
        title: 'Empleados',
        href: '/empleados',
        icon: Pickaxe,
        permission: 'empleados-listar',
    },
    {
        title: 'Modulo',
        href: '/dashboard',
        icon: Folder,
    },
    {
        title: 'Reportes',
        href: '/dashboard',
        icon: Cloudy,
    },

    {
        title: 'Servicios',
        href: '/dashboard',
        icon: Folder,
        permission: null,
        submenus: [
            {
                title: 'Servicios',
                href: '/servicios',
                icon: Folder,
                permission: 'servicios-listar',
            },
            {
                title: 'Citas',
                href: '/citas',
                icon: Folder,
                permission: 'citas-listar',
            },
        ],
    },
];

const mainNavItemsSecurity: NavItem[] = [
    {
        title: 'Usuarios',
        href: '/usuarios',
        icon: Users,
        permission: 'usuarios-listar',
    },
    {
        title: 'Roles',
        href: '/roles',
        icon: LayoutGrid,
        permission: 'rol-listar',
    },
];

const footerNavItems: NavItem[] = [
    /*     {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    }, */
    {
        title: 'Documentación',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];

const hasPermission = (permiso: string | null) => {
    if (!permiso) return true; // Si no se define un permiso, el ítem siempre aparece
    return permissions.value.some((permission: any) => permission.name === permiso);
};

// Filtrar los elementos del menú basados en los permisos del usuario
const filteredMainNavItems = computed(() => {
    return mainNavItems
        .map((item) => {
            // Si tiene submenús, filtrarlos según permisos
            if (item.submenus) {
                const filteredSubmenus = item.submenus.filter((sub) => hasPermission(sub.permission));
                // Si el padre no tiene permiso, pero al menos un submenú sí, se mantiene
                if (!hasPermission(item.permission) && filteredSubmenus.length === 0) {
                    return null; // No mostrar el ítem principal si no hay nada que mostrar
                }

                return { ...item, submenus: filteredSubmenus }; // Devolver el ítem con submenús filtrados
            }
            // Si no tiene submenús, comprobar permiso normal
            return hasPermission(item.permission) ? item : null;
        })
        .filter((item) => item !== null); // Eliminar los elementos nulos
});

const filteredMainNavItemsSecurity = computed(() => mainNavItemsSecurity.filter((item) => hasPermission(item.permission)));
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="filteredMainNavItems" label="Modulos" />
            <NavMain :items="filteredMainNavItemsSecurity" label="Seguridad" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
