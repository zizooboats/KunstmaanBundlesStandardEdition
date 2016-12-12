(function ($) {

    'use strict';

    function init() {
        $('.js-expandable__trigger').on('click', function (e) {
            var $el = $(this);
            var text = $el.text();
            var altText = $el.attr('data-alt-text');

            $el.closest('.expandable').toggleClass('is-expanded');
            $el.attr('data-alt-text', text);
            $el.text(altText);
        });
    }

    $(document).ready(init);

}(jQuery));
