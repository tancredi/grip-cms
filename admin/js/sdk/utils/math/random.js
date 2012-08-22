/*globals app, floatVal */

app.implement(function (max) {
    'use strict';

    var randVal = Math.random() * max;
    return typeof floatVal === 'undefined' ? Math.round(randVal) : randVal.toFixed(floatVal);
}, [ 'utils', 'math', 'random' ], false);
