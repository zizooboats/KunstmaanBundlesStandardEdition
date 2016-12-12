(function (document, $) {

    'use strict';

    $(document).on('change', '[data-select-accordion]', function (e) {
        var $element = $(e.target);
        var data = $element.data();
        var value = $element.val();

        if (data.target) {
            $(data.target).removeClass(data.selectAccordion);
            $('#' + value).addClass(data.selectAccordion);
        }

        e.preventDefault();
    });

}(document, jQuery));
