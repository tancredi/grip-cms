/*globals app, $, Hogan, console */

app.implement(function () {
    'use strict';

    var self = {};

    function getFormAction (form) {
        var actionNs = form.attr('action');
        return (app.action.get(actionNs)) ? app.action.get(actionNs) : null;
    }

    function getFormData (form) {
        var dataArr = form.serializeArray(), dataObj = {}, i;
        for (i = 0; i < dataArr.length; i += 1) {
            dataObj[dataArr[i].name] = dataArr[i].value;
        }
        return dataObj;
    }

    function doFormAction (form) {
        var action = getFormAction(form);
        if (typeof action === 'function') {
            action(getFormData(form));
            return true;
        }
        return false;
    }

    self.getData = getFormData;
    self.action = {
        get: getFormAction,
        perform: doFormAction
    };

    return self;
}, [ 'form' ], true);
