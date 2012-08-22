/*globals app */

app.config.set(function () {
    'use strict';

    var selectors = {
        validationForm: '[data-validates]',
        errorMessage: '.validation-error'
    };

    return {
        selectors: selectors
    };
}, [ 'form' ]);
