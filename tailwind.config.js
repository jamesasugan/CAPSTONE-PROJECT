/** @type {import('tailwindcss').Config} */
module.exports = {
  daisyui: {
    themes: ["light", "dark"],
  },
  content: ["./src/**/*.{html,js}"],
  darkMode: "class", // Enable dark mode support and use 'class' strategy.
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
};
