import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/registration-international-form.js",
                "resources/js/registration-vietnamese-form.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
