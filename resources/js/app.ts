import '../css/app.css';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css'
import Aura from '@primeuix/themes/aura';
import ToastService from 'primevue/toastservice';
import { definePreset } from '@primeuix/themes';
import Tooltip from 'primevue/tooltip';

import Traduccion from '../../public/traduccion.json';
// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const Noir = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{emerald.50}',
            100: '{emerald.100}',
            200: '{emerald.200}',
            300: '{emerald.300}',
            400: '{teal.400}',
            500: '{teal.500}',
            600: '{teal.600}',
            700: '{cyan.700}',
            800: '{cyan.800}',
            900: '{cyan.900}',
            950: '{cyan.950}'
        },
        colorScheme: {
            light: {
                primary: {
                    color: '{cyan.950}',
                    inverseColor: '#ffffff',
                    hoverColor: '{cyan.900}',
                    activeColor: '{cyan.800}'
                },
                highlight: {
                    background: '{cyan.950}',
                    focusBackground: '{cyan.700}',
                    color: '#ffffff',
                    focusColor: '#ffffff'
                }
            },
            dark: {
                primary: {
                    color: '{emerald.50}',
                    inverseColor: '{cyan.950}',
                    hoverColor: '{emerald.100}',
                    activeColor: '{emerald.200}'
                },
                highlight: {
                    background: 'rgba(250, 250, 250, .16)',
                    focusBackground: 'rgba(250, 250, 250, .24)',
                    color: 'rgba(255,255,255,.87)',
                    focusColor: 'rgba(255,255,255,.87)'
                }
            }
        }
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(PrimeVue, {
                theme: {
                    preset: Noir,
                    options: {
                        darkModeSelector: '.dark',
                    }
                },
                locale: Traduccion
             })
            .use(ToastService)
            .use(plugin)
            .use(ZiggyVue)
            .directive('tooltip', Tooltip)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
