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
    darkMode: "class", // or 'media' or 'class'
    theme: {
        screens: {
            xs: "614px",
            sm: "1002px",
            md: "1022px",
            lg: "1092px",
            xl: "1280px",
        },
        extend: {
            animation: {
                "spin-fast": "spin 0.7s linear infinite",
            },
            colors: {
                dim: {
                    50: "#5F99F7",
                    100: "#5F99F7",
                    200: "#38444d",
                    300: "#202e3a",
                    400: "#253341",
                    500: "#5F99F7",
                    600: "#5F99F7",
                    700: "#192734",
                    800: "#162d40",
                    900: "#15202b",
                },
            },
            width: {
                68: "68px",
                88: "88px",
                275: "275px",
                290: "290px",
                350: "350px",
                600: "600px",
            },
        },
    },
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
        base: false,
        utils: true,
        logs: true,
        rtl: false,
        prefix: "",
        //darkTheme: "darkness",
    },
};
