/*globals app, $ */

app.implement(function (wrapper, conf, onChange) {
    'use strict';

    var self = {},
    labels = wrapper.find(conf.selectors.labels),
    tabs = wrapper.find(conf.selectors.tabs),
    current;

    function openTab (tabId) {
        labels.add(tabs).removeClass(conf.classNames.active);
        labels.eq(tabId).add(tabs.eq(tabId)).addClass(conf.classNames.active);
        onChange();
    }

    function getCurrent () {
        if (labels.filter(conf.selectors.active).length !== 0) {
            openTab(labels.filter(conf.selectors.active).index());
        } else {
            openTab(0);
        }
    }

    function onLabelClick (evt) {
        /*jshint validthis: true */
        openTab($(this).index());
        evt.preventDefault();
    }

    function bindLabelClick () {
        labels.on('click', onLabelClick);
    }

    function init () {
        getCurrent();
        bindLabelClick();
    }

    init();

    return self;

}, [ 'ui', 'tabs', 'create' ], false);
