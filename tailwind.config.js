module.exports = {
    future: {
      // removeDeprecatedGapUtilities: true,
      // purgeLayersByDefault: true,
    },
    purge: [],
    theme: {
      extend: {
        colors: {
          dark: '#343A40',
          light: '#F5F5F5',
          graylight: '#E9ECEF',
          lighter: '#F8F9FA',
          darklight: '#3e454d',
          darker: '#262B2F',
          'gray-50': '#F9FAFB'
        },
        width: {
          'side': 'calc(100% - 16rem)'
        },
        maxWidth: {
          'sidebar': '16rem'
        },
        maxHeight: {
          '24': '6rem',
          '56': '14rem'
        },
        inset: {
          '6': '1.5rem',
          'full': '100%',
        }
      },
    },
    variants: {
      overflow: ['responsive', 'hover', 'focus'],
      transitionDuration: ['responsive', 'hover', 'focus'],
      transitionProperty: ['responsive', 'hover', 'focus'],
      visibility: ['responsive', 'hover', 'focus'],
    },
    plugins: [
      require('@tailwindcss/custom-forms'),
    ],
  }