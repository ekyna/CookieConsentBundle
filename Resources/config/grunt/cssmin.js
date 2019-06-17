module.exports = function (grunt, options) {
    return {
        cookie_less: {
            files: [
                {
                    expand: true,
                    cwd: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/public/tmp/css',
                    src: ['*.css'],
                    dest: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/public/css',
                    ext: '.css'
                }
            ]
        }
    }
};
