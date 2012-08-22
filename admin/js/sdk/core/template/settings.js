/*globals app */

app.config.set(function () {
    'use strict';

    return {
        templatesRequest: [

            { path: 'ui/modal', ns: 'ui.modal' },
            { path: 'ui/tooltip', ns: 'ui.tooltip' },
            { path: 'ui/validation/error', ns: 'ui.validation.error' },

            { path: 'components/pixomatic/canvas', ns: 'pixomatic.canvas' },
            { path: 'components/pixomatic/editor-wrapper', ns: 'pixomatic.editorWrapper' },
            { path: 'components/pixomatic/editor', ns: 'pixomatic.editor' },

            { path: 'components/signup-modal', ns: 'components.signup.modal' }

        ]
    };
}, [ 'template' ]);
