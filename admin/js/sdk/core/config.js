/*globals app */

app.implement(function () {
    'use strict';

    var self = {};

    function setConfig (func, nsArr) {
        nsArr.splice(0, 0, 'config');
        app.implement(func, nsArr, false);
    }

    function getConfig (ns) {
        var i, nsArr = ns.split('.'), curr = app.config;
            for (i = 0; i < nsArr.length; i += 1) {
            curr = curr[nsArr[i]];
        }
        return curr();
    }

    self.set = setConfig;
    self.get = getConfig;

    return self;
}, [ 'config' ], true);
