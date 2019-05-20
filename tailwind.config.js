module.exports = {
  theme: {
    extend: {
      boxShadow: {
        default: '0 0 5px 0 rgba(0,0,0,0.08)'
      },
      colors: {
        default : 'var(--text-default-color)',

        grey : {
          light : '#F5F6F9',
          lighter : 'rgba(0,0,0,0.4)'          
        },
        blue : {
          light : '#47cdff',
          lighter : '#8ae2fe'  
        }
      },
    },
    backgroundColor: theme => ({
      page : 'var(--page-background-color)',
      card : 'var(--card-background-color)',
      button : 'var(--button-background-color)',
      nav : 'var(--nav-background-color)'
    })
  },
  variants: {},
  plugins: [
    function({ addComponents }) {
      const buttons = {
        '.btn': {
          padding: '.5rem 1rem',
          borderRadius: '.25rem',
          fontWeight: '600',
          backgroundColor: '#47cdff',
          color: '#fff',
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
          color : 'var(--text-default-color)'
        },
      };
      addComponents(cards)
    },
    

  ]
}
