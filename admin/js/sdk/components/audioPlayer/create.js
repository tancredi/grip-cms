/*globals app, $, window, audiojs */

app.implement(function () {
    'use strict';

    var self = {},
    conf = app.config.get('components.audioPlayer');

    function createPlayers () {
        audiojs.events.ready(function () {
            var as = audiojs.createAll({
                createPlayer: {
                    markup: app.template.render('components.audioPlayer'),
                    playPauseClass: 'play-pause',
                    scrubberClass: 'scrubber',
                    progressClass: 'progress',
                    loaderClass: 'loaded',
                    timeClass: 'time',
                    durationClass: 'duration',
                    playedClass: 'played',
                    errorMessageClass: 'error-message',
                    playingClass: 'playing',
                    loadingClass: 'loading',
                    errorClass: 'error'
                }
            });
        });
    }

    function init () {
        createPlayers();
    }

    init();

    return self;

}, [ 'components', 'audioPlayer', 'initialise' ], false);
