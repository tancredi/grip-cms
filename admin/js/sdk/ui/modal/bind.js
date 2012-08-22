/*globals $, app */

$(function () {
    'use strict';

    var conf = app.config.get('ui.modal'),
    dataTable = $(conf.selectors.main);

    function openModal (evt) {
        var link = $(this),
        modalType = link.attr('data-modal-type'),
        data = {
            url: link.attr('data-modal-url')
        };
        app.ui.modal.open(app.template.render('ui.modal.' + modalType, data), {});
        evt.preventDefault();
    }

    function bindEvents () {
        $('[data-modal-type]').on('click', openModal);
    }

    bindEvents();
    
});