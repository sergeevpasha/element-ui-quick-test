const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    host: '0.0.0.0',
    port: 8080,
    allowedHosts: 'all',
    proxy: {
      "/api/*": {
        target: process.env.VUE_APP_BASE_URL,
        secure: false,
        changeOrigin: true
      }
    }
  }
})
