module.exports = {
    plugins: {
        tailwindcss: { config: './tailwindcss-config.js' },
        autoprefixer: {}
    },

    content: [
        './pages/**/*.{html,js}',
        './components/**/*.{html,js}',
    ],
}