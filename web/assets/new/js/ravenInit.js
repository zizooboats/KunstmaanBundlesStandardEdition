(function() {
    if (ENV === 'prod') {
        if (typeof Raven === 'object') {
            Raven
                .config('https://b71f5ad39adf447d990a29ddc4d57214@app.getsentry.com/66876', {
                    whitelistUrls: [
                        /zizoo\.com/,
                        /d1pkcile4c5gsr\.cloudfront\.net/
                    ],
                    includePaths:  [
                        /https?:\/\/zizoo\.com/,
                        /https?:\/\/www\.zizoo\.com/,
                        /https?:\/\/d1pkcile4c5gsr\.cloudfront\.net/
                    ]
                })
                .install();
        } else {
            console.error('Raven.js not included');
        }
    }
})();
