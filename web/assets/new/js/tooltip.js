(function (document, $) {

    'use strict';

    function init() {
        $(document.body).tooltip({
            container: 'body',
            // trigger: 'click',
            selector: '.js-tooltip'
        });
    }

    $(document).ready(init);

}(document, jQuery));
