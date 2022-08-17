const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("daisyui"),
    ],
    daisyui: {
        styled: true,
        themes: false,
        // themes: [
        //     {
        //         goldfish: {
        //             primary: "#dc2626",
        //             secondary: "#f3f4f6",
        //             accent: "#b91c1c",
        //             neutral: "#f3f4f6",
        //             "base-100": "#ffffff",
        //             info: "#3D72F0",
        //             success: "#84cc16",
        //             warning: "#eab308",
        //             error: "#ef4444",
        //         },
        //         darkness: {
        //             primary: "#dc2626",
        //             secondary: "#f3f4f6",
        //             accent: "#b91c1c",
        //             neutral: "#111827",
        //             "base-100": "#1f2937",
        //             info: "#3D72F0",
        //             success: "#84cc16",
        //             warning: "#eab308",
        //             error: "#ef4444",
        //         },
        //     },
        //     "light",
        //     "dark",
        //     "cupcake",
        //     "bumblebee",
        //     "emerald",
        //     "corporate",
        //     "synthwave",
        //     "retro",
        //     "cyberpunk",
        //     "valentine",
        //     "halloween",
        //     "garden",
        //     "forest",
        //     "aqua",
        //     "lofi",
        //     "pastel",
        //     "fantasy",
        //     "wireframe",
        //     "black",
        //     "luxury",
        //     "dracula",
        //     "cmyk",
        //     "autumn",
        //     "business",
        //     "acid",
        //     "lemonade",
        //     "night",
        //     "coffee",
        //     "winter",
        // ],
        base: true,
        utils: true,
        logs: true,
        rtl: false,
        prefix: "",
        //darkTheme: "darkness",
    },
};
