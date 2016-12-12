(function ($) {

    'use strict';

    function init() {
        $('.js-accordion').on('click', '.js-accordion-toggler', function() {
            var $trigger = $(this);
            var $item = $trigger.closest('.js-accordion-item');
            var openClass = 'is-open';

            if ($item.hasClass(openClass)) {
                $item.removeClass(openClass);
            } else {
                $item.siblings().removeClass(openClass);
                $item.addClass(openClass);
            }
        });
    }

    $(document).ready(init);

}(jQuery));
