/*globals app */

app.implement(function (string) {
    'use strict';

    return string.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}, [ 'utils', 'string', 'trimSpaces' ], false);
