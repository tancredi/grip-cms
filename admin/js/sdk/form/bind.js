/*globals app, $ */

$(function () {
    'use strict';

    var conf = app.config.get('form');

    function execFormAction (form) {
        var action = app.form.action.get(form);
        if (typeof action === 'function') {
            app.form.action.perform(form);
            return true;
        }
        return false;
    }

    function bindFormActions (form) {
        app.event.bind('submit', 'form', function (evt) {
        /*jshint validthis:true */
        
            var validates;

            if ($(this).is(conf.selectors.validationForm)) {
                validates = app.form.validate($(this));

                if (validates === false) {
                    return false;
                }
            }

            return !execFormAction($(this));
        });
    }

    function bindSubmits () {
        bindFormActions();
    }

    bindSubmits();
});