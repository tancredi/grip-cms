/*globals app, $, qq */

$(function () {
    'use strict';

    var conf = app.config.get('components.fileUploader'),
    mainConf = app.config.get('main');

    function createFileUploader (element, input, multiple) {
        var uploader = new qq.FileUploader({
            element: element[0],
            action: '/' + mainConf.root + 'index.php/admin/ws/file_upload',
            debug: true,
            multiple: multiple,
            onComplete: function (id, fileName, response) {
                if (input.val().length > 0) {
                    input.val(input.val() + ',' + response.file);
                } else {
                    input.val(response.file);
                }
            }
        });
    }

    function replaceFileInputs () {
        $(conf.selectors.fileInput).each(function () {
            var target = $(this), input, element, inputName = target.attr('name'), inputData,
            multiple = target.hasClass(conf.classNames.multiFile);

            inputData = {
                name: inputName,
                value: target.val()
            };

            target.replaceWith(app.template.render('components.fileUploader', inputData));
            input = $('input[type="hidden"][name="' + inputName + '"]');
            element = input.prev();
            createFileUploader(element, input, multiple);
        });
    }

    function initialise () {
        replaceFileInputs();
    }

    // $(initialise);

});