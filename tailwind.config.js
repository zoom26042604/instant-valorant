/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./*.html", "./*.php"],
    theme: {
        extend: {
            colors: {
                valoRed: '#ff4654',
                valoDark: '#0f1923',
                valoCard: '#111823',
            }
        }
    },
    plugins: [],
}
