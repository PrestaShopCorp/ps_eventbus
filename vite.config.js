import { defineConfig } from 'vite'
import Components from 'unplugin-vue-components/vite'
import AutoImport from 'unplugin-auto-import/vite'
import { PuikResolver } from '@prestashopcorp/puik-resolver'
import path from 'node:path'
import fs from 'node:fs'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  root: path.resolve(__dirname, 'frontend'),
  base: '/',
  build: {
    manifest: true,
    outDir: path.resolve(__dirname, 'views'),
    emptyOutDir: false,
    cssCodeSplit: false,
    assetsInlineLimit: 100 * 1024,
    rollupOptions: {
      input: path.resolve(__dirname, 'frontend/js/main.js'),
      output: {
        format: 'es',
        entryFileNames: 'js/[name]-[hash].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (info) => {
          if (info?.name?.match(/\.woff2?$/)) {
            return 'css/fonts/[name]-[hash][extname]'
          }
          if (info?.name?.endsWith('.css')) {
            return 'css/style-[hash][extname]'
          }
          return 'js/[name]-[hash][extname]'
        },
        manualChunks: (id) => {
          if (id.includes('node_modules')) {
            return 'vendor'
          } else if (id.includes('translations')) {
            return `translations/${path.basename(id).split('.')[0]}`
          }
        },
      },
    },
  },
  plugins: [
    vue(),
    Components({
      resolvers: [PuikResolver()],
    }),
    AutoImport({
      resolvers: [PuikResolver()],
    }),
    {
      name: 'clean-js-css-on-build',
      apply: 'build',
      buildStart() {
        const viewsDir = path.resolve(__dirname, 'views')
        for (const sub of ['js', 'css', '.vite']) {
          const dir = path.resolve(viewsDir, sub)
          if (fs.existsSync(dir)) {
            fs.rmSync(dir, { recursive: true })
          }
        }
      },
    },
  ],
  server: {
    host: '0.0.0.0',
    port: 5173,
    cors: true,
    origin: 'http://localhost:5173',
    watch: {
      usePolling: true,
      interval: 300,
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
          @use "@/scss/global" as *;
        `,
      },
    },
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'frontend'),
      '~': path.resolve(__dirname, 'node_modules'),
    },
  },
})
