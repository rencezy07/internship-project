import "../css/app.css";
import "./bootstrap";

import "@fortawesome/fontawesome-free/css/all.min.css";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

import UserLayout from "./Layouts/UserLayout.vue";
import AdminLayout from "./Layouts/AdminLayout.vue";
import CompanyLayout from "./Layouts/CompanyLayout.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue");
        const page = await resolvePageComponent(`./Pages/${name}.vue`, pages);

        // Dynamically assign layout based on the page name
        if (name.startsWith("Admin/")) {
            page.default.layout = page.default.layout || AdminLayout;
        } else if (name.startsWith("User/")) {
            page.default.layout = page.default.layout || UserLayout;
        } else if (name.startsWith("Company/")) {
            page.default.layout = page.default.layout || CompanyLayout;
        } else {
            page.default.layout = page.default.layout || AdminLayout; 
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
