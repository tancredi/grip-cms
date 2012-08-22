/*globals app, $, Hogan, console */

app.implement(function () {
    'use strict';

    var self = {},
    conf = app.config.get('template'),
    templates = {};

    function setTemplate (ns, template) {
        app.declare(template, templates, ns.split('.'), false);
    }

    function parseTemplates () {
        $('script[data-template-ns]').each(function () {
            setTemplate($(this).attr('data-template-ns'), $(this).html());
        });
    }

    function getTemplate (nsString) {
        return app.utils.namespace.fetch(templates, nsString.split('.'));
    }

    function renderTemplate (templateNs, data) {
        return Hogan.compile(getTemplate(templateNs)).render(data);
    }

    function renderString (str, data) {
        return Hogan.compile(str).render(data);
    }

    function init () {
        parseTemplates();
    }

    $(function () {
        init();
    });

    self.set = setTemplate;
    self.get = getTemplate;
    self.render = renderTemplate;
    self.renderString = renderString;

    self.getAll = function () { return templates; };

    return self;
}, [ 'template' ], true);
