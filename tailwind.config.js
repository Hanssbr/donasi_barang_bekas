import forms from "@tailwindcss/forms";
import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                greenleaf: "#5F8D4E",
                lightgreen: "rgba(182, 215, 168, 0.8)",
                softwhite: "#F6F5F5",
            },
        },
    },

    darkMode: "class",
    plugins: [forms],
};
