import typography from '@tailwindcss/typography'

export default {
  theme: {
    extend: {
      fontFamily: {
        sans: ['Arial', 'sans-serif'],
      },
      fontSize: {
        sm: '0.6rem',
        base: '0.8rem',
        xl: '1rem',
        '2xl': '1.363rem',
        '3xl': '1.553rem',
        '4xl': '1.841rem',
        '5xl': '2.352rem',
      }
    },
  },
  plugins: [typography],
  content: [
    './resources/views/reports/*.blade.php',
    './resources/views/reports/**/*.blade.php',
  ],
}
