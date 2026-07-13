/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './views/**/*.php',
    './template/**/*.php',
    './index.php'
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['Merriweather', 'ui-serif', 'Georgia', 'serif'],
      },
      colors: {
        gov: {
          blue: {
            950: '#0B1F3A',
            900: '#0F2B52',
            800: '#153B6E',
            700: '#1D4E8F',
            600: '#2563A8',
            100: '#E4ECF6',
          },
          gold: {
            600: '#B8860B',
            400: '#D4AF37',
          },
          maroon: {
            700: '#7A1F2B',
          },
          green: {
            700: '#1E6B3E',
          },
        },
        surface: {
          page: '#F4F6F9',
          card: '#F7F9FC',
        },
      },
      boxShadow: {
        'soft-raised': '6px 6px 14px rgba(15,43,82,0.10), -6px -6px 14px rgba(255,255,255,0.75)',
        'soft-raised-sm': '3px 3px 7px rgba(15,43,82,0.09), -3px -3px 7px rgba(255,255,255,0.7)',
        'soft-raised-lg': '10px 10px 24px rgba(15,43,82,0.12), -8px -8px 20px rgba(255,255,255,0.8)',
        'soft-pressed': 'inset 4px 4px 8px rgba(15,43,82,0.12), inset -4px -4px 8px rgba(255,255,255,0.6)',
        'soft-pressed-sm': 'inset 2px 2px 5px rgba(15,43,82,0.12), inset -2px -2px 5px rgba(255,255,255,0.6)',
        'soft-focus': '0 0 0 3px rgba(29,78,143,0.25), 3px 3px 7px rgba(15,43,82,0.09)',
      },
      borderRadius: {
        'gov': '12px',
        'gov-lg': '16px',
      },
    },
  },
  plugins: [],
}
