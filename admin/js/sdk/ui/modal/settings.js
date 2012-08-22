/*globals app */

app.config.set(function () {
    'use strict';

    var selectors = {
        modal: '.modal',
        inner: '.inner',
        closeButton: 'a.close'
    };

    return {
        selectors: selectors
    };
}, [ 'ui', 'modal' ]);
