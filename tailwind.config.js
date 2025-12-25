/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        'charcoal': {
          700: '#3d3d3d',
          800: '#2d2d2d',
          900: '#1a1a1a',
        },
        'yellow': {
          500: '#FFD60A',
        },
        'red': {
          500: '#E63946',
        },
        'offwhite': '#f8f8f8',
      },
    },
  },
  plugins: [],
}
