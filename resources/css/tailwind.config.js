const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            animation: {
                glow: 'glow 2s ease-in-out infinite',
            },
            keyframes: {
                glow: {
                    '0%, 100%': { boxShadow: '0 0 5px -5px rgba(254, 243, 199, 0.6)' },
                    '50%': { boxShadow: '0 0 5px 5px rgba(254, 243, 199, 0.6)' },
                },
            },
            maxHeight: {
                '44': '11rem',
            },
        },
        fontFamily: {
            mono: ['Fira Mono', ...defaultTheme.fontFamily.mono],
            sans: ['Inter', ...defaultTheme.fontFamily.sans],
        },
    },
    purge: {
        content: [
            './app/**/*.php',
            './resources/**/*.html',
            './resources/**/*.js',
            './resources/**/*.jsx',
            './resources/**/*.ts',
            './resources/**/*.tsx',
            './resources/**/*.php',
            './resources/**/*.vue',
            './resources/**/*.twig',
        ],
        options: {
            defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
