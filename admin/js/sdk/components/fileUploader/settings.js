/*globals app */

app.config.set(function () {
    'use strict';

    var selectors = {
        main: '.component.file-uploader',
        fileInput: '.file-uploader-input'
    },
    classNames = {
        multiFile: 'multi'
    };

    return {
        selectors: selectors,
        classNames: classNames
    };

}, [ 'components', 'fileUploader' ]);
