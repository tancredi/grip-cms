/*globals app */

app.implement(function (string) {
    'use strict';

    return string.charAt(0).toUpperCase() + string.slice(1);
}, [ 'utils', 'string', 'capitalise' ], false);
