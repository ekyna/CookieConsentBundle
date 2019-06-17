module.exports = function (grunt, options) {
    // @see https://github.com/gruntjs/grunt-contrib-less
    return {
        cookie: {
            files: {
                'src/Ekyna/Bundle/CookieConsentBundle/Resources/public/tmp/css/cookie-consent.css': [
                    'src/Ekyna/Bundle/CookieConsentBundle/Resources/private/less/theme-default.less',
                    'src/Ekyna/Bundle/CookieConsentBundle/Resources/private/less/cookie-consent.less'
                ]
            }
        }
    }
};
