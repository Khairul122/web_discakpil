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
        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        gov: {
          blue: {
            950: '#0F172A',
            900: '#1E3A8A', // Modern royal blue dark
            800: '#2563EB', // Primary brand blue (bright & premium)
            700: '#3B82F6', // Vibrant bright blue
            600: '#60A5FA', // Sky blue
            100: '#EFF6FF', // Soft ice-blue backdrop tint
          },
          gold: {
            600: '#D97706',
            400: '#F59E0B',
          },
          maroon: {
            700: '#EF4444', // Cleaner bright red
          },
          green: {
            700: '#10B981', // Cleaner bright emerald green
          },
        },
        surface: {
          page: '#F8FAFC',
          card: '#FFFFFF',
        },
      },
      boxShadow: {
        'soft-raised': '0 10px 30px -10px rgba(79, 70, 229, 0.06), 0 1px 3px rgba(0, 0, 0, 0.02), 0 0 0 1px rgba(241, 245, 249, 1)',
        'soft-raised-sm': '0 4px 12px -2px rgba(79, 70, 229, 0.04), 0 0 0 1px rgba(241, 245, 249, 0.8)',
        'soft-raised-lg': '0 20px 40px -15px rgba(79, 70, 229, 0.08), 0 1px 10px rgba(0, 0, 0, 0.01), 0 0 0 1px rgba(241, 245, 249, 1)',
        'soft-pressed': 'none',
        'soft-pressed-sm': 'none',
        'soft-focus': '0 0 0 4px rgba(37, 99, 235, 0.15)',
      },
      borderRadius: {
        'gov': '14px',
        'gov-lg': '20px',
      },
    },
  },
  plugins: [],
}
