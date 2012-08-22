/*globals $, app */

$(function () {
    'use strict';

    var conf = app.config.get('ui.tabs.sections'), onChange;

    $(conf.selectors.wrapper).each(function () {
        onChange = ($(this).hasClass('content-tabs')) ? app.ui.tile.refresh : function () {};
        app.ui.tabs.create($(this), conf, onChange);
    });
});
