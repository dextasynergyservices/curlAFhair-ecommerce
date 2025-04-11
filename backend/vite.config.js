import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        outDir: "public/build", // Output compiled files to public/build
        manifest: true, // Create a manifest for Laravel
    },
    server: {
        proxy: {
            "/app": "http://127.0.0.1", // Proxy API requests to Laravel backend
        },
    },
});
