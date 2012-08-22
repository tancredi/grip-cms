/*globals app, $, qq */

(function () {
    'use strict';
    
    var conf = app.config.get('components.multiSelect');

    function init () {
    	$(conf.selectors.main).each(function () {
    		app.components.multiSelect.create($(this));
    	});
    }

    $(init);

})();