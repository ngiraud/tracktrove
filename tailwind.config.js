import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: 'rgb(var(--color-primary) / <alpha-value>)',
                },
            },

            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },

            gridTemplateRows: {
                '10': 'repeat(10, minmax(0, 1fr))',
            },
        },
    },

    plugins: [forms],
};
