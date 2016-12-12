(function (document, window, $) {

    'use strict';

    var timeout = 0;
    var docEl = document.documentElement;
    var map = {
        '320': 7,
        '420': 9,
        '500': 10,
        '530': 11,
        '580': 12,
        '720': 13,
        '860': 15,
        '900': 16,
        '1070': 19,
        '1100': 20,
        '9999': 20,
    };
    var visibleBoats = 7;
    var $buttons = $('.js-boat-counter-answer');

    function bindEvents() {
        window.addEventListener('resize', handleResize, false);
    }

    function handleResize() {
        clearTimeout(timeout);
        timeout = setTimeout(matchWidth, 300);
    }

    function matchWidth() {
        var docWidth = docEl.clientWidth;
        var matched = '320';

        Object.keys(map).some(function(el, idx) {
            var condition = docWidth < parseInt(el, 10);

            if (condition) {
                matched = Object.keys(map)[idx == 0 ? 0 : idx -1];
            }

            return condition;
        });

        if (map[matched] !== visibleBoats) {
            visibleBoats = map[matched];
            $buttons.eq(0).html(visibleBoats);
            $buttons.eq(1).html(visibleBoats + 1);
            $buttons.eq(2).html(visibleBoats + 2);
        }
    }

    function init() {
        bindEvents();
        matchWidth();
        $('.js-boat-counter').addClass('is-ready');
    }

    $(document).ready(init);

}(document, window, jQuery));
