/*globals app */

app.config.set(function () {
    'use strict';

    var selectors = {
        main: '.multi-select',
        listSelected: 'ul.selected',
        listAvailable: 'ul.available',
        entry: 'li',
        input: 'input[type="hidden"]'
    };

    return {
        selectors: selectors
    };

}, [ 'components', 'multiSelect' ]);
