import { URL, fileURLToPath } from 'node:url'
import { defineConfig } from 'vite'
import { visualizer } from 'rollup-plugin-visualizer'
import vue from '@vitejs/plugin-vue'
import autoImport from 'unplugin-auto-import/vite'
import svgLoader from 'vite-svg-loader'

export default defineConfig({
  plugins: [
    vue(),
    svgLoader(),
    visualizer(),
    autoImport({
      imports: ['vue', 'vue-router', 'pinia'],
      dts: './src/types/dts/auto-imports.d.ts',
      dirs: [
        './src/stores/',
      ],
    }),
  ],
  resolve: {
    alias: {
      '#': fileURLToPath(new URL('./src', import.meta.url)),
    },
    extensions: ['.js', '.json', '.jsx', '.mjs', '.ts', '.tsx', '.vue', '.store'],
  },

  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
            @import './src/assets/scss/_variables.scss';
          `,
      },
    },
  },
})
