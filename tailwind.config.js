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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    50: '#eef3f9',
                    100: '#d7e3f0',
                    200: '#aec7e1',
                    300: '#7fa5cc',
                    400: '#4f7fae',
                    500: '#2f5f8f',
                    600: '#1f4570',
                    700: '#173659',
                    800: '#102846',
                    900: '#0b2545',
                    950: '#071630',
                },
                gold: {
                    50: '#fdf8ec',
                    100: '#faedc7',
                    200: '#f4da8f',
                    300: '#edc157',
                    400: '#e2ab31',
                    500: '#d4a017',
                    600: '#b17f13',
                    700: '#8a5f14',
                    800: '#714c17',
                    900: '#5f4018',
                },
            },
        },
    },

    plugins: [forms],
};
