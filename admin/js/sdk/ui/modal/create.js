/*globals app, $, window */

app.implement(function (content) {
    'use strict';

    var self = {},
    conf = app.config.get('ui.modal'),
    element,
    inner,
    isOpen = false,
    closeButton;

    function updatePosition () {
        var screenW = $(window).width(), screenH = $(window).height();
        inner.css({
            position: 'absolute',
            left: screenW / 2 - inner.outerWidth() / 2,
            top: screenH / 2 - inner.outerHeight() / 2
        });
    }

    function openModal (content, settings) {
        settings.content = content;
        if (!isOpen) {
            element = $(app.template.render('ui.modal.window', settings)).appendTo('body');
            inner = element.find(conf.selectors.inner);
            closeButton = element.find(conf.selectors.closeButton);
            updatePosition();
            bindLoad();
            bindClick();
            bindResize();
            $('body').css('overflow', 'hidden');
            isOpen = true;
        } else {
            throw 'ui.modal.open bubbled';
        }
    }

    function closeModal () {
        if (isOpen) {
            element.remove();
            $('body').css('overflow', 'auto');
            isOpen = false;
        } else {
            throw 'ui.modal.close called with no open modal';
        }
    }

    function refreshModal () {
        updatePosition();
    }

    function onClick (evt) {
        if ($(evt.target).closest(inner).length === 0 && evt.target !== inner) {
            closeModal();
        }
    }

    function bindResize () {
        $(window).on('resize', refreshModal);
    }

    function bindClick () {
        element.on('click', onClick);
        closeButton.on('click', closeModal);
    }

    function bindLoad () {
        $(window).on('load', refreshModal);
    }

    function bindKeyPress () {
        app.event.bind('keydown', null, function (evt) {
            if (evt.keyCode === 27 && isOpen === true) { // ESC
                closeModal();
            }
        });
    }

    function init () {
        bindKeyPress();
    }

    init();

    self.open = openModal;
    self.close = closeModal;
    self.refresh = refreshModal;

    return self;

}, [ 'ui', 'modal' ], true);
