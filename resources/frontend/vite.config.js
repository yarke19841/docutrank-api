import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

export default defineConfig({
  base: '/', // necesario para funcionar correctamente en producción
  plugins: [react()],
  build: {
    outDir: 'dist',
    emptyOutDir: true
  }
})
