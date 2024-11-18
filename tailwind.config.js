import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "sans-serif"],
            },
            boxShadow: {
                all: "0 4px 6px rgba(0, 0, 0, 0.05), 0 -4px 6px rgba(0, 0, 0, 0.05), 4px 0 6px rgba(0, 0, 0, 0.05), -4px 0 6px rgba(0, 0, 0, 0.05)",
                "all-darker":
                    "0 4px 6px rgba(0, 0, 0, 0.1), 0 -4px 6px rgba(0, 0, 0, 0.1), 4px 0 6px rgba(0, 0, 0, 0.1), -4px 0 6px rgba(0, 0, 0, 0.1)",
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
