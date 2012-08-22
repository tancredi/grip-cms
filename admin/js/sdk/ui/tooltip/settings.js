/*globals app */

app.config.set(function () {
    'use strict';

    var classNames = {
        alignment: [ 'align-top', 'align-bottom' ]
    },
    selectors = {
        tooltip: '.tooltip'
    };

    return {
        classNames: classNames,
        selectors: selectors,
        defaultAlignment: 0,
        offset: 15,
        attribute: 'data-tooltip'
    };
}, [ 'ui', 'tooltip' ]);
