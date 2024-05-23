import './bootstrap';
import '../css/app.css';

import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import i18n from "i18next";
import { useTranslation, initReactI18next } from "react-i18next";
import { InertiaProgress } from '@inertiajs/progress';
import nl from "../../lang/nl.json";
import en from "../../lang/en.json";

i18n
    .use(initReactI18next)
    .init({
        resources: {
            nl: {
                translation: nl
            },
            en: {
                translation: en
            },
        },
        lng: "en",
        fallbackLng: "en",
        interpolation: {
            escapeValue: false
        }
    });

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(
            <React.StrictMode>
                <App {...props} />
            </React.StrictMode>
        );
    },
    progress: {
        color: '#4B5563',
    },
});

InertiaProgress.init();
