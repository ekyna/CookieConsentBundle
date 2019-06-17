module.exports = function (grunt, options) {
    return {
        cookie_less: {
            files: ['src/Ekyna/Bundle/CookieConsentBundle/Resources/private/less/**/*.less'],
            tasks: ['less:cookie', 'copy:cookie_less', 'clean:cookie_less'],
            options: {
                spawn: false
            }
        },
        cookie_js: {
            files: ['src/Ekyna/Bundle/CookieConsentBundle/Resources/private/js/**/*.js'],
            tasks: ['copy:cookie_js'],
            options: {
                spawn: false
            }
        }
    }
};
