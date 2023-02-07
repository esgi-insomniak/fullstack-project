/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './src/**/*.vue',
    './public/**/*.html',
    './src/**/*.css',
    './src/**/*.js',
  ],
  theme: {
    extend: {
      animation: {
        shine: "shine 1s",
      },
      keyframes: {
        shine: {
          "0%": { opacity: 0.5, left: "-125%" },
          "100%": { left: "125%" },
        },
      },
    },
  },
  plugins: [require('tailwind-scrollbar-hide')],
}
