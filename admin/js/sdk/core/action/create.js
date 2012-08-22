/*globals app */

app.implement(function () {
    'use strict';

    var self = {},
    actions = {};

    function getAction (nsString) {
        return app.utils.namespace.fetch(actions, nsString.split('.'));
    }

    function callAction (nsString) {
        var func = getAction(nsString);
        return func();
    }

    function setAction (func, ns, evtType) {
        app.declare(func, actions, ns.split('.'), false);
        if (evtType !== null) {
            app.event.bind(evtType, '[data-action=' + ns + ']', func);
        }
    }

    self.set = setAction;
    self.get = getAction;
    self.call = callAction;

    return self;

}, [ 'action' ], true);
