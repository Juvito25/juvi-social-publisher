/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                'juvi': {
                    'dark': '#262626',
                    'primary': '#A8D95F',
                    'light': '#D2F2A2',
                    'dark-secondary': '#81A64B',
                    'border': '#7D8C65',
                }
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}
