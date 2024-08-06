import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [svelte()],

    server: {
        port: 9394
    },

    build: {
        rollupOptions: {
            input: '/src/admin.ts',
            output: {
                entryFileNames: 'admin.js',
            },
        }
    }
})
