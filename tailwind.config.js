/** @type {import('tailwindcss').Config} */
export default {
  daisyui: {
    themes: ['none'],
  },
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'text': {
          50: 'rgb(var(--text-50))',
          100: 'rgb(var(--text-100))',
          200: 'rgb(var(--text-200))',
          300: 'rgb(var(--text-300))',
          400: 'rgb(var(--text-400))',
          500: 'rgb(var(--text-500))',
          600: 'rgb(var(--text-600))',
          700: 'rgb(var(--text-700))',
          800: 'rgb(var(--text-800))',
          900: 'rgb(var(--text-900))',
          950: 'rgb(var(--text-950))',
        },
        'background': {
          50: 'rgb(var(--background-50))',
          100: 'rgb(var(--background-100))',
          200: 'rgb(var(--background-200))',
          300: 'rgb(var(--background-300))',
          400: 'rgb(var(--background-400))',
          500: 'rgb(var(--background-500))',
          600: 'rgb(var(--background-600))',
          700: 'rgb(var(--background-700))',
          800: 'rgb(var(--background-800))',
          900: 'rgb(var(--background-900))',
          950: 'rgb(var(--background-950))',
        },
        'primary': {
          50: 'rgb(var(--primary-50))',
          100: 'rgb(var(--primary-100))',
          200: 'rgb(var(--primary-200))',
          300: 'rgb(var(--primary-300))',
          400: 'rgb(var(--primary-400))',
          500: 'rgb(var(--primary-500))',
          600: 'rgb(var(--primary-600))',
          700: 'rgb(var(--primary-700))',
          800: 'rgb(var(--primary-800))',
          900: 'rgb(var(--primary-900))',
          950: 'rgb(var(--primary-950))',
        },
        'secondary': {
          50: 'rgb(var(--secondary-50))',
          100: 'rgb(var(--secondary-100))',
          200: 'rgb(var(--secondary-200))',
          300: 'rgb(var(--secondary-300))',
          400: 'rgb(var(--secondary-400))',
          500: 'rgb(var(--secondary-500))',
          600: 'rgb(var(--secondary-600))',
          700: 'rgb(var(--secondary-700))',
          800: 'rgb(var(--secondary-800))',
          900: 'rgb(var(--secondary-900))',
          950: 'rgb(var(--secondary-950))',
        },
        'accent': {
          50: 'rgb(var(--accent-50))',
          100: 'rgb(var(--accent-100))',
          200: 'rgb(var(--accent-200))',
          300: 'rgb(var(--accent-300))',
          400: 'rgb(var(--accent-400))',
          500: 'rgb(var(--accent-500))',
          600: 'rgb(var(--accent-600))',
          700: 'rgb(var(--accent-700))',
          800: 'rgb(var(--accent-800))',
          900: 'rgb(var(--accent-900))',
          950: 'rgb(var(--accent-950))',
        },
        'error': {
          700: 'rgb(var(--error))',
        },
        'success': {
          700: 'rgb(var(--success))',
        },
        'badge': {
          800: 'rgb(var(--badge))'
        }
      },
      fontFamily: {
        'pp-neue-book': ['PP Neue Montreal Book'],
        'pp-neue-italic': ['PP Neue Montreal Italic'],
        'pp-neue-thin': ['PP Neue Montreal Thin'],
        'pp-neue-medium': ['PP Neue Montreal Medium'],
        'pp-neue-semibold-italic': ['PP Neue Montreal SemiBold italic'],
        'pp-neue-bold': ['PP Neue Montreal Bold'],
        'humane-thin': ['Humane Thin'],
        'humane-semibold': ['Humane SemiBold'],
        'humane-regular': ['Humane Regular'],
        'humane-medium': ['Humane Medium'],
        'humane-light': ['Humane Light'],
        'humane-extralight': ['Humane ExtraLight'],
        'humane-bold': ['Humane Bold'],
      },
      fontWeight: {
        200: '200',
        300: '300',
        400: '400',
        500: '500',
        700: '700',
        800: '800',
        900: '900',
      },
      fontStyle: {
        italic: 'italic',
        normal: 'normal',
      },
    },
  },
  plugins: [
    function ({ addUtilities }) { 
      const newUtilities = {
        '.main-theme': {
          fontFamily: '"PP Neue Montreal Medium"',
          width: '100vw',
          height: '100vh',
          color: 'rgb(var(--text-700))',
          background: 'rgb(var(--background-200))',
          lineHeight: '1.6',
        },

        '.utils-form': {
          fontFamily: 'PP Neue Montreal Medium',
          backgroundColor: 'rgb(var(--background-100))',
          padding: '1.25rem',
          borderRadius: '0.313rem',
          boxShadow: '0 0 0.625rem rgba(0, 0, 0, 0.1)',
          maxWidth: '37.5rem',
          margin: '4rem auto',
          // ***
        },
        '.utils-algorithm-select': {
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          marginBottom: '2rem',
        },

        '.utils-title': {
          textAlign: 'center',
          fontFamily: 'Humane Bold',
          fontSize: '6.5rem',
        },

        '.utils-subtitle': {
          textTransform: 'capitalize',
          fontWeight: '700',
        },

        '.utils-important': {
          padding: '0.325rem',
          borderRadius: '1.1rem',
          margin: '0.300rem',
          fontSize: '1rem',
          fontFamily: 'PP Neue Montreal Medium',
          fontStyle: 'italic',
          textAlign: 'center',
          background: 'rgb(var(--accent-300))',
          color: 'rgb(var(--text-600))',
          fontWeight: '700',
        },

        '.utils-form-wrapper': {
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
        },

        '.utils-process-form': {
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
          marginBottom: '10px',
          border: '1px solid var(--accent-200)',
          padding: '10px',
          borderRadius: '5px',
          background: 'rgb(var(--background-50))',
        },
        '.util-priority-input': {
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
          marginBottom: '7.5px',
          border: '1px solid var(--accent-200)',
          padding: '10px',
          borderRadius: '5px',
          background: 'rgb(var(--background-50))',
        },
        '.button-wrapper': {
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          margin: '2rem',
          textTransform: 'uppercase',
          fontFamily: 'PP Neue Montreal Bold',
          fontSize: '4rem',
          border: '12px solid var(--accent-700)',
        },
        '.utils-option': {
          fontFamily: 'PP Neue Montreal Medium',
        }


      }
      addUtilities(newUtilities, ['responsive', 'hover']);
    }
  ],
}