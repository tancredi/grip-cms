/*globals app */

app.implement(function (num, count) {
    'use strict';

    var numZeropad = num + '';

    while(numZeropad.length < count) {
        numZeropad = "0" + numZeropad;
    }
    return numZeropad;
}, [ 'utils', 'math', 'zeroPad' ], false);
