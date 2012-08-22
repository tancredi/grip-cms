/*globals app */

app.declare = function (target, root, nsArr, exec) {
    'use strict';

    var i, curr = root, checked = [root];

    function processNs () {
        for (i = 0; i < nsArr.length; i += 1) {
            var ns = nsArr[i];

            if (i + 1 === nsArr.length) {
                if (typeof curr[ns] === 'undefined') {
                    curr[ns] = (exec) ? target() : target;
                    return;
                } else {
                    throw('Namespace duplicated: ' + nsArr.join('.'));
                }
            }

            if (typeof curr[ns] === 'undefined') {
                curr[ns] = {};
            }
            curr = curr[ns];
        }
    }

    processNs();
};



app.declare(function (func, nsArr, exec) {
    'use strict';

    app.declare(func, app, nsArr, exec);
}, app, [ 'implement' ], false);



app.declare(function (root, nsArr) {
    'use strict';

    var i, curr = root, checked = [root], ns;

    for (i = 0; i < nsArr.length; i += 1) {
        ns = nsArr[i];

        if (i + 1 === nsArr.length) {
            if (typeof curr[ns] !== 'undefined') {
                return curr[ns];
            } else {
                throw('Namespace fetch failed: ' + nsArr.join('.'));
            }
        }

        if (typeof curr[ns] === 'undefined') {
            throw('Namespace fetch failed: ' + nsArr.join('.'));
        }
        curr = curr[ns];
    }
}, app, [ 'utils', 'namespace', 'fetch' ], false);
