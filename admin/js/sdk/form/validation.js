/*globals app, $ */

app.implement(function (form) {
    'use strict';

    var self = {},
    conf = app.config.get('form');

    function getInputLabel (input) {
        return input.closest('form').find('label[for="' + input.attr('name') + '"]');
    }

    function resetError (input) {
        var label = getInputLabel(input);
        label.find(conf.selectors.errorMessage).remove();
    }

    function displayError (msg, input) {
        var label = getInputLabel(input);
        if (label.find(conf.selectors.errorMessage).length !== 0) {
            resetError(input);
        }
        label.append(app.template.render('ui.validation.error', { message: msg }));
    }

    function validateEmail (string) {
        var lastAtPos = string.lastIndexOf('@'), lastDotPos = string.lastIndexOf('.');
        return (lastAtPos < lastDotPos && lastAtPos > 0 && string.indexOf('@@') === -1 && lastDotPos > 2 && (string.length - lastDotPos) > 2);
    }

    function testRule (input, rule, ruleVal) {
        var validates = true;
        switch (rule) {
            case 'minLength':
                if (input.val().length < parseInt(ruleVal, 10)) {
                    validates = false;
                    displayError('Must be at least ' + ruleVal + ' characters long', input);
                }
            break;
            case 'type':
                if (ruleVal === 'email') {
                    validates = validateEmail(input.val());
                    displayError('Needs to be a valid email address', input);
                }
        }
        return validates;
    }

    function parseRules (rulesString) {
        var rules = {}, rulesArr = rulesString.split(','), i, curr;
        for (i = 0; i < rulesArr.length; i += 1) {
            curr = rulesArr[i].split(':');
            rules[app.utils.string.trimSpaces(curr[0])] = app.utils.string.trimSpaces(curr[1]);
        }

        return rules;
    }

    function validateField (input, rules) {
        var i;
        for (i in rules) {
            if (rules.hasOwnProperty(i)) {
                if (testRule(input, i, rules[i]) === false) {
                    return false;
                }
            }
        }
        resetError(input);
        return true;
    }

    

    function validateForm (form) {
        var validates = true, rules;
        form.find('input').each(function () {
            if (typeof $(this).attr('data-validate') !== 'undefined') {
                rules = parseRules($(this).attr('data-validate'));
                validates = validateField($(this), rules);
            }
        });
        return validates;
    }

    return validateForm(form);

}, [ 'form', 'validate' ], false);
