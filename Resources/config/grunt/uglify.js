module.exports = function (grunt, options) {
    return {
        cookie_js: {
            files: [{
                expand: true,
                cwd: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/private/js',
                src: ['*.js', '**/*.js'],
                dest: 'src/Ekyna/Bundle/CookieConsentBundle/Resources/public/js'
            }]
        }
    }
};
