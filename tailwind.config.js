import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import twelements from 'tw-elements/dist/plugin';
import preset from './vendor/filament/filament/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/tw-elements/dist/js/**/*.js',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './resources/views/vendor/filament-panels/**/*.blade.php',
        './resources/views/vendor/filament-widgets/**/*.blade.php',
        './vendor/awcodes/filament-quick-create/resources/**/*.blade.php',
        './vendor/awcodes/filament-table-repeater/resources/**/*.blade.php'
    ],

    plugins: [
        forms,
        typography,
        twelements,
    ],
};
