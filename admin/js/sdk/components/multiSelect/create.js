/*globals app, $, window, audiojs */

app.implement(function (element) {
    'use strict';

    var self = {},
    conf = app.config.get('components.multiSelect'),
    entries = [],
    lists = {},
    input;

    function getElements () {
        lists.selected = element.find(conf.selectors.listSelected);
        lists.available = element.find(conf.selectors.listAvailable);
        lists.all = lists.selected.add(lists.available);
        input = element.find(conf.selectors.input);
    }

    function parseEntries () {
        lists.all.find(conf.selectors.entry).each(function () {
            var entry = $(this);
            entries.push({
                id: entry.attr('data-id'),
                text: entry.text(),
                selected: (entry.closest(conf.selectors.listAvailable).length === 0)
            });
        });
    }

    function updateLists () {
        var i, entry, entryElement, selectionCsv = '';

        lists.all.html('');

        for (i = 0; i < entries.length; i += 1) {
            entry = entries[i];
            entryElement = $('<li></li>').attr('data-id', entry.id).text(entry.text);
            if (entry.selected === true) {
                entryElement.appendTo(lists.selected);
                selectionCsv += entry.id + ',';
            } else {
                entryElement.appendTo(lists.available);
            }
        }

        if (selectionCsv.length !== 0) {
            selectionCsv = selectionCsv.substr(0, selectionCsv.length - 1);
        }

        input.val(selectionCsv);
    }

    function getEntry (id) {
        var i;
        for (i = 0; i < entries.length; i += 1) {
            if (id === entries[i].id) {
                return entries[i];
            }
        }
        return null;
    }

    function toggleEntry (id) {
        var entry = getEntry(id);
        entry.selected = !entry.selected;
    }

    function onEntryClick (e) {
        toggleEntry($(this).attr('data-id'));
        updateLists();
        e.preventDefault();
    }

    function bindEntryClick () {
        element.on('click', conf.selectors.entry, onEntryClick);
    }

    function init () {
        getElements();
        parseEntries();
        updateLists();
        bindEntryClick();
    }

    init();

    return self;

}, [ 'components', 'multiSelect', 'create' ], false);
