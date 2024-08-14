import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],

    theme: {
        fontFamily: {
            sans: ["Rubik", "sans-serif"],
            serif: ["Poppins", "serif"],
        },
        fontWeight: {
            normal: 400,
            medium: 500,
            semibold: 600,
            bold: 700,
            extrabold: 800,
        },
    },

    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#fca17d",
                    secondary: "#111827",
                    accent: "#1e5298",
                    neutral: "#f9dbbd",
                    "base-100": "#1f2937",
                    info: "#e0e7ff",
                    success: "#50d2a4",
                    warning: "#fbbf24",
                    error: "#dc2626",
                },
            },
        ],
    },

    plugins: [forms, require("daisyui")],
};
