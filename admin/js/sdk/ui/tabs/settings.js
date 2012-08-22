/*globals app */

app.config.set(function () {
    'use strict';

    var selectors = {
        wrapper: '.tabs-section',
        labels: '.labels>li',
        tabs: '.content>li',
        active: '.active'
    },
    classNames = {
        active: 'active'
    };

    return {
        selectors: selectors,
        classNames: classNames
    };
}, [ 'ui', 'tabs', 'sections' ]);
