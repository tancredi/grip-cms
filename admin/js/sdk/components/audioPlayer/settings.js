/*globals app */

app.config.set(function () {
    'use strict';

    var selectors = {
        main: '.component.audio-player'
    };

    return {
        selectors: selectors
    };

}, [ 'components', 'audioPlayer' ]);
