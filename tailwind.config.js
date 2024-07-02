/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,js,php}"],

  theme: {
    extend: {
      spacing: {
        '200': '1200px',
        '125': '720px',
        '100': '500px',
        'high':'90%',
        'halil':'40%'
      },

    },
  },
  plugins: [],
}

