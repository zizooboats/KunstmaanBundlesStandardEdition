(function (document, $) {

    'use strict';

    function init() {

        $('[data-carousel]:not(.owl-carousel--disabled)').each(function () {
            var $el = $(this);
            var config = $el.data('config');
            var owlDefaultConfig = {
                afterInit: function($el) {
                    $el.addClass('is-loaded');
                }
            };
            var owlUserConfig = $el.data('carousel');
            var owlConfig = $.extend({}, owlDefaultConfig, owlUserConfig);

            if (config && config.minWidth) {
                if (document.documentElement.clientWidth >= config.minWidth) {
                    $el.owlCarousel(owlConfig);
                }
            } else {
                $el.owlCarousel(owlConfig);
            }
        });

    }

    radio('ajaxSuccess').subscribe(init);
    radio('carouselInit').subscribe(init);

    $(document).ready(init);

}(document, jQuery));
