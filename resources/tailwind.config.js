const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            maxHeight: {
                '44': '11rem',
            },
        },
        fontFamily: {
            mono: ['Fira Mono', ...defaultTheme.fontFamily.mono],
            sans: ['Inter', ...defaultTheme.fontFamily.sans],
        },
    },
    plugins: [require('@tailwindcss/ui')],
};
