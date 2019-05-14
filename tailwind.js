module.exports = {
  theme: {
    extend: {
      boxShadow: {
        default: '0 0 5px 0 rgba(0,0,0,0.08)'
      },
      colors: {
        grey : {
          light : '#F5F6F9',
          lighter : 'rgba(0,0,0,0.4)'          
        },
        blue : {
          light : '#47cdff',
          lighter : '#8ae2fe'  
        }
      },
    }
  },
  variants: {},
  plugins: [
    function({ addComponents }) {
      const buttons = {
        '.btn': {
          padding: '.5rem 1rem',
          borderRadius: '.25rem',
          fontWeight: '600',
        },
        '.btn-blue': {
          backgroundColor: '#47cdff',
          color: '#fff',
          '&:hover': {
            backgroundColor: '#2779bd'
          },
        },
      };
      addComponents(buttons)
    },

    function({ addComponents }) {
      const cards = {
        '.cards': {
          backgroundColor : 'white',
          padding: '1.25rem',
          boxShadow : '0 0 5px 0 rgba(0,0,0,0.08)',
          borderRadius: '0.5rem',
        },
      };
      addComponents(cards)
    },
    

  ]
}
