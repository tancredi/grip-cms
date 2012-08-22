/*globals app, $, window */

app.implement(function (value) {
    'use strict';

    var self = {},
    mouse = { x: 0, y: 0 },
    conf = app.config.get('ui.tooltip'),
    element = $(''),
    alignment = conf.defaultAlignment,
    currentValue = null,
    win = $(window);

    function showTooltip (value) {
        if (value !== currentValue) {
            hideTooltip();
            createTooltip({ content: value });
            currentValue = value;
        }
    }

    function hideTooltip () {
        $(conf.selectors.tooltip).remove();
        currentValue = null;
    }

    function createTooltip (data) {
        element = $(app.template.render('ui.tooltip', data))
        .appendTo('body');
        updatePosition();
    }

    function unsetAlignmentClasses () {
        var i;
        for (i = 0; i < conf.classNames.alignment.length; i += 1) {
            element.removeClass(conf.classNames.alignment[i]);
        }
    }

    function setAlignmentClass (dir) {
        unsetAlignmentClasses();
        dir = (dir) ? 1 : 0;
        element.addClass(conf.classNames.alignment[dir]);
    }

    function updatePosX () {
        var x = mouse.x - element.outerWidth() / 2;
        if (x < conf.offset) {
            x = conf.offset;
        } else if (x + element.outerWidth() > win.width() - conf.offset) {
            x = win.width() - conf.offset - element.outerWidth();
        }
        element.css('left', x);
    }

    function updatePosY (dir) {
        var y = mouse.y;
        dir = (dir) ? 1 : 0;
        y = (dir === 0) ? y -= element.outerHeight() + conf.offset : y += conf.offset;
        element.css('top', y);
        if (y < 0 || y + element.outerHeight() > win.height()) {
            return false;
        }
        return true;
    }

    function updatePosition () {
        var isAvailable;

        if (element.length !== 0) {
            updatePosX();

            isAvailable = updatePosY(alignment);
            if (isAvailable) {
                setAlignmentClass(alignment);
            } else {
                updatePosY(!alignment);
                setAlignmentClass(!alignment);
            }
        }
    }

    function onMouseMove (evt) {
        mouse = { x: evt.pageX, y: evt.pageY };
        updatePosition();
    }

    function bindMouseMove () {
        app.event.bind('mousemove', '', onMouseMove);
    }

    function init () {
        bindMouseMove();
    }

    init();

    self.show = showTooltip;
    self.hide = hideTooltip;

    return self;

}, [ 'ui', 'tooltip' ], true);