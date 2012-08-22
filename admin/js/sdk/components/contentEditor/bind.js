/*globals app, $, qq, tinyMCE */

$(function () {
    'use strict';

    var conf = app.config.get('components.contentEditor');

    function replaceTextareas () {
        tinyMCE.init($.extend({
            mode: "textareas"
        }, conf.editorSettings));
    }

    function initialise () {
        replaceTextareas();
    }

    $(initialise);
});