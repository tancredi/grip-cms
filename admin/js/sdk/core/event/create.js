/*globals app, $ */

app.implement(function () {
    'use strict';

    var self = {},
    actions = {},
    conf = app.config.get('event'),
    body;

    function getBody () {
        body = $('body');
    }

    function catchEvent (eventName, func) {
        body.on(conf.prefix + eventName, func);
    }

    function triggerEvent (eventName, data) {
        body.trigger(conf.prefix + eventName, data);
    }

    function bindEvent (evtType, selector, func) {
        $(function () {
            body.on(evtType, selector, func);
        });
    }

    function init () {
        getBody();
    }

    $(function () {
        init();
    });

    self.trigger = triggerEvent;
    self.on = catchEvent;
    self.bind = bindEvent;

    return self;

}, [ 'event' ], true);
