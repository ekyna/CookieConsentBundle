module.exports = function (grunt, options) {
    return {
        cookie_less: { // For watch:cookie_less
            files: [
                {
                    expand: true,
                    cwd: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/public/tmp/css',
                    src: ['**'],
                    dest: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/public/css'
                }
            ]
        },
        cookie_js: { // For watch:cookie_js
            files: [
                {
                    expand: true,
                    cwd: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/private/js',
                    src: ['**'],
                    dest: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/public/js'
                }
            ]
        }
    }
};
