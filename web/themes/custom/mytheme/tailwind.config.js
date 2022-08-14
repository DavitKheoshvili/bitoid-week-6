/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./templates/**/*.{html,twig,php}", "../../../modules/**/*.{html,twig,php}",],
  theme: {
    screens: {
      sm: '375px',
      md: '768px',
      lg: '1100px',
      xl: '1440px',
    },
    extend: {
      colors: {
        violet: '#5964E0',
        lightViolet: '#939BF4',
        veryDarkBlue: '#19202D',
        midnight: '#121721',
        lightGrey: '#F4F6F8',
        grey: '#9DAEC2',
        darkGrey: '#6E8098',
      }
    },
  },
  darkMode: "class",
  plugins: [],
  
}
