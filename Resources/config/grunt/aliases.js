module.exports = {
    'build:cookie': [
        'clean:cookie_pre',
        'less:cookie',
        'cssmin:cookie_less',
        'uglify:cookie_js',
        'clean:cookie_post'
    ]
};
