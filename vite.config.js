import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // Other Vite configuration options...
    resolve: {
        alias: {
            bootstrap: "/node_modules/bootstrap/dist/css/bootstrap.min.css",
            //jquery: "/node_modules/jquery/dist/jquery.min.js",
            //jquery: "/resources/js/jquery-3.7.1.min.js",
        },
    },



  build: {
    assetsInlineLimit: 0,
    cssCodeSplit: false,
    rollupOptions: {
      input: {
        grid: 'resources/css/grid.css',
        style: 'resources/css/style.css'
      },
      output: {
        manualChunks: {
          grid: ['grid'],
          style: ['style']
        }
      }
    },
    outDir: 'public/css'  // Output directory for compiled CSS files
  }
});



