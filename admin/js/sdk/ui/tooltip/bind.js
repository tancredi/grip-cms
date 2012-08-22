/*globals $, app */

$(function () {
    'use strict';

    var conf = app.config.get('ui.tooltip');

    function onMouseEnter (element) {
        app.ui.tooltip.show(element.attr(conf.attribute));
    }

    function onMouseLeave () {
        app.ui.tooltip.hide();
    }

    function init () {
        var selector = '[' + conf.attribute + ']';
        $('a[title]').each(function () {
            $(this).attr(conf.attribute, $(this).attr('title'));
            $(this).removeAttr('title');
        });
        app.event.bind('mouseenter', selector, function () { onMouseEnter($(this)); });
        app.event.bind('mouseleave', selector, onMouseLeave);
    }

    init();

});
