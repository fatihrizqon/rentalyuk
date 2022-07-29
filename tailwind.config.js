/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    container: {
      center: true,
      padding: "16px",
    },
    extend: {
      colors: {
        primary: "#2962FF",
        secondary: "#6C757D",
        success: "#00C853",
        info: "#00B0FF",
        warning: "#FFAB00",
        danger: "#D50000",
        redfire: "#C51C21",
        amber: "#FFAB00",
        redruby: "#9D0B28",
        redluminous: "#FF004D",
        redwine: "#5A082D",
        bluebell: "#9BA5C9",
        blackeerie: "#212121",
        blacksmoky: "#190207",
        fog: "#EAEAEA",
        gold: "#DAA250",
      },
      screens: {
        "2xl": "1320px",
      },
    },
  },
  plugins: [require('@tailwindcss/forms')],
}
