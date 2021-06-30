module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './resources/**/*.js'
    ],
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                'sans': ['Lato', 'ui-sans'],
                'mono': ['IBM Plex Mono', 'ui-monospace'],
                'serif': ['ui-serif'],
                'display': ['Lato'],
                'body' : ['Lato']
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
    ],
}
