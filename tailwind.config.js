const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        'node_modules/preline/dist/*.js',
        './node_modules/preline/preline.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                quicksand: ['Quicksand', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'neutral-100': '#FAFAFA',
                'neutral-200': '#D9D9D9',
                'neutral-300': '#D6D6D6',
                'neutral-400': '#C2C2C2',
                'neutral-500': '#8C8C8C',
                'neutral-600': '#737373',
                'neutral-700': '#595959',
                'neutral-800': '#404040',
                'neutral-900': '#131313',
                'primary-100': '#BE4169',
                'primary-200': '#983454',
                'primary-300': '#834A56',
                'primary-400': '#6D263C',
                'primary-500': '#4C1A2A',
                'secondary-100': '#FFFFFF',
                'secondary-200': '#EDF5F7',
                'secondary-300': '#DCEBF0',
                'secondary-400': '#B8D6E0',
                'secondary-500': '#94C2D1',
                'tartiary-100': '#FFF3E5',
                'tartiary-200': '#FBE4C7',
                'tartiary-300': '#FFDBAE',

            },
            screens: {
                print: {raw: 'print'},
                screen: {raw: 'screen'},
              },
        
        },
    },

    plugins: [  
        require('@tailwindcss/forms'),
        require('preline/plugin'),
    ],
};
