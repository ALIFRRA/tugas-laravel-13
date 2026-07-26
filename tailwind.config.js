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
                shuka: {
                    pink: '#F472B6',
                    soft: '#FCE7F3',
                    blush: '#FFF5F9',
                    mist: '#F7F7F8',
                    ink: '#3F3F46',
                    muted: '#71717A',
                    line: '#E4E4E7',
                    string: '#D4D4D8',
                },
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Caveat', 'cursive'],
            },
            backgroundImage: {
                'notebook': 'repeating-linear-gradient(transparent, transparent 27px, #F9A8D4 28px)',
                'strings': 'repeating-linear-gradient(90deg, transparent, transparent 18px, rgba(244,114,182,0.12) 19px)',
            },
        },
    },

    plugins: [forms],
};
