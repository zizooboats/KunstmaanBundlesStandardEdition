(function (document, $) {

    'use strict';

    function init() {
        $('.js-destination-trigger').on('click', function(e) {
            e.preventDefault();
            $('.js-destination-trigger').removeClass('is-selected');
            $(this).addClass('is-selected');

            $('.js-destination').addClass('u-hidden');
            $(this.getAttribute('data-target')).removeClass('u-hidden');
        });
    }

    $(document).ready(init);

}(document, jQuery));
